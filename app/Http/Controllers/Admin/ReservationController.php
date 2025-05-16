<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityList;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function show()
    {
        $currentTime = Carbon::now();

        $upcomingReservations = Reservation::query()
            ->whereDate('reservation_date', '>', $currentTime->toDateString())
            ->orWhere(function ($query) use ($currentTime) {
                $query->whereDate('reservation_date', '=', $currentTime->toDateString())
                    ->where('start_time', '>', $currentTime->toTimeString());
            })
            ->get();

        $ongoingReservations = Reservation::query()
            ->whereDate('reservation_date', '=', $currentTime->toDateString())
            ->where('start_time', '<=', $currentTime->toTimeString())
            ->where('end_time', '>', $currentTime->toTimeString())
            ->get();

        $pastReservations = Reservation::query()
            ->whereDate('reservation_date', '<', $currentTime->toDateString())
            ->orWhere(function ($subQuery) use ($currentTime) {
                $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString())
                        ->where('end_time', '<=', $currentTime->toTimeString());
            })
            ->get();

        return view('admin.reservations.reservations', compact('upcomingReservations', 'ongoingReservations', 'pastReservations'));
    }

    public function history()
    {
        $currentTime = Carbon::now();

        $pastReservations = Reservation::query()
            ->where(function ($query) use ($currentTime) {
                $query->whereDate('reservation_date', '<', $currentTime->toDateString())
                    ->orWhere(function ($subQuery) use ($currentTime) {
                        $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString())
                                ->whereTime('end_time', '<=', $currentTime->toTimeString());
                    });
            })
            ->orderBy('reservation_date', 'desc')
            ->paginate(10);

        return view('admin.reservations.reservationHistory', compact('pastReservations'));
    }

    public function getCalendarEvents()
    {
        $reservations = Reservation::selectRaw('reservation_date as date, COUNT(*) as count')
            ->groupBy('reservation_date')
            ->get();
    
        return response()->json($reservations);
    }     

    public function viewDetails(Request $request)
    {
        $date = $request->date;
        $reservations = Reservation::all();

        return view('admin.reservations.reservationDetails', compact('reservations', 'date'));
    }

    public function fetchUser($id)
    {
        $user = User::where('unique_id', $id)->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'data' => [
                    'name' => ($user->first_name ?? '') . ' ' . ($user->last_name ?? ''),
                    'phone_number' => $user->phone_number,
                    'address' => $user->address,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ]);
        }
    }

    public function fetchReservedSlots(Request $request)
    {
        $date = $request->query('date');

        // Fetch reservations for the selected date
        $reservations = Reservation::whereDate('reservation_date', $date)->get();

        $reservedSlots = [];

        // Loop through reservations and determine reserved time slots
        foreach ($reservations as $reservation) {
            $startHour = Carbon::parse($reservation->start_time)->hour;
            $endHour = Carbon::parse($reservation->end_time)->hour;

            for ($hour = $startHour; $hour < $endHour; $hour++) {
                $reservedSlots[] = $hour;
            }
        }

        return response()->json([
            'success' => true,
            'reservedSlots' => $reservedSlots,
        ]);
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

    public function create()
    {
        $facility_lists = FacilityList::all();

        return view('admin.reservations.createReservation', compact('facility_lists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|string|min:14|max:14|exists:users,unique_id',
            'name' => 'required|string|min:3|max:255',
            'number' => 'required|string|min:11|max:11',
            'address' => 'required|string|max:255',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'number_of_people' => 'nullable|integer',
            'facility_id' => 'required|exists:facility_lists,id',
            'payment_status' => 'required|string|max:255',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);
        
        $startDateTime = Carbon::parse($validated['reservation_date'] . ' ' . $validated['start_time']);

        if ($startDateTime->isPast()) {
            return back()->withErrors('The start time must be greater than the current time.')->withInput();
        }

        $user = $validated['user_id'] 
        ? User::where('unique_id', $validated['user_id'])->first() 
        : null;

        $facility = FacilityList::find($validated['facility_id']);

        $startTime = new Carbon($validated['start_time']);
        $endTime = new Carbon($validated['end_time']);
        $hours = abs($endTime->diffInHours($startTime));
        $reservation_cost = $hours * ($facility->hourly_rate ?? 0);

        Reservation::create([
            'user_id' => $user?->id,
            'name' => $user 
                ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) 
                : $validated['name'],
            'email' => $user?->email,
            'number' => $user?->number ?? $validated['number'],
            'address' => $user?->address ?? $validated['address'],
            'reservation_type' => $facility->name ?? 'Unknown Facility',
            'amount' => $reservation_cost,
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'number_of_people' => $validated['number_of_people'] ?? null,
            'payment_method' => $validated['payment_method'] === 'other'
                ? $validated['other_payment_method']
                : $validated['payment_method'],
            'payment_status' => $validated['payment_status'] ?? 'pending',
        ]);

        return redirect()->route('reservation.show')->with('success', 'Reservation created successfully!');
    }

    public function showFinal()
    {
        $currentTime = Carbon::now();
    
        // Upcoming Reservations
        $upcomingReservations = Reservation::query()
        ->whereDate('reservation_date', '>', $currentTime->toDateString())
        ->orWhere(function ($query) use ($currentTime) {
            $query->whereDate('reservation_date', '=', $currentTime->toDateString())
                  ->where(function ($timeQuery) use ($currentTime) {
                      $timeQuery->whereNull('start_time')
                                ->orWhere('start_time', '>', $currentTime->toTimeString());
                  })
                  ->where(function ($excludeOngoingQuery) use ($currentTime) {
                      $excludeOngoingQuery->whereNull('end_time')
                                          ->orWhere('end_time', '<=', $currentTime->toTimeString());
                  });
        })
        ->get();

    
        // Ongoing Reservations
        $ongoingReservations = Reservation::query()
        ->whereDate('reservation_date', '=', $currentTime->toDateString())
        ->where('start_time', '<=', $currentTime->toTimeString())
        ->where(function ($query) use ($currentTime) {
            $query->whereNull('end_time')
                  ->orWhere('end_time', '>', $currentTime->toTimeString());
        })
        ->get();
    
        // Past Reservations
        $pastReservations = Reservation::query()
        ->where(function ($query) use ($currentTime) {
            $query->whereDate('reservation_date', '<', $currentTime->toDateString())
                  ->orWhere(function ($subQuery) use ($currentTime) {
                      $subQuery->whereDate('reservation_date', '=', $currentTime->toDateString())
                               ->whereNotNull('start_time')
                               ->where('end_time', '<=', $currentTime->toTimeString());
                  });
        })
        ->get();

        return view('testing.reservations-final', compact('upcomingReservations', 'ongoingReservations', 'pastReservations'));
    }      

    public function edit(Reservation $reservation)
    {
        $facility_lists = FacilityList::all();

        return view('admin.reservations.editReservation', compact('reservation', 'facility_lists'));
    }

    public function paid(Reservation $reservation)
    {
        $reservation->update([
            'payment_status' => 'paid',
        ]);

        return redirect()->back()->with('success', 'Reservation was marked as paid successfully.');
    }
    
    public function update(Request $request, Reservation $reservation)
    {
        $reservationStart = Carbon::parse($reservation->reservation_date . ' ' . $reservation->start_time);
        $isPastReservation = $reservationStart->isPast();

        $start_time = $request->start_time ? Carbon::parse($request->start_time)->format('H:i') : null;
        $end_time = $request->end_time ? Carbon::parse($request->end_time)->format('H:i') : null;

        $request->merge([
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);

        $validated = $request->validate([
            'user_id' => 'nullable|string|min:14|max:14|exists:users,unique_id',
            'name' => 'required|string|min:3|max:255',
            'number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'reservation_date' => [
                'required',
                'date',
                $isPastReservation ? 'before_or_equal:today' : 'after_or_equal:today'
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if (!$value) {
                        $fail('Please select at least one time slot.');
                    }
                }
            ],
            'end_time' => 'nullable|date_format:H:i',
            'number_of_people' => 'nullable|integer',
            'facility_id' => 'required|exists:facility_lists,id',
            'payment_status' => 'required|string|max:255',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);

        $user = $validated['user_id'] 
            ? User::where('unique_id', $validated['user_id'])->first() 
            : null;

        $facility = FacilityList::find($validated['facility_id']);

        $startTime = new Carbon($validated['start_time']);
        $endTime = $validated['end_time'] ? new Carbon($validated['end_time']) : null;
        $hours = $endTime ? abs($endTime->diffInHours($startTime)) : 0;
        $reservation_cost = $hours * ($facility->hourly_rate ?? 0);

        $reservation->update([
            'user_id' => $user?->id,
            'name' => $user 
                ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) 
                : $validated['name'],
            'email' => $user?->email,
            'number' => $user?->number ?? $validated['number'],
            'address' => $user?->address ?? $validated['address'],
            'reservation_type' => $facility->name ?? 'Unknown Facility',
            'amount' => $reservation_cost,
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'number_of_people' => $validated['number_of_people'] ?? null,
            'payment_method' => $validated['payment_method'] === 'other'
                ? $validated['other_payment_method']
                : $validated['payment_method'],
            'payment_status' => $validated['payment_status'] ?? 'pending',
        ]);

        return redirect()->route('reservation.show')->with('success', 'Reservation updated successfully!');
    }

    public function cancel(Reservation $reservation)
    {
        $currentTime = Carbon::now();

        if ($reservation->reservation_date < $currentTime->toDateString() || 
            ($reservation->reservation_date === $currentTime->toDateString() && $reservation->start_time <= $currentTime->toTimeString())) {
            return back()->withErrors('Reservation is already ended.');
        }

        $reservation->delete();

        return redirect()->route('reservation.show')->with('success', 'Reservation Cancelled Successfully.');
    }


}
