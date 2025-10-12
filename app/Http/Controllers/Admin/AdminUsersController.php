<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['projects', 'services', 'bids']);
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'لا يمكن حذف مدير النظام');
        }

        $user->delete();
        return back()->with('success', 'تم حذف المستخدم بنجاح');
    }


    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:freelancer,employer,admin',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'is_active' => $validated['is_active'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        $user->update($updateData);

        return back()->with('success', '✅ تم تحديث بيانات المستخدم بنجاح');
    }

    public function history(User $user)
    {
        // Get user activity history
        $activities = collect();

        // Add activity logs (login, logout, etc.)
        $activityLogs = UserActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($activityLogs as $log) {
            $activities->push([
                'type' => $log->action,
                'title' => $log->action_text,
                'description' => $this->getActivityDescription($log),
                'date' => $log->created_at,
                'icon' => $this->getActivityIcon($log->action),
                'color' => $this->getActivityColor($log->action),
                'ip' => $log->ip_address,
                'location' => $log->country . ($log->city ? ', ' . $log->city : ''),
                'device' => $log->device_icon . ' ' . $log->browser,
                'user_agent' => $log->user_agent
            ]);
        }

        // Add user registration
        $activities->push([
            'type' => 'registration',
            'title' => 'انضمام للمنصة',
            'description' => 'انضم المستخدم للمنصة',
            'date' => $user->created_at,
            'icon' => '👋',
            'color' => '#10b981'
        ]);

        // Add projects (for employers)
        if ($user->role === 'employer') {
            foreach ($user->projects as $project) {
                $activities->push([
                    'type' => 'project',
                    'title' => 'نشر مشروع جديد',
                    'description' => $project->title,
                    'date' => $project->created_at,
                    'icon' => '📋',
                    'color' => '#3b82f6',
                    'link' => route('admin.projects.show', $project)
                ]);
            }
        }

        // Add services (for freelancers)
        if ($user->role === 'freelancer') {
            foreach ($user->services as $service) {
                $activities->push([
                    'type' => 'service',
                    'title' => 'إضافة خدمة جديدة',
                    'description' => $service->title,
                    'date' => $service->created_at,
                    'icon' => '⚡',
                    'color' => '#f59e0b',
                    'link' => route('services.show', $service)
                ]);
            }

            // Add bids
            foreach ($user->bids as $bid) {
                $activities->push([
                    'type' => 'bid',
                    'title' => 'تقديم عرض',
                    'description' => 'عرض على مشروع: ' . $bid->project->title,
                    'date' => $bid->created_at,
                    'icon' => '💼',
                    'color' => '#8b5cf6',
                    'link' => route('admin.projects.show', $bid->project)
                ]);
            }
        }

        // Sort activities by date (newest first)
        $activities = $activities->sortByDesc('date');

        // Ensure activities is always a collection
        if ($activities->isEmpty()) {
            $activities = collect([]);
        }

        return view('admin.users.history', compact('user', 'activities'));
    }

    private function getActivityDescription($log)
    {
        $descriptions = [
            'login' => 'تسجيل دخول من ' . ($log->country ?? 'Unknown') . ' باستخدام ' . ($log->browser ?? 'Unknown'),
            'logout' => 'تسجيل خروج من ' . ($log->country ?? 'Unknown'),
            'register' => 'تسجيل حساب جديد من ' . ($log->country ?? 'Unknown'),
            'password_reset' => 'إعادة تعيين كلمة المرور',
            'profile_update' => 'تحديث الملف الشخصي',
            'project_create' => 'إنشاء مشروع جديد',
            'service_create' => 'إضافة خدمة جديدة',
            'bid_create' => 'تقديم عرض على مشروع',
        ];

        return $descriptions[$log->action] ?? $log->action;
    }

    private function getActivityIcon($action)
    {
        $icons = [
            'login' => '🔑',
            'logout' => '🚪',
            'register' => '👋',
            'password_reset' => '🔐',
            'profile_update' => '👤',
            'project_create' => '📋',
            'service_create' => '⚡',
            'bid_create' => '💼',
        ];

        return $icons[$action] ?? '📊';
    }

    private function getActivityColor($action)
    {
        $colors = [
            'login' => '#10b981',
            'logout' => '#f59e0b',
            'register' => '#3b82f6',
            'password_reset' => '#ef4444',
            'profile_update' => '#8b5cf6',
            'project_create' => '#06b6d4',
            'service_create' => '#84cc16',
            'bid_create' => '#f97316',
        ];

        return $colors[$action] ?? '#6b7280';
    }

    public function banUser(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', '❌ لا يمكن حظر مدير النظام');
        }

        $validated = $request->validate([
            'banned_reason' => 'required|string|max:500',
        ]);

        $user->update([
            'is_banned' => true,
            'is_active' => false,
            'banned_reason' => $validated['banned_reason'],
            'banned_at' => now(),
        ]);

        // Log the ban activity
        ActivityLogger::log(
            Auth::id(),
            'user_banned',
            [
                'banned_user_id' => $user->id,
                'banned_user_name' => $user->name,
                'reason' => $validated['banned_reason']
            ]
        );

        return back()->with('success', '🚫 تم حظر المستخدم بنجاح');
    }

    public function unbanUser(User $user)
    {
        $user->update([
            'is_banned' => false,
            'is_active' => true,
            'banned_reason' => null,
            'banned_at' => null,
        ]);

        // Log the unban activity
        ActivityLogger::log(
            Auth::id(),
            'user_unbanned',
            [
                'unbanned_user_id' => $user->id,
                'unbanned_user_name' => $user->name
            ]
        );

        return back()->with('success', '✅ تم إلغاء حظر المستخدم بنجاح');
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->role === 'admin') {
            return back()->with('error', 'لا يمكن تعديل حالة مدير النظام');
        }

        // If user is banned, don't allow status toggle
        if ($user->is_banned) {
            return back()->with('error', '❌ لا يمكن تفعيل مستخدم محظور. يجب إلغاء الحظر أولاً');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        // Log the activity
        ActivityLogger::log(
            'user_status_changed',
            'تم تغيير حالة المستخدم: ' . $user->name . ' إلى ' . ($user->is_active ? 'مفعل' : 'معطل'),
            [
                'target_user_id' => $user->id,
                'target_user_name' => $user->name,
                'new_status' => $user->is_active ? 'active' : 'inactive'
            ]
        );

        $status = $user->is_active ? 'تم تفعيل' : 'تم إيقاف';
        return back()->with('success', $status . ' المستخدم بنجاح');
    }
}
