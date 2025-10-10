<?php

namespace App\Http\Controllers;

use App\Models\FreelancerProfile;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function role()
    {
        return view('onboarding.role', ['step' => 1, 'totalSteps' => 3]);
    }

    public function saveRole(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:employer,freelancer',
        ]);

        $user = Auth::user();
        $user->role = $validated['role'];
        $user->save();

        if ($user->role === 'freelancer') {
            return redirect()->route('onboarding.freelancer');
        }

        return redirect()->route('dashboard');
    }

    public function freelancerInfo()
    {
        // Check if user has role set
        if (!Auth::user()->role) {
            return redirect()->route('onboarding.role');
        }
        
        $profile = FreelancerProfile::firstOrNew(['user_id' => Auth::id()]);
        return view('onboarding.freelancer', compact('profile') + ['step' => 2, 'totalSteps' => 3]);
    }

    public function saveFreelancer(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'skills' => 'nullable|string',
        ]);

        FreelancerProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated + ['user_id' => Auth::id()]
        );

        return redirect()->route('onboarding.works');
    }

    public function works(Request $request)
    {
        // Check if user has completed previous steps
        if (!Auth::user()->role) {
            return redirect()->route('onboarding.role');
        }
        
        if (Auth::user()->role === 'freelancer') {
            $profile = FreelancerProfile::where('user_id', Auth::id())->first();
            if (!$profile) {
                return redirect()->route('onboarding.freelancer');
            }
        }
        
        $count = Work::where('user_id', Auth::id())->count();
        return view('onboarding.works', ['worksCount' => $count, 'step' => 3, 'totalSteps' => 3]);
    }

    public function saveWork(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'media_paths' => 'nullable|string',
            'preview_url' => 'nullable|url',
            'delivered_at' => 'nullable|date',
            'skills' => 'nullable|string',
            'terms_accepted' => 'accepted',
        ], [
            'terms_accepted.accepted' => 'يجب تأكيد الشروط لإضافة العمل',
            'thumbnail.image' => 'يجب أن تكون الصورة من نوع صحيح',
            'thumbnail.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
        ]);

        // Handle file upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('works', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        Work::create($validated + ['user_id' => Auth::id()]);

        $count = Work::where('user_id', Auth::id())->count();
        if ($count >= 3) {
            return redirect()->route('dashboard')->with('status', 'onboarding-complete');
        }

        return back()->with('status', 'work-added');
    }
}
