<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Notification;
use App\Models\Rate;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Password;

class MemberController extends Controller
{
    public function show(Request $request)
    {
        // Retrieve search query
        $search = $request->input('search');
    
        // Filter members based on search query
        $members = User::whereNotNull('membership_type')
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->appends(['search' => $search]);
    
        return view('admin.members.members', compact('members', 'search'));
    }

    public function create() {
        $rates = Rate::all();
        return view('admin.members.createMember', ['rates' => $rates]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'required|string|min:11|max:13',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|min:11|max:13',
            'rate_id' => 'required|exists:rates,id',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);
    
        $rate = Rate::find($validated['rate_id']);
    
        $duration = $rate->validity_value;
        $unit = $rate->validity_unit;
    
        $validity = now()->add($duration, $unit);
    
        // Generate a random 8-digit password
        $password = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    
        // Create the user
        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'member_since' => now(),
            'email' => $validated['email'],
            'password' => Hash::make($password),
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_number' => $validated['emergency_contact_number'],
            'address' => collect([$validated['city'], $validated['province']])
                ->filter()
                ->isEmpty() ? null : collect([$validated['city'], $validated['province']])
                ->filter()
                ->implode(', '),
            'membership_type' => $rate->name,
            'membership_validity' => $validity,
            'membership_status' => 'Active',
        ]);
    
        return redirect()->route('member.storeData', [
            'first_name' => urlencode($validated['first_name']),
            'last_name' => urlencode($validated['last_name']),
            'payment' => urlencode(
                $validated['payment_method'] === 'other'
                    ? $validated['other_payment_method']
                    : $validated['payment_method']
            ),
            'rate' => $rate->id,
        ]);
    }

    public function storeData($first_name, $last_name, $rate, $payment)
    {
        $user = User::where('first_name', $first_name)
        ->where('last_name', $last_name)
        ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User not found.']);
        }

        $rate = Rate::findOrFail($rate);
    
        DB::transaction(function () use ($user, $rate, $payment) {
            Attendee::create([
                'user_id' => $user->unique_id,
                'name' => $user->first_name . ' ' . ($user->last_name ?? ''),
                'membership_type' => $user->membership_type,
                'membership_status' => $user->membership_status, 
                'membership_validity' => $user->membership_validity,
                'time_in' => now(),
            ]);

            Transaction::create([
                'user_id' => $user->unique_id,
                'name' => $user->first_name . ' ' . ($user->last_name ?? ''),
                'payment_method' => $payment,
                'transaction_type' => 'membership_avail',
                'payment_code' => $rate->id,
                'amount' => $rate->price,
                'status' => 'Completed',
                'remarks' => $rate->name . 'Membership',
            ]);
    
            Notification::create([
                'user_id' => $user->unique_id,
                'user_name' => $user->first_name . ' ' . $user->last_name,
                'user_email' => $user->email,
                'user_contact' => $user->phone,
                'title' => 'New Membership Confirmed',
                'message' => 'A new membership by ' . $user->first_name . ' ' . $user->last_name . ' for ' . $rate->name . ' membership has been recorded.',
                'category' => 'Membership',
                'submitted_at' => now(),
            ]);
        });

        if ($user->email) {
            Password::sendResetLink(['email' => $user->email]);
        }

        return redirect()->route('member.show')->with('success', 'Transaction for ' . $user->first_name . ' ' . $user->last_name . ' completed successfully!');
    }

    public function edit(User $member)
    {
        return view('admin.members.editMember', ['member' => $member]);
    }

    public function update(User $member, Request $request) 
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'required|string|min:11|max:13',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|min:11|max:13',
        ]);

        $member->update([
            'first_name' => $validated['first_name'] !== $member->first_name ? $validated['first_name'] : $member->first_name,
            'last_name' => $validated['last_name'] !== $member->last_name ? $validated['last_name'] : $member->last_name,
            'phone' => $validated['phone'] !== $member->phone ? $validated['phone'] : $member->phone,
            'email' => $validated['email'] !== $member->email ? $validated['email'] : $member->email,
            'emergency_contact_name' => $validated['emergency_contact_name'] !== $member->emergency_contact_name
                ? $validated['emergency_contact_name']
                : $member->emergency_contact_name,
            'emergency_contact_number' => $validated['emergency_contact_number'] !== $member->emergency_contact_number
                ? $validated['emergency_contact_number']
                : $member->emergency_contact_number,
            'address' => collect([$validated['city'], $validated['province']])
                ->filter()
                ->implode(', ') !== $member->address
                ? collect([$validated['city'], $validated['province']])->filter()->implode(', ')
                : $member->address,
        ]);
        
        return redirect(route('member.show'))->with('success', 'Member Updated Successfully');
    }

    public function destroy(User $member)
    {
        if (session()->getId() === $member->session_id) {
            session()->invalidate();
            session()->regenerateToken();
        }

        $member->delete();
        
        return redirect()->route('member.show')->with('success', 'Member Deleted Successfully');
    }
}
