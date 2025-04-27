<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function calendar()
    {
        $currentTime = Carbon::now();
    
        // Upcoming Reservations
        $upcomingReservations = Reservation::query()
        ->whereNotNull('reservation_date')
        ->where(function ($query) use ($currentTime) {
            $query->whereDate('reservation_date', '>', $currentTime->toDateString())
                  ->orWhere(function ($subQuery) use ($currentTime) {
                      $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString())
                               ->where(function ($timeQuery) use ($currentTime) {
                                   $timeQuery->whereNull('start_time')
                                             ->orWhere('start_time', '>', $currentTime->toTimeString());
                               });
                  });
        })
        ->get();

    
        // Ongoing Reservations
        $ongoingReservations = Reservation::query()
            ->whereNotNull('reservation_date')
            ->whereDate('reservation_date', '=', $currentTime->toDateString())
            ->where('start_time', '<=', $currentTime->toTimeString())
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('end_time')
                    ->orWhere('end_time', '>', $currentTime->toTimeString());
            })
            ->get();
    
        // Past Reservations
        $pastReservations = Reservation::query()
            ->whereNotNull('reservation_date')
            ->where(function ($query) use ($currentTime) {
                $query->whereDate('reservation_date', '<', $currentTime->toDateString())
                    ->orWhere(function ($subQuery) use ($currentTime) {
                        $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString())
                                ->whereNotNull('start_time')
                                ->where('end_time', '<=', $currentTime->toTimeString());
                    });
            })
            ->get();
    
        return view('admin.reservations.reservations', compact('upcomingReservations', 'ongoingReservations', 'pastReservations'));
    }       

    public function getEvents(Request $request)
    {
        $currentTime = Carbon::now();
    
        // Fetch reservations
        $reservations = Reservation::query()
            ->whereNotNull('reservation_date') // Ensure there's a reservation date
            ->where(function ($query) use ($currentTime) {
                $query->where(function ($subQuery) use ($currentTime) {
                    $subQuery->whereDate('reservation_date', '>', $currentTime->toDateString()) // Upcoming date
                             ->orWhere(function ($innerQuery) use ($currentTime) {
                                 $innerQuery->whereDate('reservation_date', '=', $currentTime->toDateString()) // Today
                                            ->where(function ($timeQuery) use ($currentTime) {
                                                $timeQuery->whereNull('start_time') // No start time, default to upcoming
                                                          ->orWhere('start_time', '>', $currentTime->toTimeString()); // Upcoming time
                                            });
                             });
                })
                ->orWhere(function ($subQuery) use ($currentTime) {
                    $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString()) // Today
                             ->where('start_time', '<=', $currentTime->toTimeString()) // Ongoing time
                             ->where(function ($timeQuery) use ($currentTime) {
                                 $timeQuery->whereNull('end_time') // No end time
                                           ->orWhere('end_time', '>=', $currentTime->toTimeString()); // Ongoing time
                             });
                });
            })
            ->get();
    
        $events = [];
    
        foreach ($reservations as $reservation) {
            // Concatenate date and time for start
            $startDateTime = $reservation->reservation_date;
            $startTime = $reservation->start_time ? (' ' . $reservation->start_time) : null;
            $start = $startDateTime . $startTime;
    
            // Default end time to 11 PM if not provided
            $endDateTime = $reservation->reservation_date;
            $endTime = $reservation->end_time ?? '23:00:00';
            $end = $endDateTime . ' ' . $endTime;
    
            $events[] = [
                'id' => $reservation->id,
                'title' => 'Reservation',
                'start' => $start,
                'end' => $end,
                'description' => $reservation->reservation_type . ' Reservation on ' . $reservation->reservation_date .
                    ' by ' . $reservation->name .
                    ' from ' . ($reservation->start_time ?? 'unspecified start time') .
                    ' to ' . ($reservation->end_time ?? 'unspecified end time'),
                'color' => $reservation->color ?? '#e6e6e6',
                'allDay' => is_null($reservation->start_time), // If no time specified, make it all-day
            ];
        }
    
        return response()->json($events);
    } 

    public function getPreview(Request $request)
    {
        $currentTime = Carbon::now();
    
        // Fetch only incoming reservations
        $reservations = Reservation::query()
            ->whereNotNull('reservation_date') // Ensure there's a reservation date
            ->where(function ($query) use ($currentTime) {
                $query->whereDate('reservation_date', '>', $currentTime->toDateString()) // Future dates
                      ->orWhere(function ($subQuery) use ($currentTime) {
                          $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString()) // Today's date
                                   ->where(function ($timeQuery) use ($currentTime) {
                                       $timeQuery->whereNull('start_time') // No start time, default as upcoming
                                                 ->orWhere('start_time', '>', $currentTime->toTimeString()); // Upcoming time
                                   });
                      });
            })
            ->get(['id', 'reservation_date', 'start_time', 'end_time', 'reservation_type']); // Fetch only required fields
    
        $events = [];
    
        foreach ($reservations as $reservation) {
            // Concatenate date and time for start
            $start = $reservation->reservation_date . ($reservation->start_time ? ' ' . $reservation->start_time : '');
    
            // Default end time to 11 PM if not provided
            $end = $reservation->reservation_date . ' ' . ($reservation->end_time ?? '23:00:00');
    
            $events[] = [
                'title' => $reservation->reservation_type ?? 'Reservation',
                'start' => $start,
                'end' => $end,
            ];
        }
    
        return response()->json($events);
    }    

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'nullable|email|max:255',
            'number' => 'nullable|string|max:15',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'number_of_people' => 'nullable|integer|min:1',
        ]);

        // Transform time inputs to ensure correct format
        $start_time = $validatedData['start_time']
            ? Carbon::createFromFormat('H:i', $validatedData['start_time'])->format('H:i')
            : null;

        $end_time = $validatedData['end_time']
            ? Carbon::createFromFormat('H:i', $validatedData['end_time'])->format('H:i')
            : null;

        $user = Auth::user();

        Reservation::create([
            'user_id' => $user->unique_id ?? null,
            'name' => $validatedData['name'] ?? $user->name,
            'email' => $validatedData['email'] ?? $user->email,
            'number' => $validatedData['number'] ?? $user->phone ?? null,
            'reservation_type' => 'Court',
            'reservation_date' => $validatedData['reservation_date'],
            'start_time' => $start_time,
            'end_time' => $end_time,
            'number_of_people' => $validatedData['number_of_people'] ?? null,
            'payment_status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Reservation created successfully!');
    }

}
