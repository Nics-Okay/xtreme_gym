<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityList;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function show(){
        $facility_lists = FacilityList::all();

        return view('admin.facilities.facilities', ['facility_lists' => $facility_lists]);
    }

    public function create(){
        return view('admin.facilities.createFacility');
    }

    public function edit(FacilityList $facility_list) {
        return view('admin.facilities.editFacility', ['facility_list' => $facility_list]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:facility_lists,name|max:255',
            'hourly_rate' => 'required|integer|min:0',
            'max_capacity' => 'required|integer|min:1',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'status' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        FacilityList::create([
            'name' => $validated['name'],
            'hourly_rate' => $validated['hourly_rate'],
            'max_capacity' => $validated['max_capacity'],
            'open_time' => $validated['open_time'],
            'close_time' => $validated['close_time'],
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('facility.show')->with('success', 'Facility Created Successfully.');
    }

    public function destroy(FacilityList $facility_list){
        $facility_list->delete();
        return redirect()->route('facility.show')->with('success', 'Facility Deleted Successfully.');
    }
}
