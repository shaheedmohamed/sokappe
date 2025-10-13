<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * عرض صفحة المحفظة
     */
    public function index()
    {
        $user = Auth::user();
        
        // إنشاء محفظة إذا لم تكن موجودة
        $wallet = $user->wallet ?? Wallet::createForUser($user->id);
        
        // الحصول على آخر المعاملات
        $transactions = $wallet->transactions()
            ->with(['project', 'bid'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // إحصائيات المحفظة
        $stats = [
            'total_earned' => $wallet->total_earned,
            'total_withdrawn' => $wallet->total_withdrawn,
            'pending_balance' => $wallet->pending_balance,
            'transactions_count' => $wallet->transactions()->count(),
            'this_month_earned' => $wallet->transactions()
                ->where('type', Transaction::TYPE_DEPOSIT)
                ->where('status', Transaction::STATUS_COMPLETED)
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];
        
        return view('wallet.index', compact('wallet', 'transactions', 'stats'));
    }

    /**
     * عرض صفحة شحن الرصيد
     */
    public function deposit()
    {
        $wallet = Auth::user()->wallet ?? Wallet::createForUser(Auth::id());
        
        return view('wallet.deposit', compact('wallet'));
    }

    /**
     * معالجة طلب شحن الرصيد
     */
    public function processDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10|max:10000',
            'payment_method' => 'required|in:opay,bank_transfer,credit_card',
        ]);

        $user = Auth::user();
        $wallet = $user->wallet ?? Wallet::createForUser($user->id);
        
        try {
            DB::beginTransaction();
            
            // إنشاء معاملة إيداع معلقة
            $transaction = $wallet->transactions()->create([
                'user_id' => $wallet->user_id,
                'transaction_id' => 'TXN_' . time() . '_' . rand(1000, 9999),
                'type' => Transaction::TYPE_DEPOSIT,
                'amount' => $request->amount,
                'fee' => 0,
                'net_amount' => $request->amount,
                'currency' => $wallet->currency,
                'status' => Transaction::STATUS_PENDING,
                'payment_method' => $request->payment_method,
                'description' => 'شحن رصيد عبر ' . $request->payment_method,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            // هنا سيتم الربط مع OPay API
            if ($request->payment_method === 'opay') {
                // استدعاء خدمة OPay
                $paymentResult = $this->processOPayDeposit($transaction);
                
                if ($paymentResult['success']) {
                    $transaction->update([
                        'status' => Transaction::STATUS_PROCESSING,
                        'external_id' => $paymentResult['transaction_id'],
                        'gateway_response' => $paymentResult,
                    ]);
                    
                    DB::commit();
                    
                    return redirect()->route('wallet.index')
                        ->with('success', 'تم إرسال طلب الشحن بنجاح. سيتم تحديث رصيدك خلال دقائق.');
                } else {
                    throw new \Exception($paymentResult['message'] ?? 'فشل في معالجة الدفع');
                }
            }
            
            DB::commit();
            
            return redirect()->route('wallet.index')
                ->with('info', 'تم إنشاء طلب الشحن. يرجى إكمال عملية الدفع.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * عرض صفحة سحب الرصيد
     */
    public function withdraw()
    {
        $wallet = Auth::user()->wallet ?? Wallet::createForUser(Auth::id());
        
        return view('wallet.withdraw', compact('wallet'));
    }

    /**
     * معالجة طلب سحب الرصيد
     */
    public function processWithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50',
            'withdrawal_method' => 'required|in:opay,bank_transfer',
            'account_details' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        $wallet = $user->wallet ?? Wallet::createForUser($user->id);
        
        // التحقق من كفاية الرصيد
        if (!$wallet->hasBalance($request->amount)) {
            return back()->with('error', 'الرصيد غير كافي للسحب');
        }
        
        try {
            DB::beginTransaction();
            
            // حساب الرسوم (2% من المبلغ)
            $fee = $request->amount * 0.02;
            $netAmount = $request->amount - $fee;
            
            // إنشاء معاملة سحب معلقة
            $transaction = $wallet->transactions()->create([
                'user_id' => $wallet->user_id,
                'transaction_id' => 'TXN_' . time() . '_' . rand(1000, 9999),
                'type' => Transaction::TYPE_WITHDRAWAL,
                'amount' => $request->amount,
                'fee' => $fee,
                'net_amount' => $netAmount,
                'currency' => $wallet->currency,
                'status' => Transaction::STATUS_PENDING,
                'payment_method' => $request->withdrawal_method,
                'description' => 'سحب رصيد عبر ' . $request->withdrawal_method,
                'notes' => 'تفاصيل الحساب: ' . $request->account_details,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            // تجميد المبلغ من الرصيد المتاح
            $wallet->freezeBalance($request->amount, 'تجميد رصيد لطلب سحب #' . $transaction->id);
            
            DB::commit();
            
            return redirect()->route('wallet.index')
                ->with('success', 'تم إرسال طلب السحب بنجاح. سيتم مراجعته خلال 24 ساعة.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * عرض تفاصيل معاملة
     */
    public function showTransaction(Transaction $transaction)
    {
        // التحقق من الصلاحية
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بعرض هذه المعاملة');
        }
        
        return view('wallet.transaction', compact('transaction'));
    }

    /**
     * تحديث حالة المعاملة (للإدارة)
     */
    public function updateTransactionStatus(Request $request, Transaction $transaction)
    {
        // التحقق من صلاحيات الإدارة
        if (!Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح لك بهذا الإجراء');
        }
        
        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        try {
            DB::beginTransaction();
            
            $oldStatus = $transaction->status;
            $newStatus = $request->status;
            
            // تحديث حالة المعاملة
            $transaction->updateStatus($newStatus, $request->notes);
            
            // معالجة تغيير الحالة
            if ($oldStatus !== $newStatus) {
                $this->handleStatusChange($transaction, $oldStatus, $newStatus);
            }
            
            DB::commit();
            
            return back()->with('success', 'تم تحديث حالة المعاملة بنجاح');
            
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
            if ($newStatus === Transaction::STATUS_COMPLETED && $oldStatus !== Transaction::STATUS_COMPLETED) {
                // إضافة الرصيد عند تأكيد الإيداع
                $wallet->addBalance($transaction->amount, 'تأكيد إيداع #' . $transaction->id);
            }
        } elseif ($transaction->type === Transaction::TYPE_WITHDRAWAL) {
            if ($newStatus === Transaction::STATUS_COMPLETED && $oldStatus !== Transaction::STATUS_COMPLETED) {
                // تأكيد السحب - المبلغ مجمد مسبقاً
                $wallet->decrement('pending_balance', $transaction->amount);
                $wallet->increment('total_withdrawn', $transaction->amount);
            } elseif ($newStatus === Transaction::STATUS_FAILED || $newStatus === Transaction::STATUS_CANCELLED) {
                // إلغاء السحب - إرجاع المبلغ المجمد
                $wallet->unfreezeBalance($transaction->amount, 'إلغاء طلب سحب #' . $transaction->id);
            }
        }
    }

    /**
     * معالجة الدفع عبر OPay (مؤقت)
     */
    private function processOPayDeposit($transaction)
    {
        // هنا سيتم الربط مع OPay API الحقيقي
        // حالياً نرجع نتيجة وهمية للاختبار
        
        return [
            'success' => true,
            'transaction_id' => 'OPAY_' . time() . '_' . rand(1000, 9999),
            'status' => 'processing',
            'message' => 'Payment initiated successfully',
        ];
    }
}
