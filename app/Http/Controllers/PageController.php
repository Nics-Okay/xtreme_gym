<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function plans()
    {
        $walkIn = Rate::whereRaw('LOWER(name) = ?', ['walk-in'])->first();

        $rates = Rate::whereNot(function ($query) {
            $query->where('validity_unit', 'day')
                  ->where('validity_value', 1);
        })->get();
    
        $user = Auth::user();
    
        if ($user && $user->user_type === 'user') {
            return view('user.rates', compact('rates', 'walkIn'));
        } else {
            return view('rates', compact('rates', 'walkIn'));
        }
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function acknowledgement()
    {
        return view('acknowledgement');
    }
}
