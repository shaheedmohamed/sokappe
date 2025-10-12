<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Service;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $systemStats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'open')->count(),
            'total_services' => Service::count(),
            'total_conversations' => Conversation::count(),
            'database_size' => $this->getDatabaseSize(),
            'cache_size' => $this->getCacheSize(),
        ];

        $recentActivity = [
            'users_today' => User::whereDate('created_at', today())->count(),
            'projects_today' => Project::whereDate('created_at', today())->count(),
            'services_today' => Service::whereDate('created_at', today())->count(),
            'users_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'projects_this_week' => Project::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return view('admin.settings', compact('systemStats', 'recentActivity'));
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            
            return back()->with('success', '✅ تم مسح الكاش بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', '❌ حدث خطأ أثناء مسح الكاش');
        }
    }

    public function exportData()
    {
        try {
            $data = [
                'users' => User::count(),
                'projects' => Project::count(),
                'services' => Service::count(),
                'export_date' => now()->format('Y-m-d H:i:s')
            ];

            return response()->json($data)
                ->header('Content-Disposition', 'attachment; filename="sokappe_data_' . now()->format('Y_m_d') . '.json"');
        } catch (\Exception $e) {
            return back()->with('error', '❌ حدث خطأ أثناء تصدير البيانات');
        }
    }

    private function getDatabaseSize()
    {
        try {
            $path = database_path('database.sqlite');
            if (file_exists($path)) {
                return round(filesize($path) / 1024 / 1024, 2) . ' MB';
            }
            return 'غير محدد';
        } catch (\Exception $e) {
            return 'غير محدد';
        }
    }

    private function getCacheSize()
    {
        try {
            return Cache::getStore() instanceof \Illuminate\Cache\FileStore ? 
                $this->getDirectorySize(storage_path('framework/cache')) : 'غير محدد';
        } catch (\Exception $e) {
            return 'غير محدد';
        }
    }

    private function getDirectorySize($directory)
    {
        $size = 0;
        if (is_dir($directory)) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $file) {
                $size += $file->getSize();
            }
        }
        return round($size / 1024 / 1024, 2) . ' MB';
    }
}
