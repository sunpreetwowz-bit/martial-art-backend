<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $classes = ClassModel::with('dojo', 'instructor.user')->where('is_active', true)->latest()->paginate(15);
        return response()->json($classes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dojo_id' => 'nullable|exists:dojos,id',
            'instructor_id' => 'nullable|exists:instructors,id',
            'description' => 'nullable|string',
            'schedule' => 'nullable|string',
            'max_students' => 'nullable|integer',
            'level' => 'nullable|string',
        ]);

        $class = ClassModel::create($request->all());
        $class->load('dojo', 'instructor.user');
        return response()->json($class, 201);
    }

    public function show(ClassModel $class)
    {
        $class->load('dojo', 'instructor.user', 'enrollments.student.user');
        return response()->json($class);
    }

    public function update(Request $request, ClassModel $class)
    {
        $class->update($request->all());
        $class->load('dojo', 'instructor.user');
        return response()->json($class);
    }

    public function destroy(ClassModel $class)
    {
        $class->update(['is_active' => false]);
        return response()->json($class);
    }
}
