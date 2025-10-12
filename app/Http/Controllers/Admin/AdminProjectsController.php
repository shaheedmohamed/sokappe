<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminProjectsController extends Controller
{
    public function index()
    {
        return view('admin.projects.index');
    }

    public function show(Project $project)
    {
        // Load relationships
        $project->load(['user', 'bids.user', 'skills']);
        
        return view('admin.projects.show', compact('project'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return back()->with('success', '✅ تم حذف المشروع بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', '❌ حدث خطأ أثناء حذف المشروع');
        }
    }
}
