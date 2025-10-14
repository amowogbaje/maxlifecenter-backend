<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Mail\EmailVerificationRequestMailable;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Auth;
use DB;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;


class AuthController extends Controller
{
    public function login()
    {
        return view('user.auth.login');
    }

    public function login2()
    {
        return view('user.auth.login-2');
    }

    public function register()
    {
        return view('user.auth.register');
    }

    public function register2()
    {
        return view('user.auth.register-step-2');
    }

    public function forgotPassword()
    {
        return view('user.auth.forgot-password');
    }

    


    public function sendResetLinkEmail(Request $request)
    {
        $validated = $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->firstOrFail();

        // Generate token
        $token = Str::random(64);

        // Save token to password_resets table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $validated['email']],
            [
                'token' => Hash::make($token), // hash before storing
                'created_at' => now(),
            ]
        );

        // Build reset URL
        $resetUrl = URL::temporarySignedRoute(
            'password.setup',
            now()->addMinutes(30), // expiry time
            [
                'token' => $token,
                'email' => $user->email,
            ]
        );

        Mail::to($request->email)->send(
            new PasswordResetMail($user, $resetUrl)
        );

        return back()->with('status', 'We have emailed your password reset link!');
    }


    public function resetPassword()
    {
        return view('user.auth.reset-password');
    }

    public function confirmPasswordResetOTP()
    {
        return view('user.auth.confirm-password-reset-otp');
    }


    // Login Handler
    public function handleLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email.',
            ])->onlyInput('email');
        }

        if (is_null($user->password)) {
            $otp = (string) rand(100000, 999999); // Store as string for consistency

            // Store both mappings with same expiration
            $expiresAt = now()->addMinutes(10);
            Cache::put('otp_' . $user->id, $otp, $expiresAt);
            Cache::put('otp_for_' . $otp, $user->id, $expiresAt);

            // Store in session as fallback
            session(['otp_user_id' => $user->id]);

            Mail::to($user->email)->send(
                new EmailVerificationRequestMailable($user, $otp, 10)
            );

            return redirect()->route('otp.verify')
                ->with('status', 'We sent a verification code to your email. Please verify by entering the OTP here.');
        }

        // Normal login
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors(['password' => 'Invalid credentials provided.']);
    }

    public function newHandleLogin(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password'   => 'nullable|string',
            'otp'        => 'nullable|string',
        ]);

        $identifier = $request->identifier;
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        Log::info('Login attempt received', [
            'identifier' => $identifier,
            'field_used' => $field,
            'ip'         => $request->ip(),
            'time'       => now()->toDateTimeString(),
        ]);

        $user = User::where($field, $identifier)->first();

        if (!$user) {
            Log::warning('Login failed — user not found', [
                'identifier' => $identifier,
                'ip'         => $request->ip(),
            ]);
            return response()->json(['message' => 'No account found'], 404);
        }

        // Handle password login
        if (!is_null($user->password)) {
            if (Auth::attempt([$field => $identifier, 'password' => $request->password], $request->filled('remember'))) {
                $request->session()->regenerate();

                Log::info('Login successful', [
                    'user_id' => $user->id,
                    'identifier' => $identifier,
                    'ip' => $request->ip(),
                    'agent' => $request->header('User-Agent'),
                ]);

                return response()->json(['message' => 'Login successful'], 200);
            }

            Log::warning('Invalid credentials', [
                'identifier' => $identifier,
                'ip'         => $request->ip(),
            ]);

            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        Log::notice('Login attempt without password', [
            'identifier' => $identifier,
            'ip'         => $request->ip(),
        ]);

        return response()->json(['message' => 'Password required'], 400);
    }




    public function verifyOtp()
    {
        return view('user.auth.verify-otp');
    }

    public function handleOtp(Request $request)
    {
        // Add rate limiting
        $rateLimitKey = 'otp_attempts_' . $request->ip();
        if (Cache::has($rateLimitKey)) {
            $attempts = Cache::get($rateLimitKey);
            if ($attempts >= 5) {
                return back()->withErrors(['otp' => 'Too many attempts. Please try again later.']);
            }
        }

        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $otp = (string) $request->otp;

        // Try primary flow first
        $userId = Cache::get('otp_for_' . $otp);

        if (!$userId) {
            // Fallback to session-based flow
            $userId = session('otp_user_id');

            if (!$userId) {
                // Increment rate limit
                Cache::increment($rateLimitKey, 1, now()->addMinutes(15));
                return back()->withErrors(['otp' => 'Session expired or OTP not found. Please request a fresh OTP. ' .
                    '<a class="text-blue-400 underline ms-3"  href="' . route('login') . '">Start over</a>']);
            }

            $cachedOtp = Cache::get('otp_' . $userId);

            if (!$cachedOtp || $cachedOtp !== $otp) {
                Cache::increment($rateLimitKey, 1, now()->addMinutes(15));
                return back()->withErrors(['otp' => 'Invalid or expired OTP. ' .
                    '<a class="text-blue-400 underline ms-3" href="' . route('login') . '">Start over</a>']);
            }
        }

        $user = User::find($userId);
        if (!$user) {
            return back()->withErrors(['otp' => 'User not found.']);
        }

        // Create a password reset token
        $token = Str::random(64);

        // Store hashed token
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Clean up all OTP-related data
        Cache::forget('otp_for_' . $otp);
        Cache::forget('otp_' . $userId);
        session()->forget('otp_user_id');

        // Reset rate limiting on success
        Cache::forget($rateLimitKey);

        // Consider using a signed URL instead of query parameters for better security
        return redirect()->signedRoute('password.setup', [
            'token' => $token,
            'email' => $user->email
        ])->with('status', 'OTP verified! Please set your access code.');
    }



    public function setupPassword(Request $request, $token)
    {
        if (! $request->hasValidSignature()) {
            return view('user.error-page', [
                'message' => 'The password reset link is invalid or has expired.'
            ]);
        }

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->query('email'))
            ->first();

        if (
            ! $resetRecord ||
            ! Hash::check($token, $resetRecord->token)
        ) {
            return view('user.error-page', [
                'message' => 'The password reset link is invalid or has expired.'
            ]);
        }

        return view('user.auth.password-setup', compact('token'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:4|confirmed', // PIN can be 4 digits
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired token.'
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successful.'
        ]);
    }




    /**
     * Logout the user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
