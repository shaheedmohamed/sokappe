<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'price' => 'required|integer|min:1',
            'days' => 'required|integer|min:1',
            'message' => 'nullable|string|max:2000',
        ]);

        Bid::create([
            'project_id' => $project->id,
            'user_id' => Auth::id(),
            'freelancer_id' => Auth::id(), // للتوافق مع النسخة القديمة
            'amount' => $data['price'],
            'price' => $data['price'], // للتوافق مع النسخة القديمة
            'delivery_time' => $data['days'],
            'days' => $data['days'], // للتوافق مع النسخة القديمة
            'message' => $data['message'],
            'status' => 'pending',
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'تم تقديم عرضك بنجاح!');
    }
}
