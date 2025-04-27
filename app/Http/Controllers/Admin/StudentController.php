<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassList;
use App\Models\Student;
use App\Models\User;
use Faker\Guesser\Name;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function show()
    {
        $students = Student::with(['classList', 'user'])
        ->whereRaw('LOWER(status) = ?', ['enrolled'])
        ->orderBy('created_at', 'DESC')
        ->paginate(10);
    
        return view('admin.students.students', compact('students'));
    }

    public function create()
    {
        $classLists = ClassList::all();

        return view('admin.students.createStudent', compact('classLists'));
    }

    public function edit(Student $student)
    {
        return view('admin.students.editStudent', ['student' => $student]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'user_id' => 'nullable|string|max:100',
            'class_id' => 'required|exists:class_lists,id',
            'payment_status' => 'nullable|string|in:completed,pending',
            'payment_method' => 'required|string|in:card,gcash,cash,other',
            'other_payment_method' => 'nullable|required_if:payment_method,other|string|max:100',
        ]);

        $user = User::where('unique_id', $validated['user_id'])->first();

        if (!$user) {
            $user = User::create([
                'first_name' => $validated['name'],
            ]);
        }

        $classList = ClassList::find($validated['class_id']);

        Student::create([
            'user_id' => $user->unique_id,
            'class_id' => $classList->id,
            'student_until' => $classList->class_end ?? null,
            'attended' => 1,
            'status' => \Carbon\Carbon::parse($classList->class_start)->isFuture() ? 'Enrolled' : 'Ongoing',
            'payment_status' => $validated['payment_status'] ?? 'pending',
            'payment_method' => $validated['payment_method'],
        ]);

        return redirect()->route('student.show')->with('success', 'Student added successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.show')->with('success', 'Student Deleted Successfully');
    }

}
