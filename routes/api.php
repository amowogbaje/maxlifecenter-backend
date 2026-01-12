<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BasicController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Admin\MediaController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('password', [AuthController::class, 'updatePassword'])->name('password.update');
    // ->middleware('signed');

Route::post('/check-identifier-b', [BasicController::class, 'checkIdentifier']);
Route::post('/send-otp-b', [BasicController::class, 'sendOtp']);

Route::post('/check-identifier', [BasicController::class, 'checkIdentifier2']);
Route::post('/send-otp', [BasicController::class, 'sendOtp2']);
Route::post('/verify-otp', [BasicController::class, 'verifyOtp2']);
Route::post('/setup-password', [BasicController::class, 'setupPassword2']);

Route::post('/webhooks/woocommerce', [WebhookController::class, 'handle'])
    ->name('webhooks.woocommerce')
    ->middleware(['wc.signed', 'throttle:300,1']);

Route::post('/rewards/{id}/claim', [UserDashboardController::class, 'claimReward'])
    ->name('rewards.claim');
Route::get('/user/products/sales/fetch', [UserDashboardController::class, 'fetchSalesProducts'])->name('user.products.sales.fetch');


Route::post('/rewards/{id}/approve', [AdminDashboardController::class, 'approveReward'])
    ->name('admin.rewards.approve');
Route::post('admin/updates/upload', [MediaController::class, 'upload'])->name('admin.updates.upload');


Route::post('user/profile/update', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
Route::post('admin/profile/update', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');
Route::get('/users/search', [AdminUserController::class, 'search'])->name('admin.users.search');