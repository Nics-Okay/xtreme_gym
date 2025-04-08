<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function home() {
        return view('user.home');
    }

    public function showRightDashboard()
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Please log in first.']);
        }
    
        switch ($user->user_type) {
            case 'admin':
                return redirect()->route('dashboard');
            case 'user':
                return redirect()->route('user.home');
            default:
                return redirect()->route('index')->with('error', 'Error. Please ask for assistance.');
        }
    }
    
}
