<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassList;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function show()
    {
        $trainers = Trainer::with(['user'])->get();

        return view('admin.trainers.trainers', ['trainers' => $trainers]);
    }

    public function create(){
        return view('admin.trainers.createTrainer');
    }

    public function edit(Trainer $trainer) {
        return view('admin.trainers.editTrainer', compact('trainer'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:trainers',
            'specialization' => 'required|string|max:100',
            'phone' => 'required|string|min:11|max:13',
            'availability' => 'nullable|string|max:100',
        ]);

        $trainerData = [
            'name' => $validated['name'],
            'specialization' => $validated['specialization'],
            'phone' => $validated['phone'],
            'availability' => $validated['availability'],
        ];

        Trainer::create($trainerData);

        return redirect()->route('trainer.show')->with('success', 'Trainer successfully created.');
    } 

    public function update(Trainer $trainer, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:trainers,name,' . $trainer->id,
            'specialization' => 'required|string|max:100',
            'phone' => 'required|string|min:11|max:13',
            'availability' => 'nullable|string|max:100',
        ]);
    
        $trainerData = [
            'name' => $validated['name'],
            'specialization' => $validated['specialization'],
            'phone' => $validated['phone'],
            'availability' => $validated['availability'],
        ];
    
        $trainer->update($trainerData);
    
        return redirect()->route('trainer.show')->with('success', 'Trainer updated successfully.');
    }

    public function destroy(Trainer $trainer)
    {
        Training::where('trainer', $trainer->name)->delete();

        ClassList::where('trainer', $trainer->name)->delete();

        $trainer->delete();
        return redirect(route('trainer.show'))->with('success', 'Trainer removed successfully');
    }
}
