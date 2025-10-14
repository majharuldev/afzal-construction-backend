<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class SupplierController extends Controller
{
    // get all Data by userid
    public function index()
    {
        $Suppliers = Supplier::all();
        return response()->json([
            'success' => true,
            'data' => $Suppliers
        ]);
    }

    // save all data
    public function store(Request $request)
    {

        $Supplier = Supplier::create($request->all() + ['user_id' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'Supplier created successfully',
            'data' => $Supplier
        ], 201);
    }

    // single data read
    public function show($id)
    {
        $Supplier = Supplier::find($id);
        if (!$Supplier) {
            return response()->json(['success' => false, 'message' => 'Supplier not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $Supplier]);
    }


    // data update
    public function update(Request $request, $id)
    {
        $Supplier = Supplier::find($id);
        if (!$Supplier) {
            return response()->json(['success' => false, 'message' => 'Supplier not found'], 404);
        }

        $Supplier->update($request->all());
        return response()->json(['success' => true, 'message' => 'Supplier updated successfully', 'data' => $Supplier]);
    }


    // delete record
    public function destroy($id)
    {
        $Supplier = Supplier::find($id);
        if (!$Supplier) {
            return response()->json(['success' => false, 'message' => 'Supplier not found'], 404);
        }

        $Supplier->delete();
        return response()->json(['success' => true, 'message' => 'Supplier deleted successfully']);
    }
}
