<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's public profile.
     */
    public function show(User $user): View
    {
        // Load user relationships
        $user->load(['profile', 'skills', 'portfolios', 'ratings.client', 'ratings.project']);
        
        return view('profile.show', compact('user'));
    }

    /**
     * Display the user's portfolio.
     */
    public function portfolio(User $user): View
    {
        $user->load(['portfolios', 'profile']);
        
        return view('profile.portfolio', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the advanced profile edit form.
     */
    public function editAdvanced(Request $request): View
    {
        $user = $request->user();
        $profile = $user->profile ?? new UserProfile();
        $skills = $user->skills;
        
        return view('profile.edit-advanced', compact('user', 'profile', 'skills'));
    }

    /**
     * Update the user's advanced profile.
     */
    public function updateAdvanced(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . Auth::id() . '|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:2000',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'portfolio_video' => 'nullable|url|max:255',
            'hourly_rate' => 'nullable|numeric|min:0|max:9999.99',
            'available_for_hire' => 'boolean',
            'languages' => 'nullable|array',
            'languages.*' => 'string|max:50',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'skill_levels' => 'nullable|array',
            'skill_levels.*' => 'in:beginner,intermediate,advanced,expert',
        ]);

        // Update user basic info
        $user = Auth::user();
        $user->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
        ]);

        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->profile && $user->profile->avatar) {
                Storage::disk('public')->delete($user->profile->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Update or create profile
        $profileData = [
            'title' => $validated['title'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
            'experience' => $validated['experience'] ?? null,
            'location' => $validated['location'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'website' => $validated['website'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
            'github' => $validated['github'] ?? null,
            'portfolio_video' => $validated['portfolio_video'] ?? null,
            'hourly_rate' => $validated['hourly_rate'] ?? null,
            'available_for_hire' => $validated['available_for_hire'] ?? true,
            'languages' => $validated['languages'] ?? null,
        ];

        if ($avatarPath) {
            $profileData['avatar'] = $avatarPath;
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        // Update skills
        if (isset($validated['skills']) && is_array($validated['skills'])) {
            // Delete existing skills
            $user->skills()->delete();
            
            // Add new skills
            foreach ($validated['skills'] as $index => $skillName) {
                if (!empty($skillName)) {
                    $user->skills()->create([
                        'skill_name' => $skillName,
                        'proficiency' => $validated['skill_levels'][$index] ?? 'intermediate',
                    ]);
                }
            }
        }

        return redirect()->route('profile.edit-advanced')->with('success', '✅ تم تحديث الملف الشخصي بنجاح');
    }
}
