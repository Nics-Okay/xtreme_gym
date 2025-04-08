<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function availStore(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|min:11|max:13',
            'email' => 'nullable|email|max:100',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|min:11|max:13',
            'rate_id' => 'required|exists:rates,id',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);

        $user = $request->user();

        if ($user->isDirty('first_name')) {
            $user->fill(['first_name' => $validated['first_name']]);
            $user->save();
        }

        $user->fill([
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'city' => $validated['city'],
            'province' => $validated['province'],
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_number' => $validated['emergency_contact_number'],
            'address' => $validated['city'] . ', ' . $validated['province'],
            'membership_status' => 'Pending',
        ]);

        $user->save();

        $rate = Rate::findOrFail($validated['rate_id']);

        Transaction::create([
            'user_id' => $user->id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'payment_method' => $validated['payment_method'] === 'other' ? $validated['other_payment_method'] : $validated['payment_method'],
            'transaction_type' => 'membership_avail',
            'payment_code' => $rate->id,
            'amount' => $rate->price,
            'status' => 'Pending',
            'remarks' => 'Payment for new ' . $rate->name . ' membership',
        ]);

        return redirect()->route('user.membership')->with('success', 'Membership request submitted.');
    }   

    public function renewStore(Request $request)
    {
        $validated = $request->validate([
            'rate_id' => 'required|exists:rates,id',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);

        $user = $request->user();

        $rate = Rate::findOrFail($validated['rate_id']);

        Transaction::create([
            'user_id' => $user->unique_id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'payment_method' => $validated['payment_method'] === 'other' ? $validated['other_payment_method'] : $validated['payment_method'],
            'transaction_type' => 'membership_renew',
            'payment_code' => $rate->id,
            'amount' => $rate->price,
            'status' => 'Pending',
            'remarks' => 'Payment for ' . $rate->name . ' membership renewal',
        ]);

        return redirect()->route('user.membership')->with('success', 'Membership renewal request submitted.');
    }

    public function membershipRequest()
    {
        $transactions = Transaction::with('rate')->whereIn('transaction_type', ['membership_renew', 'membership_avail'])->get();

        return view('admin.transactions.membershipRequest', compact('transactions'));
    }
}
