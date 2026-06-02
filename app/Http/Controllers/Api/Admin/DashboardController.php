<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Dojo;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_classes' => ClassModel::where('is_active', true)->count(),
            'total_dojos' => Dojo::count(),
            'attendance_today' => Attendance::whereDate('date', today())->where('status', 'present')->count(),
        ];
        return response()->json($stats);
    }
}
