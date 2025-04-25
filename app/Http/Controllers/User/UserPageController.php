<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPageController extends Controller
{
    public function settings()
    {
        return view('user.settings');
    }

    public function equipments()
    {
        $equipments = Equipment::all();
        return view('user.equipments', compact('equipments'));
    }

    public function transactions()
    {
        $user = Auth::user();

        $transactions = Transaction::with('rate')
            ->where('user_id', $user->unique_id)->get();

        return view('user.transactions', compact('transactions'));
    }
}
