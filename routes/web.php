<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::get('/confirm-password-reset-otp', [AuthController::class, 'confirmPasswordResetOTP'])->name('confirm-password-reset-otp');
});
