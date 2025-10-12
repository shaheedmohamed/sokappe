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

        Bid::create([
            'project_id' => $project->id,
            'user_id' => Auth::id(),
            'freelancer_id' => Auth::id(), // للتوافق مع النسخة القديمة
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
}
