<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login() {
        return view('user.auth.login');
    }

    public function register() {
        return view('user.auth.register');
    }

    public function forgotPassword() {
        return view('user.auth.forgot-password');
    }

    public function resetPassword() {
        return view('user.auth.reset-password');
    }

    public function confirmPasswordResetOTP() {
        return view('user.auth.confirm-password-reset-otp');
    }
}
