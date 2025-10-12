<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Service;
use App\Models\Bid;
use App\Models\Conversation;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'open')->count(),
            'total_services' => Service::count(),
            'total_bids' => Bid::count(),
            'total_conversations' => Conversation::count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $recent_projects = Project::with('user')->latest()->take(5)->get();
        $recent_bids = Bid::with(['user', 'project'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_projects', 'recent_bids'));
    }

    public function analytics()
    {
        // Simple stats without complex SQL functions for SQLite compatibility
        $stats = [
            'total_users' => User::count(),
            'users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'total_projects' => Project::count(),
            'projects_this_month' => Project::whereMonth('created_at', now()->month)->count(),
            'total_services' => Service::count(),
            'services_this_month' => Service::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.analytics', compact('stats'));
    }
}
