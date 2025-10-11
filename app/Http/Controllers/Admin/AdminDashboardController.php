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
        $monthly_stats = [
            'users' => User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month'),
            'projects' => Project::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month'),
        ];

        return view('admin.analytics', compact('monthly_stats'));
    }
}
