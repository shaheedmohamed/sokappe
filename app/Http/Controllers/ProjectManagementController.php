<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectManagement;
use App\Models\DetailedRating;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectManagementController extends Controller
{
    /**
     * Show project management page
     */
    public function show(Project $project)
    {
        // Get project management record
        $management = ProjectManagement::where('project_id', $project->id)->first();
        
        if (!$management) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'لم يتم قبول أي عرض على هذا المشروع بعد');
        }

        // Check if user is authorized (client or freelancer)
        if (Auth::id() !== $management->client_id && Auth::id() !== $management->freelancer_id) {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة');
        }

        // Load relationships
        $management->load(['project', 'client', 'freelancer', 'acceptedBid']);
        
        // Get or create management conversation
        $conversation = Conversation::firstOrCreate([
            'project_id' => $project->id,
            'bid_id' => $management->accepted_bid_id,
        ], [
            'client_id' => $management->client_id,
            'freelancer_id' => $management->freelancer_id,
            'subject' => 'إدارة مشروع: ' . $project->title,
            'last_message_at' => now(),
        ]);

        // Load conversation messages
        $conversation->load(['messages.sender']);

        // Check if project has rating
        $rating = DetailedRating::where('project_id', $project->id)->first();

        return view('projects.manage', compact('management', 'conversation', 'rating'));
    }

    /**
     * Deliver project (freelancer action)
     */
    public function deliver(Project $project, Request $request)
    {
        $management = ProjectManagement::where('project_id', $project->id)->first();
        
        if (!$management || Auth::id() !== $management->freelancer_id) {
            abort(403, 'غير مصرح لك بهذا الإجراء');
        }

        if (!$management->canBeDelivered()) {
            return back()->with('error', 'لا يمكن تسليم هذا المشروع في الوقت الحالي');
        }

        // Mark as delivered
        $management->markAsDelivered();

        // Add delivery message to conversation
        $conversation = Conversation::where('project_id', $project->id)->first();
        if ($conversation) {
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'message' => '🎉 تم تسليم المشروع! يرجى مراجعة العمل المسلم وتقييم الأداء.',
                'is_system_message' => true,
            ]);
        }

        return back()->with('success', 'تم تسليم المشروع بنجاح! في انتظار مراجعة العميل.');
    }

    /**
     * Show rating form
     */
    public function showRatingForm(Project $project)
    {
        $management = ProjectManagement::where('project_id', $project->id)->first();
        
        if (!$management || Auth::id() !== $management->client_id) {
            abort(403, 'غير مصرح لك بهذا الإجراء');
        }

        if (!$management->isDelivered()) {
            return back()->with('error', 'لا يمكن تقييم المشروع قبل تسليمه');
        }

        // Check if already rated
        $existingRating = DetailedRating::where('project_id', $project->id)->first();
        if ($existingRating) {
            return back()->with('error', 'تم تقييم هذا المشروع مسبقاً');
        }

        $management->load(['project', 'freelancer', 'acceptedBid']);

        return view('projects.rate', compact('management'));
    }

    /**
     * Store rating
     */
    public function storeRating(Project $project, Request $request)
    {
        $management = ProjectManagement::where('project_id', $project->id)->first();
        
        if (!$management || Auth::id() !== $management->client_id) {
            abort(403, 'غير مصرح لك بهذا الإجراء');
        }

        $validated = $request->validate([
            'professionalism_rating' => 'required|integer|min:1|max:5',
            'communication_rating' => 'required|integer|min:1|max:5',
            'quality_rating' => 'required|integer|min:1|max:5',
            'experience_rating' => 'required|integer|min:1|max:5',
            'delivery_rating' => 'required|integer|min:1|max:5',
            'cooperation_rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Calculate overall rating
        $ratings = [
            $validated['professionalism_rating'],
            $validated['communication_rating'],
            $validated['quality_rating'],
            $validated['experience_rating'],
            $validated['delivery_rating'],
            $validated['cooperation_rating'],
        ];
        $overallRating = round(array_sum($ratings) / count($ratings), 1);

        // Create rating
        DetailedRating::create([
            'project_id' => $project->id,
            'client_id' => $management->client_id,
            'freelancer_id' => $management->freelancer_id,
            'bid_id' => $management->accepted_bid_id,
            'professionalism_rating' => $validated['professionalism_rating'],
            'communication_rating' => $validated['communication_rating'],
            'quality_rating' => $validated['quality_rating'],
            'experience_rating' => $validated['experience_rating'],
            'delivery_rating' => $validated['delivery_rating'],
            'cooperation_rating' => $validated['cooperation_rating'],
            'overall_rating' => $overallRating,
            'comment' => $validated['comment'],
        ]);

        // Mark project as completed
        $management->markAsCompleted();

        // Add completion message to conversation
        $conversation = Conversation::where('project_id', $project->id)->first();
        if ($conversation) {
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'message' => '✅ تم إنهاء المشروع وتقييم الأداء. شكراً لك!',
                'is_system_message' => true,
            ]);
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'تم تقييم المشروع بنجاح! شكراً لك على التعاون.');
    }

    /**
     * Send message in management conversation
     */
    public function sendMessage(Project $project, Request $request)
    {
        $management = ProjectManagement::where('project_id', $project->id)->first();
        
        if (!$management || (Auth::id() !== $management->client_id && Auth::id() !== $management->freelancer_id)) {
            abort(403, 'غير مصرح لك بهذا الإجراء');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $conversation = Conversation::where('project_id', $project->id)->first();
        
        if ($conversation) {
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'message' => $validated['message'],
            ]);

            $conversation->update(['last_message_at' => now()]);
        }

        return back()->with('success', 'تم إرسال الرسالة بنجاح');
    }
}
