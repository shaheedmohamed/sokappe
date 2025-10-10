<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\DealController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    $user = Auth::user();
    $myBids = \App\Models\Bid::where('user_id', $user->id)->with('project')->latest()->get();
    return view('dashboard', compact('myBids'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public profile routes
Route::get('/u/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/u/{user}/portfolio', [ProfileController::class, 'portfolio'])->name('profile.portfolio');

// Public routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');
Route::get('/deals/{deal}', [DealController::class, 'show'])->name('deals.show');

Route::middleware('auth')->group(function () {
    // Projects
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/bid', [BidController::class, 'create'])->name('projects.bid.create');
    Route::post('/projects/{project}/bid', [BidController::class, 'store'])->name('projects.bid.store');

    // Services
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    
    // Deals
    Route::get('/deals/create', [DealController::class, 'create'])->name('deals.create');
    Route::post('/deals', [DealController::class, 'store'])->name('deals.store');
});

require __DIR__.'/auth.php';

// Onboarding (authenticated users)
Route::middleware('auth')->prefix('onboarding')->name('onboarding.')->group(function () {
    Route::get('/role', [\App\Http\Controllers\OnboardingController::class, 'role'])->name('role');
    Route::post('/role', [\App\Http\Controllers\OnboardingController::class, 'saveRole'])->name('role.save');

    Route::get('/freelancer', [\App\Http\Controllers\OnboardingController::class, 'freelancerInfo'])->name('freelancer');
    Route::post('/freelancer', [\App\Http\Controllers\OnboardingController::class, 'saveFreelancer'])->name('freelancer.save');

    Route::get('/works', [\App\Http\Controllers\OnboardingController::class, 'works'])->name('works');
    Route::post('/works', [\App\Http\Controllers\OnboardingController::class, 'saveWork'])->name('works.save');
});
