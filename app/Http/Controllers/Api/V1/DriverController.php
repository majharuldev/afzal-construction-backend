<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return response()->json($drivers);
    }

    public function store(Request $request)
    {


        $driver = Driver::create([
            'user_id' => Auth::id(),
            'driver_name' => $request->driver_name,
            'driver_mobile' => $request->driver_mobile,
            'emergency_contact' => $request->emergency_contact,
            'opening_balance' => $request->opening_balance,
            'nid' => $request->nid,
            'address' => $request->address,
            'note' => $request->note,
            'lincense' => $request->lincense,
            'expire_date' => $request->expire_date,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Driver created successfully', 'data' => $driver]);
    }

    public function show($id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }
        return response()->json($driver);
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        // এখানে driver অবজেক্টের উপরই update চালাও
        $driver->update([
            'user_id'          => Auth::id(),
            'driver_name'      => $request->driver_name,
            'driver_mobile'    => $request->driver_mobile,
            'emergency_contact' => $request->emergency_contact,
            'opening_balance'  => $request->opening_balance,
            'nid'              => $request->nid,
            'address'          => $request->address,
            'note'             => $request->note,
            'lincense'         => $request->lincense, // এখানে কন্ডিশন দিলে আগেরটা থাকবে
            'expire_date'      => $request->expire_date,
            'status'           => $request->status,
        ]);

        return response()->json([
            'message' => 'Driver updated successfully',
            'data'    => $driver->fresh() // আপডেটেড ডেটা দেখাবে
        ]);
    }


    public function destroy($id)
    {
        $driver = Driver::where('user_id', Auth::id())->find($id);
        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $driver->delete();
        return response()->json(['message' => 'Driver deleted successfully']);
    }
}
