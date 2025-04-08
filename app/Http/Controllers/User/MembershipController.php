<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function showMembership() {
        $rates = Rate::all();

        return view('user.rates', ['rates' => $rates]);
    }

    public function availMembership($rate) {
        $user = Auth::user();
        $rates = Rate::findOrFail($rate);

        $status = strtolower($user->membership_status);

        // Inactive -> Avail
        // Active, Expired, Pending, and Expired -> Renew
        if ($status === 'inactive') {
            return view('user.availMembership', compact('user', 'rates'));
        }

        return view('user.renewMembership', compact('user', 'rates'));
    }
}