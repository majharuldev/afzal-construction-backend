<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
  // get all Data by userid
    public function index()
    {
        $Vendors = Vendor::all();
        return response()->json([
            'success' => true,
            'data' => $Vendors
        ]);
    }

    // save all data
    public function store(Request $request)
    {


        $Vendor = Vendor::create($request->all() + ['user_id' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'Vendor created successfully',
            'data' => $Vendor
        ], 201);
    }

    // single data read
    public function show($id)
    {
        $Vendor = Vendor::where('user_id', Auth::id())->find($id);
        if (!$Vendor) {
            return response()->json(['success' => false, 'message' => 'Vendor not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $Vendor]);
    }


    // data update
    public function update(Request $request, $id)
    {
        $Vendor = Vendor::find($id);
        if (!$Vendor) {
            return response()->json(['success' => false, 'message' => 'Vendor not found'], 404);
        }

        $Vendor->update($request->all());
        return response()->json(['success' => true, 'message' => 'Vendor updated successfully', 'data' => $Vendor]);
    }


    // delete record
    public function destroy($id)
    {
        $Vendor = Vendor::find($id);
        if (!$Vendor) {
            return response()->json(['success' => false, 'message' => 'Vendor not found'], 404);
        }

        $Vendor->delete();
        return response()->json(['success' => true, 'message' => 'Vendor deleted successfully']);
    }
}
