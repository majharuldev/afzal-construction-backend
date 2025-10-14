<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\SalaryAdvanced;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SalaryAdvController extends Controller
{
    public function index()
    {
        $data = SalaryAdvanced::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {

        $salary = SalaryAdvanced::create($request->all() + ['user_id' => Auth::id()]);
        return response()->json([
            'status' => 'Success',
            'data' => $salary
        ], 200);
    }

    public function show($id)
    {
        $data = SalaryAdvanced::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = SalaryAdvanced::find($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $data = SalaryAdvanced::findOrFail($id)->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
