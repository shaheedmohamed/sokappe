<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use Illuminate\Http\Request;

class AdminBidsController extends Controller
{
    public function index(Request $request)
    {
        $query = Bid::with(['user', 'project']);

        // Search functionality
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('user', function($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%')
                             ->orWhere('email', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('project', function($projectQuery) use ($request) {
                    $projectQuery->where('title', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $bids = $query->latest()->paginate(20);

        return view('admin.bids.index', compact('bids'));
    }

    public function show(Bid $bid)
    {
        $bid->load(['user', 'project']);
        return view('admin.bids.show', compact('bid'));
    }

    public function updateStatus(Request $request, Bid $bid)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $bid->update(['status' => $validated['status']]);

        $statusText = [
            'pending' => 'معلق',
            'accepted' => 'مقبول', 
            'rejected' => 'مرفوض'
        ];

        return back()->with('success', '✅ تم تحديث حالة العرض إلى: ' . $statusText[$validated['status']]);
    }

    public function destroy(Bid $bid)
    {
        try {
            $bid->delete();
            return back()->with('success', '✅ تم حذف العرض بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', '❌ حدث خطأ أثناء حذف العرض');
        }
    }
}
