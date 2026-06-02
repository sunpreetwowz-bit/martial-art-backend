<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeltLevel;
use Illuminate\Http\Request;

class BeltLevelController extends Controller
{
    public function index()
    {
        return response()->json(BeltLevel::orderBy('order')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'color' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);
        return response()->json(BeltLevel::create($request->all()), 201);
    }

    public function update(Request $request, BeltLevel $beltLevel)
    {
        $beltLevel->update($request->all());
        return response()->json($beltLevel);
    }

    public function destroy(BeltLevel $beltLevel)
    {
        $beltLevel->delete();
        return response()->json(null, 204);
    }
}
