<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BidController extends Controller
{
    public function create(Project $project)
    {
        // فحص إذا كان المستخدم قدم عرضاً بالفعل
        $existingBid = $project->bids()->where('user_id', Auth::id())->first();
        
        if ($existingBid) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'لقد قدمت عرضاً على هذا المشروع بالفعل. لا يمكن تقديم أكثر من عرض واحد.');
        }
        
        $project->load('user', 'bids.user');
        $otherBids = $project->bids()->where('user_id', '!=', Auth::id())->latest()->take(5)->get();
        return view('bids.create', compact('project', 'otherBids'));
    }

    public function store(Request $request, Project $project)
    {
        // فحص إذا كان المستخدم قدم عرضاً بالفعل
        $existingBid = $project->bids()->where('user_id', Auth::id())->first();
        
        if ($existingBid) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'لقد قدمت عرضاً على هذا المشروع بالفعل. لا يمكن تقديم أكثر من عرض واحد.');
        }
        
        $data = $request->validate([
            'price' => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
            'days' => 'required|integer|min:1',
            'message' => 'nullable|string|max:2000',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|max:51200|mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif,zip,rar',
        ]);

        // Handle file uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('bid-attachments', 'public');
                $attachmentPaths[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                ];
            }
        }

        $bid = Bid::create([
            'project_id' => $project->id,
            'freelancer_id' => Auth::id(),
            'amount' => $data['price'],
            'price' => $data['price'], // للتوافق مع النسخة القديمة
            'delivery_time' => $data['days'],
            'days' => $data['days'], // للتوافق مع النسخة القديمة
            'message' => $data['message'],
            'attachments' => $attachmentPaths,
            'status' => 'pending',
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'تم تقديم عرضك بنجاح!');
    }

    /**
     * Accept a bid
     */
    public function accept(Bid $bid, Request $request)
    {
        // Handle GET request - show confirmation page
        if ($request->isMethod('GET')) {
            return view('bids.confirm-accept', compact('bid'));
        }

        // Check if user is the project owner
        if (Auth::id() !== $bid->project->user_id) {
            abort(403, 'غير مصرح لك بقبول هذا العرض');
        }

        // Check if project is still open
        if ($bid->project->status !== 'open') {
            return back()->with('error', 'لا يمكن قبول العروض لهذا المشروع');
        }

        // Accept the bid
        $bid->update(['status' => 'accepted']);
        
        // Reject all other bids for this project
        $bid->project->bids()->where('id', '!=', $bid->id)->update(['status' => 'rejected']);
        
        // Update project status
        $bid->project->update(['status' => 'in_progress']);

        // Create project management record
        \App\Models\ProjectManagement::create([
            'project_id' => $bid->project_id,
            'client_id' => $bid->project->user_id,
            'freelancer_id' => $bid->freelancer_id,
            'accepted_bid_id' => $bid->id,
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return redirect()->route('projects.manage', $bid->project)
            ->with('success', 'تم قبول العرض بنجاح! مرحباً بك في صفحة إدارة المشروع.');
    }

    /**
     * Reject a bid
     */
    public function reject(Bid $bid)
    {
        // Check if user is the project owner
        if (Auth::id() !== $bid->project->user_id) {
            abort(403, 'غير مصرح لك برفض هذا العرض');
        }

        // Reject the bid
        $bid->update(['status' => 'rejected']);

        return back()->with('success', 'تم رفض العرض');
    }
}
