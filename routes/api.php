<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BasicController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\WebhookController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('password', [AuthController::class, 'updatePassword'])->name('password.update');
    // ->middleware('signed');

Route::post('/check-email', [BasicController::class, 'checkEmail']);
Route::post('/send-otp', [BasicController::class, 'sendOtp']);
Route::post('/login', [BasicController::class, 'login']);

Route::post('/webhooks/woocommerce', [WebhookController::class, 'handle'])
    ->name('webhooks.woocommerce')
    ->middleware(['wc.signed', 'throttle:60,1']);

Route::post('/rewards/{id}/claim', [UserDashboardController::class, 'claimReward'])
    ->name('rewards.claim');

Route::post('/rewards/{id}/approve', [AdminDashboardController::class, 'approveReward'])
    ->name('admin.rewards.approve');

Route::post('/profile/update', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
