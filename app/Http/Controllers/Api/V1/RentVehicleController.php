<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\RentVehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RentVehicleController extends Controller
{
    
    // get all Data by userid
    public function index()
    {
        $RentVehicles = RentVehicle::all();
        return response()->json([
            'success' => true,
            'data' => $RentVehicles
        ]);
    }

    // save all data
    public function store(Request $request)
    {


        $RentVehicle = RentVehicle::create($request->all() + ['user_id' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'RentVehicle created successfully',
            'data' => $RentVehicle
        ], 201);
    }

    // single data read
    public function show($id)
    {
        $RentVehicle = RentVehicle::find($id);
        if (!$RentVehicle) {
            return response()->json(['success' => false, 'message' => 'RentVehicle not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $RentVehicle]);
    }


    // data update
    public function update(Request $request, $id)
    {
        $RentVehicle = RentVehicle::find($id);
        if (!$RentVehicle) {
            return response()->json(['success' => false, 'message' => 'RentVehicle not found'], 404);
        }

        $RentVehicle->update($request->all());
        return response()->json(['success' => true, 'message' => 'RentVehicle updated successfully', 'data' => $RentVehicle]);
    }


    // delete record
    public function destroy($id)
    {
        $RentVehicle = RentVehicle::where('user_id', Auth::id())->find($id);
        if (!$RentVehicle) {
            return response()->json(['success' => false, 'message' => 'RentVehicle not found'], 404);
        }

        $RentVehicle->delete();
        return response()->json(['success' => true, 'message' => 'RentVehicle deleted successfully']);
    }
}
