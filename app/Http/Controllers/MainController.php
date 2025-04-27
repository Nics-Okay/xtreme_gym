<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function dashboard()
    {
        $lockedStatus = auth()->user()->locked; 

        $notifications = Notification::where('is_read', false)
        ->orderBy('created_at', 'desc')
        ->get();

        $notification_count = $notifications->count();

        $year = Carbon::now()->year;

        $activeMembers = User::where('membership_validity', '>', now())->count();

        $totalMembers = User::whereNotNull('membership_validity')->count();

        $attendees = Attendee::whereDate('time_in', today())
            ->whereNull('time_out')
            ->count();

        $currentTime = Carbon::now();
    
        // Upcoming Reservations
        $upcomingReservations = Reservation::query()
            ->whereNotNull('reservation_date') // Ensure there's a reservation date
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
                             ->where('start_time', '>', $currentTime->toTimeString()) // Start time in future
                             ->where('end_time', '>', $currentTime->toTimeString()); // End time also in future
                });
            })
            ->get();


        return view('admin.dashboard.dashboard', compact(
            'lockedStatus',
            'notifications',
            'notification_count',
            'year',
            'activeMembers',
            'totalMembers',
            'attendees',
            'upcomingReservations'));
    }

    public function getRevenueSummary()
    {
        $revenueData = DB::table('transactions')
            ->selectRaw('MONTH(updated_at) as month, SUM(amount) as total_revenue')
            ->groupBy(DB::raw('MONTH(updated_at)'))
            ->pluck('total_revenue', 'month');

        $formattedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedData[] = $revenueData->get($i, 0); // Default to 0 if no data
        }

        return response()->json([
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'revenues' => $formattedData,
        ]);
    }

    public function getNewNotificationsCount()
    {
        $newNotifications = Notification::where('is_read', false)->count();
        return response()->json(['new_notifications' => $newNotifications]);
    }

    public function home()
    {
        $events = Event::all();

        return view('user.home', compact('events'));
    }

    public function showRightDashboard()
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Please log in first.']);
        }
    
        switch ($user->user_type) {
            case 'admin':
                return redirect()->route('dashboard');
            case 'user':
                return redirect()->route('user.home');
            default:
                return redirect()->route('index')->with('error', 'Error. Please ask for assistance.');
        }
    }

    public function unlock(Request $request)
    {
        $request->validate(['pin_code' => 'required|digits:6']);

        if (Hash::check($request->pin_code, auth()->user()->lock_code)) {
            auth()->user()->update(['locked' => false]);

            session()->flash('status', 'Unlocked Successfully');
        
            return response()->json([
                'status' => 'unlocked',
                'message' => session('status')
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid PIN'], 403);
    }

    public function lock()
    {
        auth()->user()->update(['locked' => true]);
        return response()->json(['status' => 'locked']);
        /* return redirect()->back()->with('status', 'Admin functions locked.'); */
    }
    
}

