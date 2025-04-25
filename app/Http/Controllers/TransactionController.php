<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Notification;
use App\Models\Rate;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $transactions = Transaction::with('rate')
            ->whereNot('status', 'pending')
            ->when($search, function ($query, $search) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(payment_method) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(amount) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(status) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(transaction_type) LIKE ?', ['%' . strtolower($search) . '%']);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->paginate(10)
            ->appends(['search' => $search]);
    
        return view('admin.transactions.transactions', compact('transactions', 'search'));
    }

    public function destroy(Transaction $transaction) {
        $transaction->delete();
        return redirect(route('transaction.show'))->with('success', 'Transaction Deleted Successfully');

    }

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
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_number' => $validated['emergency_contact_number'],
            'address' => $validated['city'] . ', ' . $validated['province'],
            'membership_status' => 'Pending',
        ]);

        $user->save();

        $rate = Rate::findOrFail($validated['rate_id']);

        Transaction::create([
            'user_id' => $user->unique_id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'payment_method' => $validated['payment_method'] === 'other' ? $validated['other_payment_method'] : $validated['payment_method'],
            'transaction_type' => 'membership_avail',
            'payment_code' => $rate->id,
            'amount' => $rate->price,
            'status' => 'Pending',
            'remarks' => $rate->name . ' Membership',
        ]);

        Notification::create([
            'user_id' => $user->unique_id,
            'user_name' => $user->first_name . ' ' . $user->last_name,
            'user_email' => $user->email,
            'user_contact' => $user->phone,
            'title' => 'New Membership ' . ($user->member_since ? 'Renewal' : 'Request'),
            'message' => 'A new membership ' . ($user->member_since ? 'renewal request' : 'request') . ' has been sent by ' . $user->first_name . ' ' . $user->last_name . 'for ' . $rate->name . 'membership.',
            'category' => 'Membership',
            'submitted_at' => now(),
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
            'remarks' => $rate->name . ' Membership Renewal',
        ]);

        Notification::create([
            'user_id' => $user->unique_id,
            'user_name' => $user->first_name . ' ' . $user->last_name,
            'user_email' => $user->email,
            'user_contact' => $user->phone,
            'title' => 'New Membership ' . ($user->member_since ? 'Renewal' : 'Request'),
            'message' => 'A new membership ' . ($user->member_since ? 'renewal request' : 'request') . ' has been sent by ' . $user->first_name . ' ' . $user->last_name . 'for ' . $rate->name . 'membership.',
            'category' => 'Membership',
            'submitted_at' => now(),
        ]);

        return redirect()->route('user.membership')->with('success', 'Membership renewal request submitted.');
    }

    public function membershipRequest()
    {
        $transactions = Transaction::with('rate')
        ->whereIn('transaction_type', ['membership_renew', 'membership_avail'])
        ->paginate(10);

        return view('admin.transactions.membershipRequest', compact('transactions'));
    }

    public function membershipRequestApprove(Transaction $transaction)
    {
        $rates = Rate::where('id', $transaction->payment_code)->first();
        $duration = $rates->validity_value;
        $unit = $rates->validity_unit;
    
        $validity = now()->add($duration, $unit);

        $user = User::where('unique_id', $transaction->user_id)->first();
        if (!$user) {
            return redirect()->route('transaction.membershipRequest')->with('error', 'User not found.');
        }

        $membershipValidity = $user->membership_validity;
        if ($membershipValidity && Carbon::parse($membershipValidity, 'Asia/Manila')->isFuture()) {
            $total_validity = Carbon::parse($membershipValidity, 'Asia/Manila')->add($duration, $unit);
        } else {
            $total_validity = now('Asia/Manila')->add($duration, $unit);
        }

        // Determine updated membership type
        if ($membershipValidity && !Carbon::parse($membershipValidity, 'Asia/Manila')->isPast()) {
            // Check if membership_type exists
            if (!empty($user->membership_type)) {
                $membershipRate = Rate::where('name', $user->membership_type)->first();

                // Compare prices if membershipRate exists
                if ($membershipRate && $rates->price > $membershipRate->price) {
                    $updatedMembership = $rates->name; // Higher price means new rate is used
                } else {
                    $updatedMembership = $membershipRate ? $membershipRate->name : $rates->name;
                }
            } else {
                $updatedMembership = $rates->name; // Default to current rate if no type exists
            }
        } else {
            $updatedMembership = $rates->name; // Default to current rate if expired
        }

        $renewal_count = $user->renewal_count ?? 0;
        if (!empty($membershipValidity)) {
            $renewal_count += 1; // Increment renewal count if validity exists
        }
        
        $currentDate = Carbon::now('Asia/Manila');

        // Add the duration to the current date based on the unit
        if ($unit === 'day') {
            $endDate = $currentDate->copy()->addDays($duration);
        } elseif ($unit === 'month') {
            $endDate = $currentDate->copy()->addMonths($duration);
        } elseif ($unit === 'year') {
            $endDate = $currentDate->copy()->addYears($duration);
        } else {
            // Retain current membership validity or use the current date if unit is invalid
            $endDate = $membershipValidity ? Carbon::parse($membershipValidity, 'Asia/Manila') : $currentDate;
            $operationError = 'Error: In Transactions ~ Updating membership hours unsuccessful';
        }
        
        // Calculate membership hours based on endDate
        $calculatedHours = $currentDate->diffInHours($endDate);

        // Combine with existing membership hours
        $currentMembershipHours = $user->membership_hours ?? 0; // Default to 0 if null
        $totalMembershipHours = $currentMembershipHours + $calculatedHours;
        
        // Update user details
        $user->update([
            'member_since' => $user->member_since ?? now(),
            'membership_status' => 'Active',
            'membership_type' => $updatedMembership,
            'membership_validity' => $total_validity,
            'renewal_count' => $renewal_count,
            'membership_hours' => $totalMembershipHours,
        ]);

        $rate_identity = Rate::find($transaction->payment_code);
        if ($rate_identity) {
            $rate_identity->times_availed += 1;
            $rate_identity->save();
        }

        $transaction->update([
            'status' => 'Completed',
        ]);

        return redirect()->route('transaction.membershipRequest', [
            'operationError' => $operationError ?? null,
            ])
            ->with('success', 'Transaction approved.');
    }

    // Cancel a transaction
    public function membershipRequestCancel(Transaction $transaction)
    {
        $transaction->update([
            'status' => 'Cancelled',
        ]);

        // Update membership status as inactive if no active membership

        return redirect()->route('transaction.membershipRequest')->with('success', 'Transaction canceled.');
    }
}
