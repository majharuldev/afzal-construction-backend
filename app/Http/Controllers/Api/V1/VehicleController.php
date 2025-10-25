<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }

    // Store a new vehicle
    public function store(Request $request)
    {
        try {


            $Vehicle = Vehicle::create($request->all() + ['user_id' => Auth::id()]);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle created successfully',
                'data' => $Vehicle
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Show single vehicle
    public function show($id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        return response()->json($vehicle);
    }

    // Update vehicle
    public function update(Request $request, $id)
    {
        $Vehicle = Vehicle::find($id);
        if (!$Vehicle) {
            return response()->json(['success' => false, 'message' => 'Vendor not found'], 404);
        }

        $Vehicle->update($request->all());
        return response()->json(['success' => true, 'message' => 'Vendor updated successfully', 'data' => $Vehicle]);
    }

    // Delete vehicle
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $vehicle->delete();

        return response()->json(['message' => 'Vehicle deleted successfully']);
    }
}
