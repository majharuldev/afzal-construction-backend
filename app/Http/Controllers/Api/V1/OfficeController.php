<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OfficeController extends Controller
{

    // get all Data by userid
    public function index()
    {
        $Offices = Office::all();
        return response()->json([
            'success' => true,
            'data' => $Offices
        ]);
    }

    // save all data
    public function store(Request $request)
    {

        $Office = Office::create($request->all() + ['user_id' => Auth::id()]);


        return response()->json([
            'success' => true,
            'message' => 'Office created successfully',
            'data' => $Office
        ], 201);
    }

    // single data read
    public function show($id)
    {
        $Office = Office::find($id);
        if (!$Office) {
            return response()->json(['success' => false, 'message' => 'Office not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $Office]);
    }


    // data update
    public function update(Request $request, $id)
    {
        $Office = Office::find($id);
        if (!$Office) {
            return response()->json(['success' => false, 'message' => 'Office not found'], 404);
        }

        $Office->update($request->all());
        return response()->json(['success' => true, 'message' => 'Office updated successfully', 'data' => $Office]);
    }


    // delete record
    public function destroy($id)
    {
        $Office = Office::find($id);
        if (!$Office) {
            return response()->json(['success' => false, 'message' => 'Office not found'], 404);
        }

        $Office->delete();
        return response()->json(['success' => true, 'message' => 'Office deleted successfully']);
    }
}
