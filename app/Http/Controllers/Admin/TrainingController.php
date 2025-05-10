<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function show()
    {
        $trainings = Training::all();
    
        return view('admin.trainings.trainings', compact('trainings'));
    }

    public function create()
    {
        $trainers = Trainer::all();

        return view('admin.trainings.createTraining', compact('trainers'));
    }

    public function edit(Training $training)
    {
        $trainers = Trainer::all();

        return view('admin.trainings.editTraining', [
            'training' => $training,
            'trainers' => $trainers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trainer' => 'required|exists:trainers,id',
            'schedule' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        $trainer = Trainer::find($validated['trainer']);

        if (!$trainer) {
            return redirect()->back()->withErrors(['trainer' => 'Trainer not found.']);
        }

        Training::create([
            'name' => $validated['name'],
            'trainer' => $trainer->name,
            'schedule' => $validated['schedule'],
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('training.show')->with('success', 'Training added successfully!');
    }

    public function update(Training $training, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trainer' => 'required|exists:trainers,id',
            'schedule' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        $trainer = Trainer::find($validated['trainer']);

        if (!$trainer) {
            return redirect()->back()->withErrors(['trainer' => 'Trainer not found.']);
        }

        $training->update([
            'name' => $validated['name'],
            'trainer' => $trainer->name,
            'schedule' => $validated['schedule'],
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('training.show')->with('success', 'Training Updated Successfully');
    }

    public function destroy(Training $training) {
        $training->delete();
        return redirect()->route('training.show')->with('success', 'Training Deleted Successfully');
    }
}
