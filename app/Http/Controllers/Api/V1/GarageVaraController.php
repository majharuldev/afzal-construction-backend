<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\GarageVara;
use App\Models\OfficeLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\GarageCustomerLedger;
use Illuminate\Support\Facades\Auth;

class GarageVaraController extends Controller
{

    // get all Data by userid
    public function index()
    {
        $GarageVaras = GarageVara::all();
        return response()->json([
            'success' => true,
            'data' => $GarageVaras
        ]);
    }

    // save all data


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Insert into GarageVara
            $vara = GarageVara::create([
                'user_id'       => Auth::id(),
                'customer_name' => $request->customer_name,
                'date'          => $request->date,
                'month_name'    => $request->month_name,
                'amount'        => $request->amount,
                'status'        => $request->status,
                'branch_name'   => $request->branch_name,
                'remarks'       => $request->remarks,
                'created_by'    => $request->created_by,
            ]);

            // Insert into OfficeLedger



            if ($request->status == "Paid") {

                GarageCustomerLedger::create([
                    'user_id'       => Auth::id(),
                    'bill_date'     => $request->date,
                    'customer_name' => $request->customer_name,
                    'vara_id'       => $vara->id, // FIXED
                    'rec_amount'    => $request->amount,
                    'created_by'    => $request->created_by,
                ]);


                OfficeLedger::create([
                    'user_id'     => Auth::id(),
                    'date'        => $request->date,
                    'vara_id'     => $vara->id,
                    'customer'    => $request->customer_name,
                    'branch_name' => $request->branch_name,
                    'cash_in'     => $request->amount,
                    'remarks'     => $request->remarks,
                    'created_by'  => $request->created_by,
                ]);
            } else {

                GarageCustomerLedger::create([
                    'user_id'       => Auth::id(),
                    'bill_date'     => $request->date,
                    'customer_name' => $request->customer_name,
                    'vara_id'       => $vara->id, // FIXED
                    'due_amount'    => $request->amount,
                    'created_by'    => $request->created_by,
                ]);
            }


            // Insert into GarageCustomerLedger


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Created successfully',
                'data'    => $vara
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }






    // single data read
    public function show($id)
    {
        $GarageVara = GarageVara::find($id);
        if (!$GarageVara) {
            return response()->json(['success' => false, 'message' => 'GarageVara not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $GarageVara]);
    }


    // data update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            // Find Vara data
            $vara = GarageVara::findOrFail($id);

            // Update GarageVara
            $vara->update([
                'customer_name' => $request->customer_name,
                'date'          => $request->date,
                'month_name'    => $request->month_name,
                'amount'        => $request->amount,
                'status'        => $request->status,
                'branch_name'   => $request->branch_name,
                'remarks'       => $request->remarks,
                'updated_by'    => Auth::id(),
            ]);

            $isPaid = trim(strtolower($request->status)) == "paid";

            // Find Customer Ledger row for this Vara
            $ledger = GarageCustomerLedger::where('vara_id', $id)->first();

            if ($ledger) {
                $ledger->update([
                    'bill_date'     => $request->date,
                    'customer_name' => $request->customer_name,
                    'rec_amount'    => $isPaid ? $request->amount : null,
                    'due_amount'    => $isPaid ? null : $request->amount,
                    'updated_by'    => Auth::id(),
                ]);
            }

            // Office Ledger Update
            if ($isPaid) {

                // Check existing OfficeLedger record
                $office = OfficeLedger::where('vara_id', $id)->first();

                if ($office) {
                    // Update existing record
                    $office->update([
                        'date'        => $request->date,
                        'customer'    => $request->customer_name,
                        'branch_name' => $request->branch_name,
                        'cash_in'     => $request->amount,
                        'remarks'     => $request->remarks,
                        'updated_by'  => Auth::id(),
                    ]);
                } else {
                    // Create if not exists
                    OfficeLedger::create([
                        'user_id'     => Auth::id(),
                        'date'        => $request->date,
                        'vara_id'     => $id,
                        'customer'    => $request->customer_name,
                        'branch_name' => $request->branch_name,
                        'cash_in'     => $request->amount,
                        'remarks'     => $request->remarks,
                        'created_by'  => Auth::id(),
                    ]);
                }
            } else {
                // If status is NOT paid, delete OfficeLedger record if exists
                OfficeLedger::where('vara_id', $id)->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully',
                'data'    => $vara
            ], 200);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Find vara entry
            $vara = GarageVara::findOrFail($id);

            // Delete OfficeLedger entry
            OfficeLedger::where('vara_id', $id)->delete();

            // Delete GarageCustomerLedger entry
            GarageCustomerLedger::where('vara_id', $id)->delete();

            // Delete main vara record
            $vara->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
