<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
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
    
        return view('user.reservation', compact('upcomingReservations', 'ongoingReservations', 'pastReservations'));
    }       
}
