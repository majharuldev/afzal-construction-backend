<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Bonous;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BonousController extends Controller
{
    public function index()
    {
        $data = Bonous::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {

        $salary = Bonous::create($request->all() + ['user_id' => Auth::id()]);
        return response()->json([
            'status' => 'Success',
            'data' => $salary
        ], 200);
    }

    public function show($id)
    {
        $data = Bonous::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = Bonous::find($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $data = Bonous::findOrFail($id)->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
