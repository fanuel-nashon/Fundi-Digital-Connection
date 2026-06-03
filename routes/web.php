<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tradesperson\ProfileController as TradespersonProfileController;
use App\Http\Controllers\Tradesperson\JobRequestController as TradespersonJobRequestController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\JobRequestController;
use App\Http\Controllers\Customer\MessageController;
use App\Http\Controllers\Customer\ReviewController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/register/pending', fn() => view('auth.pending'))->name('register.pending');

Route::get('/dashboard', function () {
    $user = auth()->user();
    $role = $user->role ?? ($user->roles->first()?->name);

    if ($role === 'admin')       return redirect(route('admin.dashboard'));
    if ($role === 'tradesperson') return redirect(route('tradesperson.tradesperson-dashboard'));
    if ($role === 'customer')    return redirect(route('customer.dashboard'));

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'is_role:admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UsersController::class);
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::post('/registrations/{id}/approve', [AdminRegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('/registrations/{id}/reject', [AdminRegistrationController::class, 'reject'])->name('registrations.reject');
});

Route::middleware(['auth', 'is_role:tradesperson'])->prefix('tradesperson')->name('tradesperson.')->group(function() {
    Route::view('/tradesperson-dashboard', 'tradesperson.dashboard')->name('tradesperson-dashboard');
    Route::get('/tradesperson-profile/{id}', [TradespersonProfileController::class, 'index'])->name('tradesperson-profile');
    Route::get('/create-profile', [TradespersonProfileController::class, 'create'])->name('create-profile');
    Route::post('/create-profile', [TradespersonProfileController::class, 'store'])->name('store-profile');

    Route::get('/job-requests', [TradespersonJobRequestController::class, 'index'])->name('job-requests.index');
    Route::patch('/job-requests/{id}/accept', [TradespersonJobRequestController::class, 'accept'])->name('job-requests.accept');
    Route::patch('/job-requests/{id}/decline', [TradespersonJobRequestController::class, 'decline'])->name('job-requests.decline');
    Route::patch('/job-requests/{id}/progress', [TradespersonJobRequestController::class, 'updateProgress'])->name('job-requests.progress');
    Route::get('/notifications', [TradespersonJobRequestController::class, 'notifications'])->name('notifications');
    Route::patch('/notifications/read-all', [TradespersonJobRequestController::class, 'markAllRead'])->name('notifications.read-all');
});

Route::middleware(['auth', 'is_role:customer'])->prefix('customer')->name('customer.')->group(function() {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-requests', [CustomerDashboardController::class, 'myRequests'])->name('my-requests');
    Route::get('/tradesperson/{id}', [CustomerDashboardController::class, 'show'])->name('tradesperson.show');

    Route::get('/request/{tradespersonId}', [JobRequestController::class, 'create'])->name('request.create');
    Route::post('/request', [JobRequestController::class, 'store'])->name('request.store');

    Route::get('/messages/{jobRequestId}', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{jobRequestId}', [MessageController::class, 'store'])->name('messages.store');
    Route::patch('/messages/{jobRequestId}/complete', [MessageController::class, 'complete'])->name('messages.complete');

    Route::get('/rate/{jobRequestId}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/rate/{jobRequestId}', [ReviewController::class, 'store'])->name('review.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
