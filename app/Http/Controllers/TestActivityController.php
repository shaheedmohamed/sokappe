<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestActivityController extends Controller
{
    public function testActivity()
    {
        if (Auth::check()) {
            // Test login activity
            ActivityLogger::log(Auth::id(), 'login');
            
            // Test project creation activity
            ActivityLogger::log(Auth::id(), 'project_create', [
                'project_title' => 'Test Project'
            ]);
            
            return response()->json([
                'message' => 'تم تسجيل الأنشطة التجريبية بنجاح',
                'user_id' => Auth::id()
            ]);
        }
        
        return response()->json(['error' => 'يجب تسجيل الدخول أولاً'], 401);
    }
}
