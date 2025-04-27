<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Apprentice;
use App\Models\ClassList;
use App\Models\Equipment;
use App\Models\Notification;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPageController extends Controller
{
    public function settings()
    {
        return view('user.settings');
    }

    public function equipments()
    {
        $equipments = Equipment::all();
        return view('user.equipments', compact('equipments'));
    }

    public function transactions()
    {
        $user = Auth::user();

        $transactions = Transaction::with('rate')
            ->where('user_id', $user->unique_id)->get();

        return view('user.transactions', compact('transactions'));
    }

    public function class()
    {
        $user = Auth::user();

        $students = Student::where('user_id', $user->unique_id)
        ->whereRaw('LOWER(status) != ?', ['completed'])
        ->whereRaw('LOWER(payment_status) = ?', ['completed'])
        ->get();

        $class_lists = ClassList::with('instructor')
            ->whereDate('class_end', '>', now())
            ->get();
    
        return view('user.classes', compact('students', 'class_lists'));
    }

    public function availClass(Request $request)
    {
        $validated = $request->validate([
            'class' => 'required|exists:class_lists,id',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);

        $user = Auth::user();

        $classList = ClassList::find($validated['class']);

        Student::create([
            'user_id' => $user->unique_id,
            'class_id' => $classList->id,
            'status' => 'Unconfirmed Enrollment',
            'payment_method' => $validated['payment_method'],
        ]);

        Transaction::create([
            'user_id' => $user->unique_id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'payment_method' => $validated['payment_method'] === 'other' ? $validated['other_payment_method'] : $validated['payment_method'],
            'transaction_type' => 'class_enroll',
            'payment_code' => $classList->id,
            'amount' => $classList->price,
            'status' => 'Pending',
            'remarks' => $classList->name . ' Class',
        ]);

        Notification::create([
            'user_id' => $user->unique_id,
            'user_name' => $user->first_name . ' ' . $user->last_name,
            'user_email' => $user->email,
            'user_contact' => $user->phone,
            'title' => 'New Enrollment ' . 'Request',
            'message' => 'A new enrollment request has been sent by ' . $user->first_name . ' ' . $user->last_name . ' for ' . $classList->name . ' class.',
            'category' => 'Classes',
            'submitted_at' => now(),
        ]);

        return redirect()->route('user.class')->with('success', 'Student request submitted successfully.');
    }

     public function training()
     {
         $user = Auth::user();
 
         $apprentices = Apprentice::where('user_id', $user->unique_id)
         ->whereRaw('LOWER(status) != ?', ['completed'])
         ->whereRaw('LOWER(payment_status) = ?', ['completed'])
         ->get();
 
         $trainings = Training::with('instructor')->get();
     
         return view('user.training', compact('apprentices', 'trainings'));
     }

    public function availTraining(Request $request)
    {
        $validated = $request->validate([
            'training' => 'required|exists:trainings,id',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);

        $user = Auth::user();

        $training = Training::find($validated['training']);

        Apprentice::create([
            'user_id' => $user->unique_id,
            'training_id' => $training->id,
            'status' => 'Unconfirmed Enrollment',
            'payment_method' => $validated['payment_method'],
        ]);

        Transaction::create([
            'user_id' => $user->unique_id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'payment_method' => $validated['payment_method'] === 'other' ? $validated['other_payment_method'] : $validated['payment_method'],
            'transaction_type' => 'training_enroll',
            'payment_code' => $training->id,
            'amount' => $training->price,
            'status' => 'Pending',
            'remarks' => $training->name,
        ]);

        Notification::create([
            'user_id' => $user->unique_id,
            'user_name' => $user->first_name . ' ' . $user->last_name,
            'user_email' => $user->email,
            'user_contact' => $user->phone,
            'title' => 'New Apprentice ' . 'Request',
            'message' => 'A new apprentice request has been sent by ' . $user->first_name . ' ' . $user->last_name . ' for ' . $training->name,
            'category' => 'Training',
            'submitted_at' => now(),
        ]);

        return redirect()->route('user.training')->with('success', 'Apprentice request submitted successfully.');
    }
}
