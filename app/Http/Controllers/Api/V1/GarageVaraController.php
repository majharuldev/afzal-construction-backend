<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\GarageVara;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GarageVaraController extends Controller
{
    
    // get all Data by userid
    public function index()
    {
        $GarageVaras = GarageVara::all();
        return response()->json([
            'success' => true,
            'data' => $GarageVaras
        ]);
    }

    // save all data
    public function store(Request $request)
    {


        $GarageVara = GarageVara::create($request->all() + ['user_id' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'GarageVara created successfully',
            'data' => $GarageVara
        ], 201);
    }

    // single data read
    public function show($id)
    {
        $GarageVara = GarageVara::find($id);
        if (!$GarageVara) {
            return response()->json(['success' => false, 'message' => 'GarageVara not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $GarageVara]);
    }


    // data update
    public function update(Request $request, $id)
    {
        $GarageVara = GarageVara::find($id);
        if (!$GarageVara) {
            return response()->json(['success' => false, 'message' => 'GarageVara not found'], 404);
        }

        $GarageVara->update($request->all());
        return response()->json(['success' => true, 'message' => 'GarageVara updated successfully', 'data' => $GarageVara]);
    }


    // delete record
    public function destroy($id)
    {
        $GarageVara = GarageVara::find($id);
        if (!$GarageVara) {
            return response()->json(['success' => false, 'message' => 'GarageVara not found'], 404);
        }

        $GarageVara->delete();
        return response()->json(['success' => true, 'message' => 'GarageVara deleted successfully']);
    }
}
