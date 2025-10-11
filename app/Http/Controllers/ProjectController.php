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
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً لإنشاء مشروع');
        }
        
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
            'category' => 'required|string',
            'skills' => 'nullable|string',
        ]);

        // Create the project
        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'budget_min' => $validated['budget_min'],
            'budget_max' => $validated['budget_max'],
            'duration' => $validated['duration'],
            'category' => $validated['category'],
            'status' => 'open',
        ]);

        // Handle skills if provided
        if (!empty($validated['skills'])) {
            $skillNames = array_map('trim', explode(',', $validated['skills']));
            $skillIds = [];
            
            foreach ($skillNames as $skillName) {
                if (!empty($skillName)) {
                    $skill = \App\Models\Skill::firstOrCreate(
                        ['name' => $skillName],
                        ['slug' => \Illuminate\Support\Str::slug($skillName)]
                    );
                    $skillIds[] = $skill->id;
                }
            }
            
            if (!empty($skillIds)) {
                $project->skills()->sync($skillIds);
            }
        }

        return redirect()->route('projects.index')->with('success', 'تم نشر المشروع بنجاح!');
    }
}
