<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Attendence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendenceController extends Controller
{
    public function index()
    {
        $data = Attendence::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $data = Attendence::create([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'working_day' => $request->working_day,
            'month' => $request->month,
            'created_by' =>$request->created_by  ,  // Authenticated user ID
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }


    public function show($id)
    {
        $data = Attendence::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = Attendence::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $data = Attendence::findOrFail($id)->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
