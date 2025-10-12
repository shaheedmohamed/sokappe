<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'لا يمكن تعديل حالة مدير النظام');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'تم تفعيل' : 'تم إيقاف';
        return back()->with('success', $status . ' المستخدم بنجاح');
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

        return view('admin.users.history', compact('user', 'activities'));
    }
}
