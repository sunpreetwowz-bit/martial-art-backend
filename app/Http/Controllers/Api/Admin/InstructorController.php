<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        return response()->json(Instructor::with('user', 'dojo')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'dojo_id' => 'nullable|exists:dojos,id',
            'title' => 'nullable|string',
            'specialization' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'instructor',
        ]);
        $instructor = Instructor::create([
            'user_id' => $user->id,
            'dojo_id' => $request->dojo_id,
            'title' => $request->title,
            'specialization' => $request->specialization,
            'bio' => $request->bio,
        ]);
        $instructor->load('user', 'dojo');
        return response()->json($instructor, 201);
    }

    public function update(Request $request, Instructor $instructor)
    {
        $instructor->user->update($request->only(['name', 'email']));
        $instructor->update($request->only(['dojo_id', 'title', 'specialization', 'bio']));
        $instructor->load('user', 'dojo');
        return response()->json($instructor);
    }
}
