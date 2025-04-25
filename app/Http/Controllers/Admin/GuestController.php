<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->input('search');

        $searchDate = null;
        if ($search) {
            try {
                $searchDate = Carbon::parse($search)->format('Y-m-d');
            } catch (\Exception $e) {
                $searchDate = null;
            }
        }

        $guests = Guest::orderBy('created_at', 'DESC')
            ->when($search, function ($query, $search) use ($searchDate) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('payment_method', 'like', "%{$search}%");

                if ($searchDate) {
                    $query->orWhereDate('created_at', $searchDate);
                }
            })
            ->paginate(10)
            ->appends(['search' => $search]);
    
        return view('admin.guests.guests', compact('guests', 'search'));
    }

    public function create(){
        return view('admin.guests.createGuest');
    }

    public function edit(Guest $guest) {
        return view('admin.guests.editGuest', compact('guest'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'email' => 'nullable|email|max:100',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'phone' => 'required|string|min:11|max:13',
            'address' => 'nullable|string',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|string|max:100|required_if:payment_method,other',
        ], [
            'payment_method.in' => 'The selected payment method is invalid.',
            'other_payment_method.required_if' => 'Please specify the payment method when selecting "Other".',
        ]);

        Guest::create([
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'] ?? null,
            'phone' => $validated['phone'],
            'address' => collect([$validated['city'], $validated['province']])
                ->filter()
                ->isEmpty() ? null : collect([$validated['city'], $validated['province']])
                ->filter()
                ->implode(', '),
            'payment_method' => $validated['payment_method'] === 'other'
                ? $validated['other_payment_method']
                : $validated['payment_method'],
            'is_in_gym' => true,
        ]);
    
        return redirect()->route('guestAttendee.store', [
            'first_name' => urlencode($validated['first_name']),
            'last_name' => $validated['last_name'] ? urlencode($validated['last_name']) : 'null',
            'payment' => urlencode(
                $validated['payment_method'] === 'other' 
                    ? $validated['other_payment_method'] 
                    : $validated['payment_method']
            ),
        ]);
    } 
    
    public function update(Guest $guest, Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email|max:100',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'phone' => 'required|string|min:11|max:13',
            'address' => 'nullable|string',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|string|max:100|required_if:payment_method,other',
        ], [
            'payment_method.in' => 'The selected payment method is invalid.',
            'other_payment_method.required_if' => 'Please specify the payment method when selecting "Other".',
        ]);

        $guest->update([
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'] ?? null,
            'phone' => $validated['phone'],
            'address' => collect([$validated['city'], $validated['province']])
                ->filter()
                ->isEmpty() ? null : collect([$validated['city'], $validated['province']])
                ->filter()
                ->implode(', '),
            'payment_method' => $validated['payment_method'] === 'other'
                ? $validated['other_payment_method']
                : $validated['payment_method'],
        ]);
        return redirect()->route('guest.show')->with('success', 'Guest Information Updated Successfully.');
    }

    public function destroy(Guest $guest) {
        $guest->delete();
        return redirect()->back()->with('success', 'Guest Deleted Successfully');
    }
}
