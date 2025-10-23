<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\trip;
use App\Models\DriverLedger;
use App\Models\OfficeLedger;
use App\Models\VendorLedger;
use Illuminate\Http\Request;
use App\Models\CustomerLedger;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{


    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'super') {
            $trips = Trip::latest()->get();
        } else {
            $trips = Trip::where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return response()->json($trips);
    }



    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Insert into trips table
            $trip = Trip::create([
                'user_id'          => Auth::id(),
                'customer'         => $request->customer,
                'date'       => $request->date,
                'branch_name'      => $request->branch_name,
                'load_point'       => $request->load_point,
                'additional_load'  => $request->additional_load,
                'unload_point'     => $request->unload_point,
                'transport_type'   => $request->transport_type,
                'trip_type'        => $request->trip_type,
                'trip_id'          => $request->trip_id,
                'sms_sent'         => $request->sms_sent,
                'vehicle_no'       => $request->vehicle_no,
                'driver_name'      => $request->driver_name,
                'vehicle_category' => $request->vehicle_category,
                'vehicle_size'     => $request->vehicle_size,
                'product_details'  => $request->product_details,
                'driver_mobile'    => $request->driver_mobile,
                'challan'          => $request->challan,
                'driver_adv'       => $request->driver_adv,
                'remarks'          => $request->remarks,
                'food_cost'        => $request->food_cost,
                'total_exp'        => $request->total_exp,
                'total_rent'        => $request->total_rent,
                'vendor_rent'      => $request->vendor_rent,
                'advance'          => $request->advance,
                'due_amount'       => $request->due_amount,
                'parking_cost'     => $request->parking_cost,
                'night_guard'      => $request->night_guard,
                'toll_cost'        => $request->toll_cost,
                'feri_cost'        => $request->feri_cost,
                'fuel_cost'        => $request->fuel_cost,
                'police_cost'      => $request->police_cost,
                'chada'            => $request->chada,
                'labor'            => $request->labor,
                'challan_cost'     => $request->challan_cost,
                'others_cost'      => $request->others_cost,
                'vendor_name'      => $request->vendor_name,
                'additional_cost'  => $request->additional_cost,
                'd_day'  => $request->d_day,
                'd_amount'  => $request->d_amount,
                'd_total'  => $request->d_total,
                'status'           => $request->status,
            ]);

            // Insert into driver or vendor ledger based on transport type
            if ($request->transport_type === "own_transport") {
                DriverLedger::create([
                    'user_id'          => Auth::id(),
                    'date'             => $request->date,
                    'driver_name'      => $request->driver_name,
                    'trip_id'          => $trip->id,
                    'load_point'       => $request->load_point,
                    'unload_point'     => $request->unload_point,
                    'driver_commission' => $request->driver_commission,
                    'driver_adv'       => $request->driver_adv,
                    'parking_cost'     => $request->parking_cost,
                    'night_guard'      => $request->night_guard,
                    'toll_cost'        => $request->toll_cost,
                    'feri_cost'        => $request->feri_cost,
                    'police_cost'      => $request->police_cost,
                    'fuel_cost'      => $request->fuel_cost,
                    'food_cost'      => $request->food_cost,
                    'challan_cost'      => $request->challan_cost,
                    'chada'            => $request->chada,
                    'others_cost'      => $request->others_cost,
                    'labor'            => $request->labor,
                    'total_exp'        => $request->total_exp,
                ]);
            } else {
                VendorLedger::create([
                    'user_id'     => Auth::id(),
                    'date'        => $request->date,
                    'driver_name' => $request->driver_name,
                    'trip_id'     => $trip->id,
                    'load_point'  => $request->load_point,
                    'unload_point' => $request->unload_point,
                    'customer'    => $request->customer,
                    'vendor_name' => $request->vendor_name,
                    'vehicle_no'  => $request->vehicle_no,
                    'total_rent'   => $request->total_rent,   // fixed
                    'advance'     => $request->advance,
                    'due_amount'  => $request->due_amount,
                ]);
            }

            // Insert into branch ledgers
            OfficeLedger::create([
                'user_id'     => Auth::id(),
                'date'        => $request->date,
                'unload_point' => $request->unload_point,
                'load_point'  => $request->load_point,
                'customer'    => $request->customer,
                'trip_id'     => $trip->id,
                'branch_name' => $request->branch_name,
                'status'      => "Pending", // fixed
                'cash_out'    => $request->total_exp,
                'created_by'  => Auth::id(),
            ]);

            CustomerLedger::create([
                'user_id'          => Auth::id(),
                'working_date'  => $request->date,  // fixed spelling
                'customer_name' => $request->customer,
                'trip_id'       => $trip->id,
                'chalan'       => $request->challan,
                'load_point'    => $request->load_point,
                'unload_point'  => $request->unload_point,
                'vehicle_no'    => $request->vehicle_no,
                'bill_amount'   => $request->total_rent, // fixed
                'driver_name'   => $request->driver_name,
                'd_day'  => $request->d_day,
                'd_amount'  => $request->d_amount,
                'd_total'  => $request->d_total,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Trip created successfully',
                'data'    => $trip,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }



    public function show($id)
    {
        $trip = trip::find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }
        return response()->json($trip);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Find existing trip
            $trip = Trip::findOrFail($id);

            // Update trip table
            $trip->update([
                'customer'         => $request->customer,
                'date'       => $request->date,
                'branch_name'      => $request->branch_name,
                'load_point'       => $request->load_point,
                'additional_load'  => $request->additional_load,
                'unload_point'     => $request->unload_point,
                'transport_type'   => $request->transport_type,
                'trip_type'        => $request->trip_type,
                'trip_id'          => $request->trip_id,
                'sms_sent'         => $request->sms_sent,
                'vehicle_no'       => $request->vehicle_no,
                'driver_name'      => $request->driver_name,
                'vehicle_category' => $request->vehicle_category,
                'vehicle_size'     => $request->vehicle_size,
                'product_details'  => $request->product_details,
                'driver_mobile'    => $request->driver_mobile,
                'challan'          => $request->challan,
                'driver_adv'       => $request->driver_adv,
                'remarks'          => $request->remarks,
                'food_cost'        => $request->food_cost,
                'total_exp'        => $request->total_exp,
                'total_rent'        => $request->total_rent,
                'vendor_rent'      => $request->vendor_rent,
                'advance'          => $request->advance,
                'due_amount'       => $request->due_amount,
                'parking_cost'     => $request->parking_cost,
                'night_guard'      => $request->night_guard,
                'toll_cost'        => $request->toll_cost,
                'feri_cost'        => $request->feri_cost,
                'police_cost'      => $request->police_cost,
                'chada'            => $request->chada,
                'labor'            => $request->labor,
                'challan_cost'     => $request->challan_cost,
                'others_cost'      => $request->others_cost,
                'vendor_name'      => $request->vendor_name,
                'additional_cost'  => $request->additional_cost,
                'status'           => $request->status,
            ]);

            // Update DriverLedger or VendorLedger
            if ($request->transport_type === "own_transport") {
                DriverLedger::updateOrCreate(
                    ['trip_id' => $trip->id], // condition
                    [
                        'user_id'          => Auth::id(),
                        'date'             => $request->start_date,
                        'driver_name'      => $request->driver_name,
                        'load_point'       => $request->load_point,
                        'unload_point'     => $request->unload_point,
                        'driver_commission' => $request->driver_commission,
                        'driver_adv'       => $request->driver_adv,
                        'parking_cost'     => $request->parking_cost,
                        'night_guard'      => $request->night_guard,
                        'toll_cost'        => $request->toll_cost,
                        'feri_cost'        => $request->feri_cost,
                        'police_cost'      => $request->police_cost,
                        'fuel_cost'      => $request->fuel_cost,
                        'food_cost'      => $request->food_cost,
                        'challan_cost'      => $request->challan_cost,
                        'chada'            => $request->chada,
                        'others_cost'      => $request->others_cost,
                        'labor'            => $request->labor,
                        'total_exp'        => $request->total_exp,
                    ]
                );
            } else {
                VendorLedger::updateOrCreate(
                    ['trip_id' => $trip->id], // condition
                    [
                        'user_id'     => Auth::id(),
                        'date'        => $request->start_date,
                        'driver_name' => $request->driver_name,
                        'load_point'  => $request->load_point,
                        'unload_point' => $request->unload_point,
                        'customer'    => $request->customer,
                        'vendor_name' => $request->vendor_name,
                        'vehicle_no'  => $request->vehicle_no,
                        'total_rent'   => $request->total_rent,
                        'advance'     => $request->advance,
                        'due_amount'  => $request->due_amount,
                    ]
                );
            }

            // Update OfficeLedger
            OfficeLedger::updateOrCreate(
                ['trip_id' => $trip->id],
                [
                    'user_id'     => Auth::id(),
                    'date'        => $request->start_date,
                    'unload_point' => $request->unload_point,
                    'load_point'  => $request->load_point,
                    'customer'    => $request->customer,
                    'branch_name' => $request->branch_name,
                    'status'      => $request->status ?? "Pending",
                    'cash_out'    => $request->total_exp,
                    'created_by'  => Auth::id(),
                ]
            );

            // Update CustomerLedger
            CustomerLedger::updateOrCreate(
                ['trip_id' => $trip->id],
                [
                    'working_date'  => $request->start_date,
                    'customer_name' => $request->customer,
                    'chalan'       => $request->challan,
                    'load_point'    => $request->load_point,
                    'unload_point'  => $request->unload_point,
                    'vehicle_no'    => $request->vehicle_no,
                    'bill_amount'   => $request->total_rent,
                    'driver_name'   => $request->driver_name,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Trip updated successfully',
                'data'    => $trip,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Find the trip belonging to the authenticated user
            $trip = Trip::find($id);

            if (!$trip) {
                return response()->json(['message' => 'Trip not found'], 404);
            }

            // Delete related entries
            DriverLedger::where('trip_id', $trip->id)->delete();
            VendorLedger::where('trip_id', $trip->id)->delete();
            OfficeLedger::where('trip_id', $trip->id)->delete();
            CustomerLedger::where('trip_id', $trip->id)->delete();

            // Delete the trip itself
            $trip->delete();

            DB::commit();

            return response()->json([
                'message' => 'Trip and related records deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to delete trip',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
