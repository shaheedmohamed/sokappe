<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * عرض جميع المعاملات
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'wallet', 'project', 'bid'])
            ->orderBy('created_at', 'desc');

        // فلترة حسب النوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب طريقة الدفع
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // فلترة حسب المستخدم
        if ($request->filled('user_search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_search . '%')
                  ->orWhere('email', 'like', '%' . $request->user_search . '%');
            });
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->paginate(20);

        // إحصائيات سريعة
        $stats = [
            'total_transactions' => Transaction::count(),
            'pending_count' => Transaction::where('status', 'pending')->count(),
            'completed_count' => Transaction::where('status', 'completed')->count(),
            'failed_count' => Transaction::where('status', 'failed')->count(),
            'total_volume' => Transaction::where('status', 'completed')->sum('amount'),
            'pending_withdrawals' => Transaction::where('type', 'withdrawal')
                ->where('status', 'pending')->count(),
            'pending_deposits' => Transaction::where('type', 'deposit')
                ->where('status', 'pending')->count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'stats'));
    }

    /**
     * عرض تفاصيل معاملة
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'wallet', 'project', 'bid']);
        
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * تحديث حالة المعاملة
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $transaction->status;
            $newStatus = $request->status;

            // تحديث المعاملة
            $transaction->update([
                'status' => $newStatus,
                'notes' => $request->admin_notes,
                'processed_at' => in_array($newStatus, ['processing', 'completed']) ? now() : null,
                'completed_at' => $newStatus === 'completed' ? now() : null,
            ]);

            // معالجة تغيير الحالة
            $this->handleStatusChange($transaction, $oldStatus, $newStatus);

            DB::commit();

            return back()->with('success', 'تم تحديث حالة المعاملة بنجاح');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * الموافقة السريعة على المعاملة
     */
    public function approve(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            $oldStatus = $transaction->status;
            
            $transaction->update([
                'status' => 'completed',
                'processed_at' => now(),
                'completed_at' => now(),
                'notes' => 'تمت الموافقة من قبل الإدارة'
            ]);

            $this->handleStatusChange($transaction, $oldStatus, 'completed');

            DB::commit();

            return back()->with('success', 'تمت الموافقة على المعاملة بنجاح');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * رفض المعاملة
     */
    public function reject(Request $request, Transaction $transaction)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $transaction->status;
            
            $transaction->update([
                'status' => 'failed',
                'processed_at' => now(),
                'notes' => 'مرفوضة: ' . $request->reason
            ]);

            $this->handleStatusChange($transaction, $oldStatus, 'failed');

            DB::commit();

            return back()->with('success', 'تم رفض المعاملة');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * معالجة تغيير حالة المعاملة
     */
    private function handleStatusChange(Transaction $transaction, $oldStatus, $newStatus)
    {
        $wallet = $transaction->wallet;

        if ($transaction->type === Transaction::TYPE_DEPOSIT) {
            if ($newStatus === 'completed' && $oldStatus !== 'completed') {
                // إضافة الرصيد عند تأكيد الإيداع
                $wallet->increment('balance', $transaction->amount);
                $wallet->increment('total_earned', $transaction->amount);
                $wallet->update(['last_transaction_at' => now()]);
            }
        } elseif ($transaction->type === Transaction::TYPE_WITHDRAWAL) {
            if ($newStatus === 'completed' && $oldStatus !== 'completed') {
                // تأكيد السحب - المبلغ مجمد مسبقاً
                $wallet->decrement('pending_balance', $transaction->amount);
                $wallet->increment('total_withdrawn', $transaction->amount);
                $wallet->update(['last_transaction_at' => now()]);
            } elseif (in_array($newStatus, ['failed', 'cancelled']) && $oldStatus === 'pending') {
                // إلغاء السحب - إرجاع المبلغ المجمد
                $wallet->decrement('pending_balance', $transaction->amount);
                $wallet->increment('balance', $transaction->amount);
                $wallet->update(['last_transaction_at' => now()]);
            }
        }
    }

    /**
     * تصدير المعاملات
     */
    public function export(Request $request)
    {
        $query = Transaction::with(['user', 'wallet']);

        // تطبيق نفس الفلاتر
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $filename = 'transactions_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'ID', 'Transaction ID', 'User', 'Type', 'Amount', 'Fee', 'Net Amount', 
                'Currency', 'Status', 'Payment Method', 'Created At', 'Completed At'
            ]);

            // Data
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->transaction_id,
                    $transaction->user->name,
                    $transaction->type_description,
                    $transaction->amount,
                    $transaction->fee,
                    $transaction->net_amount,
                    $transaction->currency,
                    $transaction->status_description,
                    $transaction->payment_method,
                    $transaction->created_at->format('Y-m-d H:i:s'),
                    $transaction->completed_at ? $transaction->completed_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * إحصائيات مفصلة
     */
    public function analytics()
    {
        // إحصائيات عامة
        $totalStats = [
            'total_volume' => Transaction::where('status', 'completed')->sum('amount'),
            'total_fees' => Transaction::where('status', 'completed')->sum('fee'),
            'total_transactions' => Transaction::count(),
            'active_users' => User::whereHas('transactions')->count(),
        ];

        // إحصائيات حسب النوع
        $typeStats = Transaction::select('type', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->where('status', 'completed')
            ->groupBy('type')
            ->get();

        // إحصائيات شهرية (متوافق مع SQLite)
        $monthlyStats = Transaction::select(
                DB::raw("strftime('%Y', created_at) as year"),
                DB::raw("strftime('%m', created_at) as month"),
                DB::raw('count(*) as count'),
                DB::raw('sum(amount) as total')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // أكثر المستخدمين نشاطاً
        $topUsers = User::withCount('transactions')
            ->with(['transactions' => function($q) {
                $q->where('status', 'completed');
            }])
            ->having('transactions_count', '>', 0)
            ->orderBy('transactions_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.transactions.analytics', compact(
            'totalStats', 'typeStats', 'monthlyStats', 'topUsers'
        ));
    }
}
