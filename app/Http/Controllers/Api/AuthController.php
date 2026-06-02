<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::with(['student', 'instructor'])->where('email', $request->email)->firstOrFail();

        $user->load('student.beltLevel', 'student.dojo');
        if ($user->instructor) {
            $user->load('instructor.dojo');
        }

        return response()->json([
            'token' => $user->createToken('auth')->plainTextToken,
            'user' => $user,
            'student' => $user->student,
            'instructor' => $user->instructor,
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,instructor',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'join_date' => now(),
            ]);
        }

        if ($request->role === 'instructor') {
            Instructor::create(['user_id' => $user->id]);
        }

        $user->load('student', 'instructor');
        return response()->json([
            'token' => $user->createToken('auth')->plainTextToken,
            'user' => $user,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $user->load('student.beltLevel', 'student.dojo', 'student.enrollments.classModel', 'instructor.dojo', 'instructor.classes');
        return response()->json($user);
    }
}
