<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('user', 'beltLevel', 'dojo', 'enrollments.classModel');
        if ($request->filled('search')) {
            $q = $request->search;
            $query->whereHas('user', function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }
        $students = $query->latest()->paginate(15);
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string',
            'dojo_id' => 'nullable|exists:dojos,id',
            'belt_level_id' => 'nullable|exists:belt_levels,id',
            'date_of_birth' => 'nullable|date',
            'join_date' => 'nullable|date',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student',
            'phone' => $request->phone,
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'dojo_id' => $request->dojo_id,
            'belt_level_id' => $request->belt_level_id,
            'date_of_birth' => $request->date_of_birth,
            'join_date' => $request->join_date ?? now(),
            'emergency_contact' => $request->emergency_contact,
            'notes' => $request->notes,
        ]);

        $student->load('user', 'beltLevel', 'dojo');
        return response()->json($student, 201);
    }

    public function show(Student $student)
    {
        $student->load('user', 'beltLevel', 'dojo', 'enrollments.classModel', 'attendances');
        return response()->json($student);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string',
            'dojo_id' => 'nullable|exists:dojos,id',
            'belt_level_id' => 'nullable|exists:belt_levels,id',
            'date_of_birth' => 'nullable|date',
            'join_date' => 'nullable|date',
        ]);

        $student->user->update($request->only(['name', 'email', 'phone']));
        $student->update($request->only(['dojo_id', 'belt_level_id', 'date_of_birth', 'join_date', 'emergency_contact', 'notes']));
        $student->load('user', 'beltLevel', 'dojo');
        return response()->json($student);
    }

    public function destroy(Student $student)
    {
        $student->user->delete();
        return response()->json(null, 204);
    }
}
