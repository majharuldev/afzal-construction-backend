<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Parts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartsController extends Controller
{
    public function index()
    {
        $parts = Parts::all();
        return response()->json($parts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'parts_name' => 'required|string|max:255',
            'validity' => 'nullable|date'
        ]);

        $parts = Parts::create([
            'user_id' => Auth::id(),
            'parts_name' => $request->parts_name,
            'validity' => $request->validity,
        ]);

        return response()->json([
            'message' => 'Parts created successfully',
            'data' => $parts
        ], 201);
    }

    public function show($id)
    {
        $parts = Parts::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json($parts);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'parts_name' => 'required|string|max:255',
            'validity' => 'nullable|date'
        ]);

        $parts = Parts::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $parts->update($request->only(['parts_name', 'validity']));

        return response()->json([
            'message' => 'Parts updated successfully',
            'data' => $parts
        ]);
    }

    public function destroy($id)
    {
        $parts = Parts::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $parts->delete();

        return response()->json(['message' => 'Parts deleted successfully']);
    }
}
