<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassList;
use Illuminate\Http\Request;

class ClassListController extends Controller
{
    public function show()
    {
        $classLists = ClassList::all();
    
        return view('admin.classes.classes', compact('classLists'));
    }

    public function create(){
        return view('admin.classes.createClasses');
    }

    public function edit(ClassList $classList)
    {
        return view('admin.classes.editClasses', ['classList' => $classList]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trainer' => 'nullable|string|max:255',
            'schedule' => 'nullable|string|max:255',
            'start' => 'nullable|date',
            'end' => 'nullable|date|after_or_equal:start',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        // Create a new record
        ClassList::create([
            'name' => $validated['name'],
            'trainer' => $validated['trainer'] ?? null,
            'schedule' => $validated['schedule'] ?? null,
            'class_start' => $validated['start'] ?? null,
            'class_end' => $validated['end'] ?? null,
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        // Redirect or return response
        return redirect()->route('classList.show')->with('success', 'Class added successfully!');
    }

    public function update(ClassList $classList, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trainer' => 'nullable|string|max:255',
            'schedule' => 'nullable|string|max:255',
            'start' => 'nullable|date',
            'end' => 'nullable|date|after_or_equal:start',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        $classList->update([
            'name' => $validated['name'],
            'trainer' => $validated['trainer'] ?? null,
            'schedule' => $validated['schedule'] ?? null,
            'class_start' => $validated['start'] ?? null,
            'class_end' => $validated['end'] ?? null,
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('classList.show')->with('success', 'Class Updated Successfully');
    }

    public function destroy(ClassList $classList) {
        $classList->delete();
        return redirect()->route('classList.show')->with('success', 'Class Deleted Successfully');
    }
}
