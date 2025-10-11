<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً للوصول لهذه الصفحة');
        }

        // Check if user has admin role and is active
        $user = Auth::user();
        if (!$user->role || $user->role !== 'admin') {
            // Log the unauthorized access attempt
            \Log::warning('Unauthorized admin access attempt', [
                'user_id' => Auth::id(),
                'user_email' => $user->email,
                'user_role' => $user->role ?? 'null',
                'requested_url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect('/')->with('error', '🚫 هذه الصفحة مخصصة للمديرين فقط. ليس لديك صلاحية للوصول إليها.');
        }

        // Check if admin account is active
        if (isset($user->is_active) && !$user->is_active) {
            \Log::warning('Inactive admin access attempt', [
                'user_id' => Auth::id(),
                'user_email' => $user->email,
            ]);

            Auth::logout();
            return redirect('/')->with('error', '🚫 حسابك معطل. يرجى التواصل مع الإدارة.');
        }

        return $next($request);
    }
}
