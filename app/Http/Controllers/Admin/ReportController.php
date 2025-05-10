<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apprentice;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function show()
    {
        $totalRevenue = Transaction::whereRaw('LOWER(status) = ?', ['completed'])
            ->sum('amount');

        $membershipRevenue = Transaction::whereIn('transaction_type', ['membership_avail', 'membership_renew'])
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->sum('amount');
    
        $guestRevenue = Transaction::where('transaction_type', 'membership_guest')
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->sum('amount');

        $reservationsRevenue = Reservation::where('status', 'approved')
            ->sum('amount');

        $studentsRevenue = Student::whereRaw('LOWER(students.status) = ?', ['enrolled'])
            ->join('class_lists', 'students.class_id', '=', 'class_lists.id')
            ->sum('class_lists.price');

        $apprenticesRevenue = Apprentice::whereRaw('LOWER(apprentices.status) = ?', ['enrolled'])
            ->join('trainings', 'apprentices.training_id', '=', 'trainings.id')
            ->sum('trainings.price');

        return view('admin.reports.reports', compact(
            'membershipRevenue',
            'guestRevenue',
            'totalRevenue',
            'reservationsRevenue',
            'studentsRevenue',
            'apprenticesRevenue'
         ));
    }

    public function showAnalytics()
    {
        $totalMembers = User::where('user_type', 'user')
            ->whereNotNull('member_since')
            ->count();

        $activeMembers = User::where('user_type', 'user')
            ->where('membership_validity', '>', now())
            ->count();

        $totalGuests = Guest::count();

        $totalReservations = Reservation::where('status', 'approved')->count();

        $activeStudents = Student::whereRaw('LOWER(status) = ?', ['enrolled'])
            ->where('student_until', '>', now())
            ->count();

        $activeApprentices = Apprentice::whereRaw('LOWER(status) = ?', ['enrolled'])
            ->where('student_until', '>', now())
            ->count();

        return view('admin.analytics.analytics', compact(
            'totalMembers', 
            'activeMembers', 
            'totalGuests', 
            'totalReservations', 
            'activeStudents', 
            'activeApprentices'
        ));
    }


    public function getMembershipData()
    {
        $transactions = Transaction::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->whereIn('transaction_type', ['membership_avail', 'membership_renew'])
            ->where('status', 'completed')
            ->groupByRaw('MONTH(updated_at)')
            ->pluck('total', 'month');

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $transactions[$i] ?? 0;
        }

        return response()->json([
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => $monthlyData,
        ]);
    }

    public function getReservationData()
    {
        // Fetching data from the reservations table where status is approved
        $reservations = Reservation::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->where('status', 'approved')  // Filter by 'approved' status
            ->groupByRaw('MONTH(updated_at)')
            ->pluck('total', 'month');

        $monthlyData = [];
        
        // Ensure there are values for all 12 months (January to December)
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $reservations[$i] ?? 0;  // Default to 0 if no data for that month
        }

        // Return the months and data in JSON format
        return response()->json([
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => $monthlyData,
        ]);
    }

    public function getTopUserAddresses()
    {
        $addresses = User::select('address', DB::raw('count(*) as total'))
            ->whereNotNull('address')
            ->groupBy('address')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'address');

        $addressLabels = $addresses->keys()->map(function ($address) {
            $parts = explode(',', $address);
            return $parts[0];
        });

        $addressData = $addresses->values();

        return response()->json([
            'labels' => $addressLabels,
            'data' => $addressData,
        ]);
    }

}
