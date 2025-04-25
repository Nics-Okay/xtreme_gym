<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class ControlPanelController extends Controller
{
    public function show()
    {
        $setting = Setting::firstOrCreate([], ['locked' => false]);
    
        return view('admin.cPanel', ['locked' => $setting->locked]);
    }

    public function toggleLockedStatus(Request $request)
    {
        $setting = Setting::first();

        $setting->locked = !$setting->locked;
        $setting->save();

        return back()->with('status', $setting->locked ? 'Lock enabled' : 'Lock disabled');
    }

    public function getLockStatus()
    {
        $isLocked = auth()->user()->locked;
        $isCPanelLocked = Cache::get('locked_status', false); // Check control panel status
        return response()->json([
            'locked' => $isLocked && $isCPanelLocked,
            'isCPanelLocked' => $isCPanelLocked, // Useful for frontend logic
        ]);
    }

    public function updateLockCode(Request $request)
    {
        $request->validate([
            'current_pin' => 'nullable|digits:6', // Allow nullable current_pin
            'new_pin' => 'required|digits:6|confirmed'
        ]);
    
        $user = auth()->user();
    
        if ($user->lock_code && !Hash::check($request->current_pin, $user->lock_code)) {
            // If lock_code exists, verify current_pin
            return back()->withErrors(['current_pin' => 'Invalid current PIN.']);
        }
    
        // Update lock_code regardless of whether it was null or valid
        $user->update(['lock_code' => Hash::make($request->new_pin)]);
        return back()->with('status', 'Lock code updated successfully.');
    }
    

    public function sendResetLink(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated.'], 403);
        }

        // Generate a signed URL with a unique token
        $resetUrl = URL::temporarySignedRoute(
            'admin.reset-lock-code-link',
            now()->addMinutes(60), // Link expires in 60 minutes
            ['token' => sha1($user->email)]
        );

        // Send the reset email
        Mail::send('emails.reset-lock-code', ['url' => $resetUrl], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Reset Your Lock Code');
        });

        return response()->json([
            'status' => 'success',
            'message' => 'A reset link has been sent to your email.'
        ]);
    }

    public function resetLockCode(Request $request)
    {
        $user = auth()->user();

        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired link.');
        }

        $user->update(['lock_code' => Hash::make('000000')]);

        return redirect()->route('dashboard')->with('success', 'Your lock code has been reset to the default PIN: 000000.');
    }


}
