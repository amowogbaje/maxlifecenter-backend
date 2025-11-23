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

    public function checkIdentifier(Request $request)
    {
        $request->validate(['identifier' => 'required|string']);

        $identifier = $request->identifier;

        // Check if identifier is email or phone
        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $identifier)->first()
            : User::where('phone', $identifier)->first();

        if (!$user) {
            return response()->json(['message' => 'Account not registered'], 404);
        }

        return response()->json([
            'exists'       => true,
            'hasPassword'  => !is_null($user->password),
            'redirectToOtp' => is_null($user->password),
        ]);
    }


    public function sendOtp(Request $request)
    {
        $request->validate(['identifier' => 'required|string']);

        $identifier = $request->identifier;

        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $identifier)->first()
            : User::where('phone', $identifier)->first();

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

        // Determine delivery channel (Email or SMS)
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            Mail::to($user->email)->send(
                new EmailVerificationRequestMailable($user, $otp, 10)
            );
        } else {
            // Assuming you have an SmsService that sends messages
            // app(\App\Services\SmsService::class)->send(
            //     $user->phone,
            //     "Your verification code is {$otp}. It expires in 10 minutes."
            // );

            Mail::to($user->email)->send(
                new EmailVerificationRequestMailable($user, $otp, 10)
            );
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'OTP sent successfully',
        ]);
    }

    public function checkIdentifier2(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string'
        ]);

        $identifier = $request->identifier;

        // Check if identifier is email or phone
        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            $user = User::where('email', $identifier)->first();
        } else {
            $user = User::where('phone', $identifier)->first();
        }

        if (!$user) {
            return response()->json([
                'message' => 'Email or Phone not registered'
            ], 404);
        }

        return response()->json([
            'exists' => true,
            'hasPassword' => !empty($user->password),
            'redirectToOtp' => empty($user->password)
        ]);
    }
    
    public function sendOtp2(Request $request)
    {
        $request->validate(['identifier' => 'required|string']);

        $identifier = $request->identifier;

        // Find user by email or phone
        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $identifier)->first()
            : User::where('phone', $identifier)->first();

        if (!$user) {
            return response()->json(['message' => 'No account found'], 404);
        }

        if (!is_null($user->password)) {
            return response()->json(['message' => 'This account uses a password'], 400);
        }

        // Generate OTP
        $otp = (string) rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        // Cache OTP using user_id
        Cache::put("otp_user_{$user->id}", $otp, $expiresAt);

        // Store identifier type for verification
        Cache::put("otp_identifier_{$user->id}", $identifier, $expiresAt);

        // Send OTP
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            Mail::to($user->email)->send(
                new EmailVerificationRequestMailable($user, $otp, 10)
            );
        } else {
            // Example: SMS flow
            // app(SmsService::class)->send($user->phone, "Your OTP is {$otp}. Expires in 10 minutes.");

            // TEMP: Send via email for testing
            Mail::to($user->email)->send(
                new EmailVerificationRequestMailable($user, $otp, 10)
            );
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'OTP sent successfully',
        ]);
    }


    public function verifyOtp2(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'otp' => 'required|numeric|digits:6'
        ]);

        $identifier = $request->identifier;

        // Find user by provided identifier
        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $identifier)->first()
            : User::where('phone', $identifier)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid identifier'], 404);
        }

        // Retrieve OTP stored by user_id
        $cachedOtp = Cache::get("otp_user_{$user->id}");

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        // OTP verified successfully — remove OTP
        Cache::forget("otp_user_{$user->id}");

        return response()->json([
            'message' => 'OTP verified successfully'
        ]);
    }


    public function setupPassword2(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|min:4|confirmed'
        ]);

        $identifier = $request->identifier;
        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            $user = User::where('email', $identifier)->first();
        } else {
            $user = User::where('phone', $identifier)->first();
        }

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // Set the password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password set successfully'
        ]);
    }
}
