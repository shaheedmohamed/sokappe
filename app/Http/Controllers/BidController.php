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
        return view('bids.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'price' => 'required|integer|min:1',
            'days' => 'required|integer|min:1',
            'message' => 'nullable|string|max:2000',
        ]);

        Bid::create($data + [
            'project_id' => $project->id,
            'freelancer_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect('/')->with('status', 'bid-submitted');
    }
}
