<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
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
            'user_id' => 'nullable|string|min:14|max:14',
            'name' => 'required|string|max:100',
            'specialization' => 'required|string|max:100',
            'phone' => 'required|string|min:11|max:13',
            'availability' => 'nullable|string|max:100',
        ]);

        $user = User::where('unique_id', $validated['user_id'])->first();

        $trainerData = [
            'name' => $validated['name'],
            'user_id' => $user ? $user->unique_id : 'No user account.',
            'specialization' => $validated['specialization'],
            'phone' => $validated['phone'],
            'availability' => $validated['availability'],
        ];

        Trainer::create($trainerData);

        if ($user) {
            $user->update([
                'user_type' => 'Trainer',
                'first_name' => 'Coach',
                'last_name' => $validated['name'],
                'phone' => $validated['phone'],
            ]);
        }
        return redirect()->route('trainer.show')->with('success', 'Trainer successfully created.');
    } 

    public function update(Trainer $trainer, Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|string|min:14|max:14',
            'name' => 'required|string|max:100',
            'specialization' => 'required|string|max:100',
            'phone' => 'required|string|min:11|max:13',
            'availability' => 'nullable|string|max:100',
        ]);
    
        $user = User::where('unique_id', $validated['user_id'])->first();
    
        $trainerData = [
            'name' => $validated['name'],
            'user_id' => $user ? $user->unique_id : $trainer->user_id,
            'specialization' => $validated['specialization'],
            'phone' => $validated['phone'],
            'availability' => $validated['availability'],
        ];
    
        $trainer->update($trainerData);
    
        if ($user) {
            $user->update([
                'last_name' => $validated['name'],
                'phone' => $validated['phone'],
            ]);
        }
    
        return redirect()->route('trainer.show')->with('success', 'Trainer updated successfully.');
    }

    public function destroy(Trainer $trainer) {
        $trainer->delete();
        return redirect(route('trainer.show'))->with('success', 'Trainer removed successfully');
    }
}
