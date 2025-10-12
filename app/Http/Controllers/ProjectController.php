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
            'budget_min' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'budget_max' => 'required|numeric|min:0|gte:budget_min|regex:/^\d+(\.\d{1,2})?$/',
            'duration' => 'nullable|string',
            'duration_days' => 'nullable|integer|min:1',
            'category' => 'required|string',
            'skills' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // Set default values for optional fields
        $validated['duration'] = $validated['duration'] ?? null;
        $validated['duration_days'] = $validated['duration_days'] ?? null;
        $validated['skills'] = $validated['skills'] ?? null;

        // Create the project
        $userId = $validated['user_id'] ?? Auth::id();
        $project = Project::create([
            'user_id' => $userId,
            'employer_id' => $userId, // Set employer_id same as user_id
            'title' => $validated['title'],
            'description' => $validated['description'],
            'budget_min' => $validated['budget_min'],
            'budget_max' => $validated['budget_max'],
            'duration' => $validated['duration'],
            'duration_days' => $validated['duration_days'],
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

        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.projects.index')->with('success', 'تم نشر المشروع بنجاح!');
        }
        
        return redirect()->route('projects.index')->with('success', 'تم نشر المشروع بنجاح!');
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        // Check if user is the project owner
        if (Auth::id() !== $project->user_id) {
            abort(403, 'غير مصرح لك بتعديل هذا المشروع');
        }

        // Check if project can be edited (only open projects)
        if ($project->status !== 'open') {
            return redirect()->route('projects.show', $project)
                ->with('error', 'لا يمكن تعديل هذا المشروع لأنه لم عد مفتوحاً');
        }

        $categories = \App\Models\Category::all();
        $skills = \App\Models\Skill::all();
        
        return view('projects.edit', compact('project', 'categories', 'skills'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        // Check if user is the project owner
        if (Auth::id() !== $project->user_id) {
            abort(403, 'غير مصرح لك بتعديل هذا المشروع');
        }

        // Check if project can be edited
        if ($project->status !== 'open') {
            return redirect()->route('projects.show', $project)
                ->with('error', 'لا يمكن تعديل هذا المشروع لأنه لم عد مفتوحاً');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget_min' => 'required|numeric|min:1',
            'budget_max' => 'required|numeric|min:1|gte:budget_min',
            'duration' => 'required|integer|min:1',
            'category_id' => 'nullable|exists:categories,id',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        // Update project
        $project->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'budget_min' => $validated['budget_min'],
            'budget_max' => $validated['budget_max'],
            'duration' => $validated['duration'],
            'category_id' => $validated['category_id'],
        ]);

        // Update skills if provided
        if (isset($validated['skills'])) {
            $project->skills()->sync($validated['skills']);
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'تم تحديث المشروع بنجاح!');
    }
}
