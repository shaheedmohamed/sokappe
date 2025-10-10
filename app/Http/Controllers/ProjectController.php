<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('user')->latest()->paginate(12);
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load('user', 'bids.user');
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget_min' => 'required|numeric|min:0',
            'budget_max' => 'required|numeric|min:0|gte:budget_min',
            'duration' => 'nullable|string',
            'skills' => 'nullable|string',
        ]);

        Project::create($validated + ['user_id' => Auth::id()]);

        return redirect()->route('projects.index')->with('success', 'تم نشر المشروع بنجاح!');
    }
}
