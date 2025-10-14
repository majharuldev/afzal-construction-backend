<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\GarageCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GarageCustomerController extends Controller
{



    // get all Data by userid
    public function index()
    {
        $GarageCustomers = GarageCustomer::all();
        return response()->json([
            'success' => true,
            'data' => $GarageCustomers
        ]);
    }

    // save all data
    public function store(Request $request)
    {


        $GarageCustomer = GarageCustomer::create($request->all() + ['user_id' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'GarageCustomer created successfully',
            'data' => $GarageCustomer
        ], 201);
    }

    // single data read
    public function show($id)
    {
        $GarageCustomer = GarageCustomer::find($id);
        if (!$GarageCustomer) {
            return response()->json(['success' => false, 'message' => 'GarageCustomer not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $GarageCustomer]);
    }


    // data update
    public function update(Request $request, $id)
    {
        $GarageCustomer = GarageCustomer::find($id);
        if (!$GarageCustomer) {
            return response()->json(['success' => false, 'message' => 'GarageCustomer not found'], 404);
        }

        $GarageCustomer->update($request->all());
        return response()->json(['success' => true, 'message' => 'GarageCustomer updated successfully', 'data' => $GarageCustomer]);
    }


    // delete record
    public function destroy($id)
    {
        $GarageCustomer = GarageCustomer::find($id);
        if (!$GarageCustomer) {
            return response()->json(['success' => false, 'message' => 'GarageCustomer not found'], 404);
        }

        $GarageCustomer->delete();
        return response()->json(['success' => true, 'message' => 'GarageCustomer deleted successfully']);
    }
}
