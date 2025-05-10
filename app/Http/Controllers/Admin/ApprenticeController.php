<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apprentice;
use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;

class ApprenticeController extends Controller
{
    public function show()
    {
        $apprentices = Apprentice::with(['training', 'user'])
        ->whereRaw('LOWER(status) = ?', ['enrolled'])
        ->orderBy('created_at', 'DESC')
        ->paginate(10);
    
        return view('admin.apprentices.apprentices', compact('apprentices'));
    }

    public function create()
    {
        $trainings = Training::all();

        return view('admin.apprentices.createApprentice', compact('trainings'));
    }

    public function edit(Apprentice $apprentice)
    {
        $trainings = Training::all();

        return view('admin.apprentices.editApprentice', compact('apprentice', 'trainings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|string|max:100|exists:users,unique_id',
            'training_id' => 'required|exists:trainings,id',
            'payment_status' => 'nullable|string|in:completed,pending',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);

        $user = User::where('unique_id', $validated['user_id'])->first();

        $training = Training::find($validated['training_id']);

        Apprentice::create([
            'user_id' => $user?->unique_id,
            'class_id' => $training->id,
            'attended' => 1,
            'status' => 'enrolled',
            'payment_status' => $validated['payment_status'] ?? 'pending',
            'payment_method' => $validated['payment_method'],
        ]);

        return redirect()->route('apprentice.show')->with('success', 'Apprentice added successfully.');
    }

    public function update(Apprentice $apprentice, Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|string|max:100|exists:users,unique_id',
            'training_id' => 'required|exists:trainings,id',
            'payment_status' => 'nullable|string|in:completed,pending',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);

        $user = User::where('unique_id', $validated['user_id'])->first();

        $training = Training::find($validated['training_id']);

        $apprentice->update([
            'user_id' => $user?->unique_id,
            'class_id' => $training->id,
            'status' => 'enrolled',
            'payment_status' => $validated['payment_status'] ?? 'pending',
            'payment_method' => $validated['payment_method'],
        ]);

        return redirect()->route('apprentice.show')->with('success', 'Apprentice updated successfully.');
    }

    public function destroy(Apprentice $apprentice)
    {
        $apprentice->delete();

        return redirect()->route('apprentice.show')->with('success', 'Apprentice Deleted Successfully');
    }
}
