<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassList;
use App\Models\Trainer;
use Illuminate\Http\Request;

class ClassListController extends Controller
{
    public function show()
    {
        $classLists = ClassList::all();
    
        return view('admin.classes.classes', compact('classLists'));
    }

    public function create()
    {
        $trainers = Trainer::all();

        return view('admin.classes.createClasses', compact('trainers'));
    }

    public function edit(ClassList $classList)
    {
        $trainers = Trainer::all();

        return view('admin.classes.editClasses', [
            'classList' => $classList,
            'trainers' => $trainers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trainer' => 'required|exists:trainers,id',
            'schedule' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        $trainer = Trainer::find($validated['trainer']);

        if (!$trainer) {
            return redirect()->back()->withErrors(['trainer' => 'Trainer not found.']);
        }

        ClassList::create([
            'name' => $validated['name'],
            'trainer' => $trainer->name,
            'schedule' => $validated['schedule'],
            'class_start' => $validated['start'],
            'class_end' => $validated['end'],
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('classList.show')->with('success', 'Class added successfully!');
    }

    public function update(ClassList $classList, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trainer' => 'required|exists:trainers,id',
            'schedule' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        $trainer = Trainer::find($validated['trainer']);

        if (!$trainer) {
            return redirect()->back()->withErrors(['trainer' => 'Trainer not found.']);
        }

        $classList->update([
            'name' => $validated['name'],
            'trainer' => $trainer->name,
            'schedule' => $validated['schedule'],
            'class_start' => $validated['start'],
            'class_end' => $validated['end'],
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
