<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DashboardController;


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/purchases', [DashboardController::class, 'purchases'])->name('purchases');
    Route::get('/purchases/{id}', [DashboardController::class, 'showPurchase'])->name('purchases.show');
    Route::get('/rewards', [DashboardController::class, 'rewards'])->name('rewards');
    Route::get('/uploads', [DashboardController::class, 'uploads'])->name('uploads');
    Route::get('/upload-requests', [DashboardController::class, 'uploadRequests'])->name('upload-requests');
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/updates', [DashboardController::class, 'updates'])->name('updates');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::get('/campaign', [DashboardController::class, 'settings'])->name('campaign');
});
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

require __DIR__.'/auth.php';


Route::group(['middleware' => 'guest'], function () {
    // Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/login2', [AuthController::class, 'login2'])->name('login2');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.handle');
    Route::post('/login/new', [AuthController::class, 'newHandleLogin']);


    Route::get('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/verify-otp', [AuthController::class, 'handleOtp'])->name('otp.verify.submit');

    Route::get('/password/{token}', [AuthController::class, 'setupPassword'])->name('password.setup');

    
    // Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/register2', [AuthController::class, 'register2'])->name('register2');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('send-reset-link', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::get('/confirm-password-reset-otp', [AuthController::class, 'confirmPasswordResetOTP'])->name('confirm-password-reset-otp');
    

});