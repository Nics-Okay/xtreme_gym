<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class OtpController extends Controller
{
    public function reset() {
        // dd('reset hit');
        if ($user = Auth::user()) {
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
                'otp_verified' => false,
            ]);
        }
    
        return redirect()->route('dashboard');
    }

    public function showVerifyForm()
    {
        $user = Auth::user();

        // If not logged in, redirect to login
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please log in again.']);
        }

        // If already verified, redirect to filter
        if ($user->otp_verified) {
            return redirect()->route('filter')->with('status', 'You are already verified.');
        }

        // Otherwise, show the OTP verification page
        return view('auth.otp-verify');
    }

    public function generateOtp(Request $request) {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $user = $request->user();
        
        // Check if OTP expiry time is valid before parsing
        if (!$user->otp_expires_at || !Carbon::hasFormat($user->otp_expires_at, 'Y-m-d H:i:s')) {
            $otpExpired = true;
        } else {
            $otpExpiry = Carbon::createFromFormat('Y-m-d H:i:s', $user->otp_expires_at, 'Asia/Manila');
            $otpExpired = $otpExpiry->isPast();
        }

        // Generate new OTP if none exists or it has expired
        if (!$user->otp_code || $otpExpired) {
            $otp = rand(100000, 999999);
            $user->otp_code = $otp;
            $user->otp_expires_at = Carbon::now('Asia/Manila')->addMinutes(5);
            $user->otp_verified = false;
            $user->save();
            
            // Send OTP via email
            Mail::to($user->email)->send(new SendOtp($otp));
            
            // Flash message to show OTP has been sent
            return redirect()->route('otp.verify')->with('status', 'New OTP has been sent to your email.');
        }
        
        // If OTP already exists and is still valid
        return redirect()->route('otp.verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6'
        ], [
            'otp_code.required' => 'OTP is required.',
            'otp_code.digits' => 'OTP must be exactly 6 digits.'
        ]);
        
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['otp_code' => 'Session expired. Please log in again.']);
        }

        // Redirect if OTP is already verified
        if ($user->otp_verified) {
            return redirect()->route('filter')->with('status', 'Already verified.');
        }

        // Guard clause for missing expiry
        if (!$user->otp_expires_at) {
            return redirect()->route('filter')->withErrors(['otp_code' => 'No OTP process found.']);
        }

        $otpExpiry = Carbon::createFromFormat('Y-m-d H:i:s', $user->otp_expires_at, 'Asia/Manila');
        if ($otpExpiry->isPast()) {
            return back()->withErrors(['otp_code' => 'The verification code has expired. Please request a new one.']);
        }
        
        if ($user->otp_code !== $request->otp_code) {
            return back()
                ->withErrors(['otp_code' => 'Invalid OTP code'])
                ->with('error', 'Invalid OTP. Please try again.');
        }

        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'otp_verified' => true,
        ]);
        
        return redirect()->route('filter')->with('status', 'Welcome to Xtreme!');
    }

    public function resendOtp(Request $request)
    {
        // Unique key for rate limiting based on user ID
        $key = 'resend-otp:' . $request->user()->id;
    
        // Check if the user has exceeded the rate limit (1 request per minute)
        if (RateLimiter::tooManyAttempts($key, 1)) {
            return back()->withErrors([
                'otp_code' => 'You’ve reached the limit. Please try again in a minute.'
            ]);
        }
    
        // Increment the rate limiter hit count for this key
        RateLimiter::hit($key, 60); // 60 seconds decay, so 1 attempt per minute
    
        // Redirect to OTP generation page
        return redirect()->route('otp.generate');
    }
    
}
