<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $student = $user->student;
        if (!$student) {
            return response()->json(['message' => 'Student profile not found'], 404);
        }

        $student->load('beltLevel', 'dojo', 'enrollments.classModel.instructor.user');
        $recentAttendance = Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->orderByDesc('date')
            ->limit(10)
            ->get();

        return response()->json([
            'student' => $student,
            'recent_attendance' => $recentAttendance,
        ]);
    }

    public function myClasses(Request $request)
    {
        $student = $request->user()->student;
        if (!$student) return response()->json([], 200);
        $student->load('enrollments.classModel.instructor.user', 'enrollments.classModel.dojo');
        $enrollments = $student->enrollments()->where('status', 'active')->with('classModel.instructor.user', 'classModel.dojo')->get();
        return response()->json($enrollments);
    }

    public function myAttendance(Request $request)
    {
        $student = $request->user()->student;
        if (!$student) return response()->json([]);
        $attendances = Attendance::where('student_id', $student->id)
            ->with('classModel')
            ->orderByDesc('date')
            ->paginate(20);
        return response()->json($attendances);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string',
        ]);
        $user->update($request->only(['name', 'phone']));
        $user->load('student.beltLevel', 'student.dojo');
        return response()->json($user);
    }
}
