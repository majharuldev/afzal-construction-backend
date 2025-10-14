<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\PriceRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PriceRateController extends Controller
{
    // get all Data by userid
    public function index()
    {
        $PriceRates = PriceRate::latest()->get();
        return response()->json([
            'success' => true,
            'data' => $PriceRates
        ]);
    }

    // save all data
    public function store(Request $request)
    {


        $PriceRate = PriceRate::create($request->all() + ['user_id' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'PriceRate created successfully',
            'data' => $PriceRate
        ], 201);
    }

    // single data read
    public function show($id)
    {
        $PriceRate = PriceRate::find($id);
        if (!$PriceRate) {
            return response()->json(['success' => false, 'message' => 'PriceRate not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $PriceRate]);
    }


    // data update
    public function update(Request $request, $id)
    {
        $PriceRate = PriceRate::find($id);
        if (!$PriceRate) {
            return response()->json(['success' => false, 'message' => 'PriceRate not found'], 404);
        }

        $PriceRate->update($request->all());
        return response()->json(['success' => true, 'message' => 'PriceRate updated successfully', 'data' => $PriceRate]);
    }


    // delete record
    public function destroy($id)
    {
        $PriceRate = PriceRate::where('user_id', Auth::id())->find($id);
        if (!$PriceRate) {
            return response()->json(['success' => false, 'message' => 'PriceRate not found'], 404);
        }

        $PriceRate->delete();
        return response()->json(['success' => true, 'message' => 'PriceRate deleted successfully']);
    }
}
