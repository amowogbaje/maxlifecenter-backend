<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationRequestMailable;
use Illuminate\Support\Facades\URL;
use DB;

class BasicController extends Controller
{

    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not registered'], 404);
        }

        return response()->json([
            'exists'      => true,
            'hasPassword' => !is_null($user->password),
            'redirectToOtp' => is_null($user->password),
        ]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'No account found'], 404);
        }

        if (!is_null($user->password)) {
            return response()->json(['message' => 'This account uses a password'], 400);
        }

        $otp = (string) rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        Cache::put('otp_' . $user->id, $otp, $expiresAt);
        Cache::put('otp_for_' . $otp, $user->id, $expiresAt);

        session(['otp_user_id' => $user->id]);

        Mail::to($user->email)->send(
            new EmailVerificationRequestMailable($user, $otp, 10)
        );

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent to your email',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'nullable|string',
            'otp'      => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'No account found'], 404);
        }

        // Password login
        if (!is_null($user->password)) {
            if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
                $request->session()->regenerate();
                return response()->json(['message' => 'Login successful'], 200);
            }
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // OTP login
        if ($request->otp) {
            $otpKey = 'otp_' . $user->id;
            if (Cache::get($otpKey) === $request->otp) {
                Auth::login($user);
                $request->session()->regenerate();

                // Clear OTP
                Cache::forget($otpKey);
                Cache::forget('otp_for_' . $request->otp);

                return response()->json(['message' => 'OTP login successful'], 200);
            }
            return response()->json(['message' => 'Invalid or expired OTP'], 401);
        }

        return response()->json(['message' => 'Password or OTP required'], 400);
    }
}
