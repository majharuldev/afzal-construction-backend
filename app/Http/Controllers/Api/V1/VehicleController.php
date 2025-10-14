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
            $vehicle = Vehicle::create([
                'user_id'          => Auth::id(),
                'date'             => $request->date,
                'driver_name'      => $request->driver_name,
                'vehicle_name'     => $request->vehicle_name,
                'insurance_date'   => $request->insurance_date ?? null,
                'vehicle_size'     => $request->vehicle_size,
                'vehicle_category' => $request->vehicle_category,
                'reg_zone'         => $request->reg_zone,
                'reg_serial'       => $request->reg_serial,
                'reg_no'           => $request->reg_no,
                'reg_date'         => $request->reg_date,
                'status'           => $request->status,
                'tax_date'         => $request->tax_date,
                'route_per_date'   => $request->route_per_date,
                'fitness_date'     => $request->fitness_date,
                'fuel_capcity'     => $request->fuel_capcity,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle created successfully',
                'data' => $vehicle
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
        try {
            // যেটা আপডেট করতে হবে সেই Vehicle বের করো
            $vehicle = Vehicle::findOrFail($id);

            // আপডেট করো
            $vehicle->update([
                'user_id'          => Auth::id(), // চাইলে user_id ফিক্সড করে দিতে পারেন
                'date'             => $request->date,
                'driver_name'      => $request->driver_name,
                'vehicle_name'     => $request->vehicle_name,
                'insurance_date'   => $request->insurance_date ?? null,
                'vehicle_size'     => $request->vehicle_size,
                'vehicle_category' => $request->vehicle_category,
                'reg_zone'         => $request->reg_zone,
                'reg_serial'       => $request->reg_serial,
                'reg_no'           => $request->reg_no,
                'reg_date'         => $request->reg_date,
                'status'           => $request->status,
                'tax_date'         => $request->tax_date,
                'route_per_date'   => $request->route_per_date,
                'fitness_date'     => $request->fitness_date,
                'fuel_capcity'     => $request->fuel_capcity,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle updated successfully',
                'data'    => $vehicle
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error',
                'error'   => $e->getMessage()
            ], 500);
        }
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
