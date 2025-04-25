<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function showMembership()
    {
        $walkIn = Rate::whereRaw('LOWER(name) = ?', ['walk-in'])->first();

        $rates = Rate::whereNot(function ($query) {
            $query->where('validity_unit', 'day')
                  ->where('validity_value', 1);
        })->get();

        return view('user.rates', compact('rates', 'walkIn'));
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