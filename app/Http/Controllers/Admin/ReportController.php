<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function show()
    {
        // Calculate membership revenue
        $membershipRevenue = Transaction::whereIn('transaction_type', ['membership_avail', 'membership_renew'])
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->sum('amount');
    
        // Calculate guest revenue
        $guestRevenue = Transaction::where('transaction_type', 'membership_guest')
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->sum('amount');
    
        // Pass the data to the view
        return view('admin.reports.reports', compact('membershipRevenue', 'guestRevenue'));
    }
    

    public function showAnalytics(){

        return view('admin.analytics.analytics');
    }
}
