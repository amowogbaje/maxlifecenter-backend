<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('guest:admin')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.handle');
});

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/purchases', [DashboardController::class, 'purchases'])->name('purchases');
    Route::get('/purchases/{id}', [DashboardController::class, 'showPurchase'])->name('purchases.show');
    Route::get('/rewards', [DashboardController::class, 'rewards'])->name('rewards');
    Route::get('/uploads', [DashboardController::class, 'uploads'])->name('uploads');
    Route::get('/upload-requests', [DashboardController::class, 'uploadRequests'])->name('upload-requests');
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/updates', [DashboardController::class, 'updates'])->name('updates');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
});