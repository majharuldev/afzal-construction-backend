<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Fuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FuelController extends Controller
{
    public function index()
    {
        $fuels = Fuel::where('user_id', Auth::id())->latest()->get();
        return response()->json($fuels);
    }

    // Store new fuel record
    public function store(Request $request)
    {
        

        $fuel = Fuel::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'vehicle_no' => $request->vehicle_no,
            'unit_price' => $request->unit_price,
            'fuel_type' => $request->fuel_type,
            'total_cost' => $request->total_cost,
            'pump_name' => $request->pump_name,
        ]);

        return response()->json(['message' => 'Fuel record added successfully', 'data' => $fuel], 201);
    }

    // Optional: View single fuel record
    public function show($id)
    {
        $fuel = Fuel::find($id);
        if (!$fuel) {
            return response()->json(['message' => 'Fuel record not found'], 404);
        }
        return response()->json($fuel);
    }

    // Optional: Update fuel record
    public function update(Request $request, $id)
    {
        $fuel = Fuel::find($id);
        if (!$fuel) {
            return response()->json(['message' => 'Fuel record not found'], 404);
        }

        $fuel->update($request->all());

        return response()->json(['message' => 'Fuel record updated successfully', 'data' => $fuel]);
    }

    // Optional: Delete
    public function destroy($id)
    {
        $fuel = Fuel::find($id);
        if (!$fuel) {
            return response()->json(['message' => 'Fuel record not found'], 404);
        }

        $fuel->delete();

        return response()->json(['message' => 'Fuel record deleted successfully']);
    }
}
