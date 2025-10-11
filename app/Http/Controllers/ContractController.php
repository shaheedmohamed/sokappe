<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Contract;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    public function acceptBid(Bid $bid)
    {
        $project = $bid->project;
        
        // التحقق من أن المستخدم هو صاحب المشروع
        if ($project->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بقبول هذا العرض');
        }

        // التحقق من أن المشروع مازال مفتوحاً
        if ($project->status !== 'open') {
            return back()->with('error', 'هذا المشروع لم يعد متاحاً للقبول');
        }

        DB::transaction(function () use ($bid, $project) {
            // إنشاء العقد
            $contract = Contract::create([
                'project_id' => $project->id,
                'bid_id' => $bid->id,
                'client_id' => $project->user_id,
                'freelancer_id' => $bid->user_id,
                'agreed_price' => $bid->amount,
                'duration_days' => $bid->delivery_time,
                'status' => 'active',
                'started_at' => now(),
            ]);

            // تحديث حالة المشروع
            $project->update(['status' => 'in_progress']);

            // تحديث حالة العرض المقبول
            $bid->update(['status' => 'accepted']);

            // رفض باقي العروض
            $project->bids()->where('id', '!=', $bid->id)->update(['status' => 'rejected']);

            // إنشاء محادثة بين الطرفين
            Conversation::firstOrCreate([
                'project_id' => $project->id,
                'buyer_id' => $project->user_id,
                'seller_id' => $bid->user_id,
            ]);
        });

        return back()->with('success', 'تم قبول العرض وبدء المشروع بنجاح!');
    }

    public function complete(Contract $contract)
    {
        // التحقق من أن المستخدم هو صاحب المشروع
        if ($contract->client_id !== Auth::id()) {
            abort(403);
        }

        $contract->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $contract->project->update(['status' => 'completed']);

        return back()->with('success', 'تم إكمال المشروع بنجاح!');
    }
}
