<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dojo;
use Illuminate\Http\Request;

class DojoController extends Controller
{
    public function index()
    {
        return response()->json(Dojo::withCount('students', 'classes')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        return response()->json(Dojo::create($request->all()), 201);
    }

    public function update(Request $request, Dojo $dojo)
    {
        $dojo->update($request->all());
        return response()->json($dojo);
    }

    public function destroy(Dojo $dojo)
    {
        $dojo->delete();
        return response()->json(null, 204);
    }
}
