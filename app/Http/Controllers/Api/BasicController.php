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

    
}
