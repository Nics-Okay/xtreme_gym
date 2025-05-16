<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request)
    {
        return view('admin.profile.profile', ['user' => $request->user()]);
    }

    public function showUser(Request $request)
    {
        return view('user.profile', ['user' => $request->user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $user = $request->user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->back()
        ->with('status', 'profile-updated')
        ->with('success', 'Profile Information Updated Successfully.');
    }

    /**
     * Update the user's profile image.
     */
    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('equipment_images', 'public');

            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $user->image = $imagePath;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile image updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->back()
        ->with('status', 'password-updated')
        ->with('success', 'Password updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ], [
            'password.current_password' => 'The password you entered is incorrect.',
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Account successfully deleted.');
    }
}
