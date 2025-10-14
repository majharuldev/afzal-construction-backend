<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $data = loan::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {

        $salary = loan::create($request->all() + ['user_id' => Auth::id()]);
        return response()->json([
            'status' => 'Success',
            'data' => $salary
        ], 200);
    }

    public function show($id)
    {
        $data = loan::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = loan::find($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $data = loan::findOrFail($id)->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
