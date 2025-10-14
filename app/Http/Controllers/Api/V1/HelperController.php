<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{

    // get all Data by userid
    public function index()
    {
        $Helpers = Helper::all();
        return response()->json([
            'success' => true,
            'data' => $Helpers
        ]);
    }

    // save all data
    public function store(Request $request)
    {


        $Helper = Helper::create($request->all() + ['user_id' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'Helper created successfully',
            'data' => $Helper
        ], 201);
    }

    // single data read
    public function show($id)
    {
        $Helper = Helper::find($id);
        if (!$Helper) {
            return response()->json(['success' => false, 'message' => 'Helper not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $Helper]);
    }


    // data update
    public function update(Request $request, $id)
    {
        $Helper = Helper::find($id);
        if (!$Helper) {
            return response()->json(['success' => false, 'message' => 'Helper not found'], 404);
        }

        $Helper->update($request->all());
        return response()->json(['success' => true, 'message' => 'Helper updated successfully', 'data' => $Helper]);
    }


    // delete record
    public function destroy($id)
    {
        $Helper = Helper::find($id);
        if (!$Helper) {
            return response()->json(['success' => false, 'message' => 'Helper not found'], 404);
        }

        $Helper->delete();
        return response()->json(['success' => true, 'message' => 'Helper deleted successfully']);
    }
}
