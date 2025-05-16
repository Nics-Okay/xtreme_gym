<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Guest;
use App\Models\Rate;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendeeController extends Controller
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

        $attendees = Attendee::orderBy('created_at', 'DESC')
        ->when($search, function ($query, $search) use ($searchDate) {
            $query->where('membership_type', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('membership_status', 'like', "%{$search}%");

            if ($searchDate) {
                $query->orWhereDate('membership_validity', $searchDate)
                      ->orWhereDate('time_in', $searchDate)
                      ->orWhereDate('time_out', $searchDate)
                      ->orWhereDate('created_at', $searchDate);
            }
        })
        ->paginate(10)
        ->appends(['search' => $search]);
    
        return view('admin.attendees.attendees', compact('attendees', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identification' => 'required|string',
        ]);

        $identification = strtolower(trim($request->identification));

        $user = User::where('unique_id', $identification)->first();

        // Check using name
        if (!$user) {
            $user = User::whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) = ?", [$identification])->first();
        }
    
        // Check using nickname
        if (!$user) {
            $user = User::whereRaw("LOWER(nickname) = ?", [$identification])->first();
        }

        // Check using phone number (normalize phone number here)
        if (!$user) {
            $normalizedPhone = preg_replace('/[^0-9]/', '', $identification); // Normalize the phone number
            $user = User::where('phone', $normalizedPhone)->first();
        }

        if (!$user) {
            $guest = Guest::where('unique_id', $identification)->first();

            if (!$guest) {
                $normalizedPhone = preg_replace('/[^0-9]/', '', $identification);
                $guest = Guest::where('phone', $normalizedPhone)->first();
            }
            
            // Check using name if unique_id is not provided or doesn't match any guest
            if (!$guest) {
                $guest = Guest::where(function ($query) use ($identification) {
                    $query->whereRaw("LOWER(first_name) = ?", [$identification])
                          ->orWhereRaw("LOWER(CONCAT(first_name, ' ', last_name)) = ?", [$identification]);
                })->first();
            }

            if ($guest) {
                // Guest found, check if they are already in the gym
                if ($guest->is_in_gym) {
                    $now = Carbon::now('Asia/Manila');
    
                    // Locate the most recent attendee record for the guest
                    $attendee = Attendee::where('user_id', $guest->unique_id) // Match guest's unique ID
                        ->whereNull('time_out') // Ensure time_out is null
                        ->latest() // Get the most recent record
                        ->first();
    
                    if ($attendee) {

                        $attendee->update([
                            'time_out' => $now, // Record the time out
                        ]);
    
                        // Update guest's is_in_gym status
                        $guest->update([
                            'is_in_gym' => false, // Mark guest as out of the gym
                        ]);
    
                        return redirect()->back()->with('success', 'Guest time-out recorded successfully.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Invalid guest.'); // Guest is not in the gym
                }
            }
            return redirect()->back()->with('error', 'Member not found.');
        }

        // If user doesn't have a membership, return an error
        if ($user->membership_validity === 'null' || strtolower($user->membership_status) === 'inactive') {
            return redirect()->back()->with('error', 'No active membership.');
        }

        if (Carbon::parse($user->membership_validity, 'Asia/Manila')->isPast()) {
            $user->update([
                'membership_status' => 'Expired',
            ]);
    
            return redirect()->back()->with('error', 'Membership Expired.');
        }
            
        if ($user->is_in_gym) {
            // User is already in the gym, record time out
            $attendee = Attendee::with('user') // Load the related user
            ->where('user_id', $user->unique_id) // Filter by the user's unique ID
            ->whereNull('time_out') // Ensure the time_out is null
            ->latest() // Get the most recent record
            ->first();
                
            $now = Carbon::now('Asia/Manila');

            if ($attendee) {
                $timeIn = Carbon::parse($attendee->time_in, 'Asia/Manila');
                $hoursDifference = $timeIn->diffInMinutes($now) / 60;

                $attendee->update([
                    'time_out' => $now,
                ]);

                // Update the user's active hours and visits
                $user->visits += 1;
                $user->update([
                    'active_hours' => $user->active_hours + $hoursDifference,
                    'visits' => $user->visits,
                    'is_in_gym' => false,
                ]);
            }
                return redirect()->back()->with('success', 'Time out recorded successfully.');
            
        } else {
            $now = Carbon::now('Asia/Manila');
            Attendee::create([
                'user_id' => $user->unique_id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'membership_type' => $user->membership_type,
                'membership_status' => $user->membership_status,
                'membership_validity' => $user->membership_validity,
                'time_in' => $now,
            ]);

            $user->update([
                'is_in_gym' => true,
            ]);

            return redirect()->back()->with('success', 'Time in recorded successfully.');
        }
        return redirect()->back()->with('error', 'Recording unsuccesful.');
    }

    public function guestStore($first_name, $last_name, $payment)
    {
        $last_name = $last_name !== 'null' ? $last_name : null;

        $guest = Guest::where('first_name', $first_name)
        ->where('last_name', $last_name)
        ->first();

        if (!$guest) {
            return redirect()->back()->withErrors(['error' => 'Guest not found.']);
        }

        $rate = Rate::where('name', 'walk-in')->firstOrFail();
    
        if (!isset($rate->price)) {
            return redirect()->back()->withErrors(['error' => 'Rate price is not set.']);
        }

        $now = Carbon::now('Asia/Manila');
    
        DB::transaction(function () use ($guest, $rate, $payment, $now) {
            Attendee::create([
                'user_id' => $guest->unique_id,
                'name' => $guest->first_name . ' ' . ($guest->last_name ?? ''),
                'membership_type' => $rate->name,
                'membership_status' => 'Limited',
                'membership_validity' => $now->addDay(),
                'time_in' => $now,
            ]);

            Transaction::create([
                'user_id' => $guest->unique_id,
                'name' => $guest->first_name . ' ' . ($guest->last_name ?? ''),
                'payment_method' => $payment,
                'transaction_type' => 'membership_guest',
                'payment_code' => $rate->id,
                'amount' => $rate->price,
                'status' => 'Completed',
                'remarks' => 'Walk-in',
            ]);
        });
    
        return redirect()->route('guest.show')->with('success', 'Transaction for ' . $guest->first_name . ' ' . $guest->last_name . ' completed successfully!');
    }

    public function addMemberAttendee()
    {
        return view('admin.attendees.addMemberAttendee');
    }

    public function addGuestAttendee()
    {
        return view('admin.attendees.addGuestAttendee');
    }


    public function destroy(Attendee $attendee){
        $attendee->delete();
        return redirect(route('attendee.show'))->with('success', 'Attendee Deleted Successfully.');
    }
}
