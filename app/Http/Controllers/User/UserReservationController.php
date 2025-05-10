<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FacilityList;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReservationController extends Controller
{
    public function create()
    {
        $currentTime = Carbon::now();
        $user = Auth::user();
    
        $upcomingReservations = Reservation::query()
        ->where('user_id', $user->unique_id) // Filter by user
        ->where(function ($query) use ($currentTime) {
            $query->where(function ($subQuery) use ($currentTime) {
                $subQuery->whereDate('reservation_date', '>', $currentTime->toDateString()) // Future date
                         ->orWhere(function ($innerQuery) use ($currentTime) {
                             $innerQuery->whereDate('reservation_date', '=', $currentTime->toDateString()) // Today
                                        ->where(function ($timeQuery) use ($currentTime) {
                                            $timeQuery->whereNull('start_time') // No start time
                                                      ->orWhere('start_time', '>', $currentTime->toTimeString()); // Start time in future
                                        });
                         });
            })
            ->orWhere(function ($subQuery) use ($currentTime) {
                $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString()) // Today
                         ->where(function ($timeQuery) use ($currentTime) {
                             $timeQuery->whereNull('start_time') // No start time
                                       ->orWhere('start_time', '>', $currentTime->toTimeString()) // Start time in future
                                       ->where(function ($endQuery) use ($currentTime) {
                                           $endQuery->whereNull('end_time') // No end time
                                                    ->orWhere('end_time', '>', $currentTime->toTimeString()); // End time in future
                                       });
                         });
            });
        })
        ->get();
    
        // Ongoing Reservations
        $ongoingReservations = Reservation::query()
            ->where('user_id', $user->unique_id)
            ->where(function ($query) use ($currentTime) {
                $query->where(function ($subQuery) use ($currentTime) {
                    $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString()) // Today
                            ->where('start_time', '<=', $currentTime->toTimeString()) // Start time in past or now
                            ->where(function ($timeQuery) use ($currentTime) {
                                $timeQuery->whereNull('end_time')
                                        ->orWhere('end_time', '>', $currentTime->toTimeString()); // End time in future
                            });
                });
            })
            ->first();
    
        // Past Reservations
        $pastReservations = Reservation::query()
            ->where('user_id', $user->unique_id)
            ->where(function ($query) use ($currentTime) {
                $query->whereDate('reservation_date', '<', $currentTime->toDateString()) // Past date
                      ->orWhere(function ($subQuery) use ($currentTime) {
                          $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString()) // Today
                                   ->whereNotNull('start_time') // Start time is set
                                   ->where('end_time', '<=', $currentTime->toTimeString()); // End time in the past
                      });
            })
            ->get();

        $facility_lists = FacilityList::all();
    
        return view('user.reservation', compact('upcomingReservations', 'ongoingReservations', 'pastReservations', 'facility_lists', 'user'));
    }       

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'facility_id' => 'required|exists:facility_lists,id',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);

        $user = Auth::user();

        $facility = FacilityList::find($validated['facility_id']);

        $startTime = new Carbon($validated['start_time']);
        $endTime = new Carbon($validated['end_time']);
        $hours = abs($endTime->diffInHours($startTime));
        $reservation_cost = $hours * ($facility->hourly_rate ?? 0);

        Reservation::create([
            'user_id' => $user->unique_id,
            'name' => ($user->first_name ?? '') . ' ' . ($user->last_name ?? ''),
            'email' => $user->email,
            'number' => $user->number ?? $validated['number'],
            'address' => $user->address ?? $validated['address'],
            'reservation_type' => $facility->name ?? 'Unknown Facility',
            'amount' => $reservation_cost,
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'payment_method' => $validated['payment_method'] === 'other'
                ? $validated['other_payment_method']
                : $validated['payment_method'],
            'payment_status' => 'pending',
        ]);

        $user->update([
            'number' => $user->number ?? $validated['number'],
            'address' => $user->address ?? $validated['address'],
        ]);

        return redirect()->back()->with('success', 'Reservation created successfully!');
    }
}
