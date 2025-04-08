<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Skip for auth routes and if user is fully verified
        if ($request->is('otp/*') || !$user || ($user->otp_verified && !$user->otp)) {
            return $next($request);
        }
            
        // If OTP verification is pending
        if ($user->otp && !$user->otp_verified) {
            return redirect()->route('otp.verify');
        }
        
        // If logged in but no OTP process started
        if (!$user->otp_verified) {
            return redirect()->route('otp.generate')->withErrors([
                'email' => 'OTP verification required'
            ]);
        }
        
        return $next($request);
    }
}
