<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function show(){
        $rates = Rate::all();

        return view('admin.rates.rates', ['rates' => $rates]);
    }

    public function create(){
        return view('admin.rates.createRate');
    }

    public function edit(Rate $rate) {
        return view('admin.rates.editRate', ['rate' => $rate]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'price' => 'required|integer|min:0', // Changed to integer
            'color' => 'nullable|string|size:7',
            'validity_value' => 'required|integer|min:1',
            'validity_unit' => 'required|in:day,month,year',
            'description' => 'nullable|string|max:255',
            'perks' => 'nullable|string|max:255',
        ]);

        // Validate validity constraints
        if ($request->validity_unit == 'day' && ($request->validity_value < 1 || $request->validity_value > 31)) {
            return back()->withErrors(['validity_value' => 'Days must be between 1 and 31.']);
        }
        
        if ($request->validity_unit == 'month' && ($request->validity_value < 1 || $request->validity_value > 12)) {
            return back()->withErrors(['validity_value' => 'Months must be between 1 and 12.']);
        }

        if ($request->validity_unit == 'year' && ($request->validity_value < 1 || $request->validity_value > 3)) {
            return back()->withErrors(['validity_value' => 'Years must be between 1 and 3.']);
        }


        // Handle real month days
        if ($request->validity_unit == 'day') {
            $maxDays = cal_days_in_month(CAL_GREGORIAN, now()->month, now()->year);
            if ($request->validity_value > $maxDays) {
                return back()->withErrors(['validity_value' => "Invalid days for the current month (Max: $maxDays)."]);
            }
        }

        Rate::create([
            'name' => $request->name,
            'price' => $request->price,
            'color' => $request->color,
            'validity_value' => $request->validity_value,
            'validity_unit' => $request->validity_unit,
            'description' => $request->description ?? null,
            'perks' => $request->perks ?? null,
        ]);
    
        return redirect()->route('rate.show')->with('success', 'Membership Plan Created Successfully.');
    }

    public function update(Rate $rate, Request $request) {

        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'price' => 'required|integer|min:0',
            'color' => 'nullable|string|size:7',
            'validity_value' => 'required|integer|min:1',
            'validity_unit' => 'required|in:day,month,year',
            'perks' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
    
        if ($request->validity_unit === 'day' && ($request->validity_value < 1 || $request->validity_value > 31)) {
            return back()->withErrors(['validity_value' => 'Days must be between 1 and 31.']);
        }
    
        if ($request->validity_unit === 'month' && ($request->validity_value < 1 || $request->validity_value > 12)) {
            return back()->withErrors(['validity_value' => 'Months must be between 1 and 12.']);
        }
    
        if ($request->validity_unit === 'year' && ($request->validity_value < 1 || $request->validity_value > 3)) {
            return back()->withErrors(['validity_value' => 'Years must be between 1 and 3.']);
        }

        if ($request->validity_unit === 'day') {
            $maxDays = cal_days_in_month(CAL_GREGORIAN, now()->month, now()->year);
            if ($request->validity_value > $maxDays) {
                return back()->withErrors(['validity_value' => "Invalid days for the current month (Max: $maxDays)."]);
            }
        }
    
        $rate->update([
            'name' => $request->name,
            'price' => $request->price,
            'color' => $request->color,
            'validity_value' => $request->validity_value,
            'validity_unit' => $request->validity_unit,
            'perks' => $request->perks ?? null,
            'description' => $request->description ?? null,
        ]);

        return redirect()->route('rate.show')->with('success', 'Membership Plan Updated Successfully.');
    }

    public function destroy(Rate $rate){
        $rate->delete();
        return redirect(route('rate.show'))->with('success', 'Membership Plan Deleted Successfully.');
    }
}
