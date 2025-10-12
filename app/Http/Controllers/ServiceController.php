<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('user')->latest()->paginate(12);
        return view('services.index', compact('services'));
    }

    public function show(Service $service)
    {
        $service->load('user');
        return view('services.show', compact('service'));
    }

    public function create()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً لإنشاء خدمة');
        }
        
        return view('services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:5',
            'delivery_days' => 'required|integer|min:1',
            'category' => 'required|string',
            'image' => 'nullable|url',
            'skills' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // Create the service
        $service = Service::create([
            'user_id' => $validated['user_id'] ?? Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'delivery_days' => $validated['delivery_days'],
            'category' => $validated['category'],
            'image' => $validated['image'] ?? null,
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
                $service->skills()->sync($skillIds);
            }
        }

        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.services.index')->with('success', 'تم نشر الخدمة بنجاح!');
        }
        
        return redirect()->route('services.index')->with('success', 'تم نشر الخدمة بنجاح!');
    }
}
