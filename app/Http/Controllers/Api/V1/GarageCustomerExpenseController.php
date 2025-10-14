<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\GarageExpense;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GarageCustomerExpenseController extends Controller
{
    public function index()
    {
        $GarageExpenses = GarageExpense::all();
        return response()->json([
            'success' => true,
            'data' => $GarageExpenses
        ]);
    }

    // save all data
    public function store(Request $request)
    {


        $GarageExpense = GarageExpense::create($request->all() + ['user_id' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'GarageExpense created successfully',
            'data' => $GarageExpense
        ], 201);
    }

    // single data read
    public function show($id)
    {
        $GarageExpense = GarageExpense::find($id);
        if (!$GarageExpense) {
            return response()->json(['success' => false, 'message' => 'GarageExpense not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $GarageExpense]);
    }


    // data update
    public function update(Request $request, $id)
    {
        $GarageExpense = GarageExpense::find($id);
        if (!$GarageExpense) {
            return response()->json(['success' => false, 'message' => 'GarageExpense not found'], 404);
        }

        $GarageExpense->update($request->all());
        return response()->json(['success' => true, 'message' => 'GarageExpense updated successfully', 'data' => $GarageExpense]);
    }


    // delete record
    public function destroy($id)
    {
        $GarageExpense = GarageExpense::find($id);
        if (!$GarageExpense) {
            return response()->json(['success' => false, 'message' => 'GarageExpense not found'], 404);
        }

        $GarageExpense->delete();
        return response()->json(['success' => true, 'message' => 'GarageExpense deleted successfully']);
    }
}
