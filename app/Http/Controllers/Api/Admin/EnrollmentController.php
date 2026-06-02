<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
        ]);
        $enrollment = Enrollment::firstOrCreate(
            ['student_id' => $request->student_id, 'class_id' => $request->class_id],
            ['enrolled_at' => now(), 'status' => 'active']
        );
        $enrollment->load('student.user', 'classModel');
        return response()->json($enrollment, 201);
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'completed', 'left_at' => now()]);
        return response()->json($enrollment);
    }
}
