<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\MessageController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Create routes (working)
Route::get('/projects-create', function() {
    return view('projects.create');
})->name('projects.create.new');

Route::get('/services-create', function() {
    return view('services.create');
})->name('services.create.new');

Route::get('/dashboard', function () {
    $user = Auth::user();
    $myBids = \App\Models\Bid::where('user_id', $user->id)->with('project')->latest()->get();
    return view('dashboard', compact('myBids'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/edit-advanced', [ProfileController::class, 'editAdvanced'])->name('profile.edit-advanced');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/advanced', [ProfileController::class, 'updateAdvanced'])->name('profile.update-advanced');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Portfolio routes
    Route::resource('portfolio', PortfolioController::class);
    
    // Rating routes
    Route::get('/projects/{project}/rate', [RatingController::class, 'create'])->name('ratings.create');
    Route::post('/projects/{project}/rate', [RatingController::class, 'store'])->name('ratings.store');
    
    // Message routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{conversation}/new-messages', [MessageController::class, 'getNewMessages'])->name('messages.new');
    Route::get('/messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('messages.unread-count');
    Route::get('/bids/{bid}/message', [MessageController::class, 'startFromBid'])->name('messages.start-from-bid');
});

// Public profile routes
Route::get('/u/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/u/{user}/portfolio', [ProfileController::class, 'portfolio'])->name('profile.portfolio');
Route::get('/u/{user}/ratings', [RatingController::class, 'show'])->name('ratings.show');

// Public routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');
Route::get('/deals/{deal}', [DealController::class, 'show'])->name('deals.show');

// Projects (temporarily without auth for testing)
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');

Route::middleware('auth')->group(function () {
    // Bid actions (accept/reject)
    Route::post('/bids/{bid}/accept', [BidController::class, 'accept'])->name('bids.accept');
    Route::post('/bids/{bid}/reject', [BidController::class, 'reject'])->name('bids.reject');
});

Route::middleware('auth')->group(function () {
    // Projects
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('/projects/{project}/bid', [BidController::class, 'create'])->name('projects.bid.create');
    Route::post('/projects/{project}/bid', [BidController::class, 'store'])->name('projects.bid.store');

    // Services
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    
    // Deals
    Route::get('/deals/create', [DealController::class, 'create'])->name('deals.create');
    Route::post('/deals', [DealController::class, 'store'])->name('deals.store');

    // Conversations & Messages
    Route::get('/inbox', [\App\Http\Controllers\ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/inbox/{conversation}', [\App\Http\Controllers\ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/inbox/{conversation}', [\App\Http\Controllers\ConversationController::class, 'store'])->name('conversations.store');

    // Contracts
    Route::post('/bids/{bid}/accept', [\App\Http\Controllers\ContractController::class, 'acceptBid'])->name('bids.accept');
    Route::post('/contracts/{contract}/complete', [\App\Http\Controllers\ContractController::class, 'complete'])->name('contracts.complete');
});

require __DIR__.'/auth.php';

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'analytics'])->name('analytics');
    
    // Users Management
    Route::get('/users', [\App\Http\Controllers\Admin\AdminUsersController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'update'])->name('users.update');
    Route::get('/users/{user}/history', [\App\Http\Controllers\Admin\AdminUsersController::class, 'history'])->name('users.history');
    Route::patch('/users/{user}/ban', [\App\Http\Controllers\Admin\AdminUsersController::class, 'banUser'])->name('users.ban');
    Route::patch('/users/{user}/unban', [\App\Http\Controllers\Admin\AdminUsersController::class, 'unbanUser'])->name('users.unban');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\AdminUsersController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Projects Management
    Route::get('/projects', [\App\Http\Controllers\Admin\AdminProjectsController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [\App\Http\Controllers\Admin\AdminProjectsController::class, 'create'])->name('projects.create');
    Route::get('/projects/{project}', [\App\Http\Controllers\Admin\AdminProjectsController::class, 'show'])->name('projects.show');
    Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
    Route::delete('/projects/{project}', [\App\Http\Controllers\Admin\AdminProjectsController::class, 'destroy'])->name('projects.destroy');
    
    Route::get('/services', function() { return view('admin.services.index'); })->name('services.index');
    Route::get('/services/create', function() { return view('admin.services.create'); })->name('services.create');
    Route::post('/services', [\App\Http\Controllers\ServiceController::class, 'store'])->name('services.store');
    
    Route::get('/bids', [\App\Http\Controllers\Admin\AdminBidsController::class, 'index'])->name('bids.index');
    Route::get('/bids/{bid}', [\App\Http\Controllers\Admin\AdminBidsController::class, 'show'])->name('bids.show');
    
    Route::get('/messages', [\App\Http\Controllers\Admin\AdminMessagesController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [\App\Http\Controllers\Admin\AdminMessagesController::class, 'show'])->name('messages.show');
    Route::get('/messages/stats', [\App\Http\Controllers\Admin\AdminMessagesController::class, 'stats'])->name('messages.stats');
    Route::patch('/bids/{bid}/status', [\App\Http\Controllers\Admin\AdminBidsController::class, 'updateStatus'])->name('bids.update-status');
    Route::delete('/bids/{bid}', [\App\Http\Controllers\Admin\AdminBidsController::class, 'destroy'])->name('bids.destroy');
    
    // Conversations Monitoring
    Route::get('/conversations', [\App\Http\Controllers\Admin\AdminConversationsController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [\App\Http\Controllers\Admin\AdminConversationsController::class, 'show'])->name('conversations.show');
    Route::delete('/conversations/{conversation}', [\App\Http\Controllers\Admin\AdminConversationsController::class, 'destroy'])->name('conversations.destroy');
    
    // Reports & Settings
    Route::get('/reports', function() { return view('admin.reports.index'); })->name('reports.index');
    Route::get('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('settings');
    Route::post('/settings/clear-cache', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'clearCache'])->name('settings.clear-cache');
    Route::get('/settings/export-data', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'exportData'])->name('settings.export-data');
});

// Test route for activity logging
Route::get('/test-activity', [\App\Http\Controllers\TestActivityController::class, 'testActivity'])->middleware('auth');

// Onboarding (authenticated users)
Route::middleware('auth')->prefix('onboarding')->name('onboarding.')->group(function () {
    Route::get('/role', [\App\Http\Controllers\OnboardingController::class, 'role'])->name('role');
    Route::post('/role', [\App\Http\Controllers\OnboardingController::class, 'saveRole'])->name('role.save');

    Route::get('/freelancer', [\App\Http\Controllers\OnboardingController::class, 'freelancerInfo'])->name('freelancer');
    Route::post('/freelancer', [\App\Http\Controllers\OnboardingController::class, 'saveFreelancer'])->name('freelancer.save');

    Route::get('/works', [\App\Http\Controllers\OnboardingController::class, 'works'])->name('works');
    Route::post('/works', [\App\Http\Controllers\OnboardingController::class, 'saveWork'])->name('works.save');
});
