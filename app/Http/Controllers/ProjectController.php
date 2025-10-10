<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget_min' => 'nullable|integer|min:0',
            'budget_max' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:1',
        ]);

        $data['employer_id'] = Auth::id();
        Project::create($data);

        return redirect('/')->with('status', 'project-created');
    }
}
