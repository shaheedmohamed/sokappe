<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Work;
use App\Models\FreelancerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        $profile = null;
        $works = collect();
        
        if ($user->role === 'freelancer') {
            $profile = FreelancerProfile::where('user_id', $user->id)->first();
            $works = Work::where('user_id', $user->id)->latest()->get();
        }

        return view('profile.show', compact('user', 'profile', 'works'));
    }

    /**
     * Display the user's portfolio.
     */
    public function portfolio(User $user): View
    {
        $works = Work::where('user_id', $user->id)->latest()->get();
        $profile = FreelancerProfile::where('user_id', $user->id)->first();
        
        return view('profile.portfolio', compact('user', 'works', 'profile'));
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
}
