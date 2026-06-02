<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\StudentController;
use App\Http\Controllers\Api\Admin\ClassController;
use App\Http\Controllers\Api\Admin\DojoController;
use App\Http\Controllers\Api\Admin\BeltLevelController;
use App\Http\Controllers\Api\Admin\InstructorController;
use App\Http\Controllers\Api\Admin\EnrollmentController;
use App\Http\Controllers\Api\Student\StudentPortalController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);

    Route::prefix('student')->middleware('auth:sanctum')->group(function () {
        Route::get('/dashboard', [StudentPortalController::class, 'dashboard']);
        Route::get('/my-classes', [StudentPortalController::class, 'myClasses']);
        Route::get('/my-attendance', [StudentPortalController::class, 'myAttendance']);
        Route::put('/profile', [StudentPortalController::class, 'updateProfile']);
    });

    Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::apiResource('students', StudentController::class);
        Route::apiResource('classes', ClassController::class);
        Route::get('dojos', [DojoController::class, 'index']);
        Route::post('dojos', [DojoController::class, 'store']);
        Route::put('dojos/{dojo}', [DojoController::class, 'update']);
        Route::delete('dojos/{dojo}', [DojoController::class, 'destroy']);
        Route::get('belt-levels', [BeltLevelController::class, 'index']);
        Route::post('belt-levels', [BeltLevelController::class, 'store']);
        Route::put('belt-levels/{beltLevel}', [BeltLevelController::class, 'update']);
        Route::delete('belt-levels/{beltLevel}', [BeltLevelController::class, 'destroy']);
        Route::get('instructors', [InstructorController::class, 'index']);
        Route::post('instructors', [InstructorController::class, 'store']);
        Route::put('instructors/{instructor}', [InstructorController::class, 'update']);
        Route::post('enrollments', [EnrollmentController::class, 'store']);
        Route::delete('enrollments/{enrollment}', [EnrollmentController::class, 'destroy']);
    });
});
