<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use App\Models\Maintaince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintainceController extends Controller
{
    public function index()
    {
        $logs = Maintaince::latest()->get();
        return response()->json($logs);
    }

    // Store new log
    public function store(Request $request)
    {
       

        $log = Maintaince::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'service_type' => $request->service_type,
            'parts' => $request->parts,
            'maintaince_type' => $request->maintaince_type,
            'vehicle_no' => $request->vehicle_no,
            'parts_price' => $request->parts_price,
            'service_charge' => $request->service_charge,
            'total_cost' => $request->total_cost,
            'priority' => $request->priority,
            'validity' => $request->validity,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Maintenance log created', 'data' => $log], 201);
    }

    // Optional: Show single log
    public function show($id)
    {
        $log = Maintaince::find($id);
        if (!$log) {
            return response()->json(['message' => 'Log not found'], 404);
        }
        return response()->json($log);
    }

    // Optional: Update
    public function update(Request $request, $id)
    {
        $log = Maintaince::find($id);
        if (!$log) {
            return response()->json(['message' => 'Log not found'], 404);
        }

        $log->update($request->all());

        return response()->json(['message' => 'Log updated successfully', 'data' => $log]);
    }

    // Optional: Delete
    public function destroy($id)
    {
        $log = Maintaince::where('user_id', Auth::id())->find($id);
        if (!$log) {
            return response()->json(['message' => 'Log not found'], 404);
        }

        $log->delete();

        return response()->json(['message' => 'Log deleted']);
    }
}
