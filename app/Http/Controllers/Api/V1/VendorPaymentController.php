<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\OfficeLedger;
use App\Models\VendorLedger;
use Illuminate\Http\Request;
use App\Models\VendorPayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VendorPaymentController extends Controller
{
    public function index()
    {
        $data = VendorPayment::all();

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }





    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            // Insert into trips table
            $dailyExp = VendorPayment::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'vendor_name'  => $request->vendor_name,
                'branch_name'  => $request->branch_name,
                'bill_ref' => $request->bill_ref,
                'amount' => $request->amount,
                'note' => $request->note,
                'cash_type' => $request->cash_type,
                'status' => $request->status,


            ]);

            // Insert into branch_ledgers
            OfficeLedger::create([
                'user_id' => Auth::id(),
                'date'               => $request->date,
                'payment_id'           => $dailyExp->id,
                'cash_out'           => $request->amount,
                'branch_name'           => $request->branch_name,
                'remarks'               => $request->note,

            ]);

            VendorLedger::create([
                'user_id' => Auth::id(),
                'date'                    => $request->date,
                'payment_id'               => $dailyExp->id,
                'pay_amount'           => $request->amount,
                'vendor_name'  => $request->vendor_name,
                'branch_name'           => $request->branch_name,


            ]);



            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ' created successfully',
                'data'    => $dailyExp
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
    public function show($id)
    {
        $data = VendorPayment::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Update VendorPayment
            $VendorPayment = VendorPayment::findOrFail($id);
            $VendorPayment->update([
                'user_id' => Auth::id(),
                'date'         => $request->date,
                'vendor_name'  => $request->vendor_name,
                'branch_name'  => $request->branch_name,
                'bill_ref'     => $request->bill_ref,
                'amount'       => $request->amount,
                'note'         => $request->note,
                'cash_type'    => $request->cash_type,
                'status'       => $request->status,
            ]);

            // Update Branch_Ledger where bill_id matches
            OfficeLedger::where('payment_id', $VendorPayment->id)->update([
                'user_id' => Auth::id(),
                'date'         => $request->date,
                'cash_out'     => $request->amount,
                'branch_name'  => $request->branch_name,
                'remarks'      => $request->note,
            ]);

            // Update VendorLedger where bill_id matches
            VendorLedger::where('bill_id', $VendorPayment->id)->update([
                'user_id' => Auth::id(),
                'date'         => $request->date,
                'pay_amount'   => $request->amount,
                'vendor_name'  => $request->vendor_name,
                'branch_name'  => $request->branch_name,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully.',
                'data'    => $VendorPayment
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update data.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Find the VendorPayment record for the logged-in user
            $payment = VendorPayment::find($id);

            if (!$payment) {
                return response()->json(['message' => 'Payment not found'], 404);
            }

            // Delete related entries
            OfficeLedger::where('payment_id', $payment->id)->delete();
            VendorLedger::where('bill_id', $payment->id)->delete();

            // Delete the main VendorPayment record
            $payment->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vendor payment and related records deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payment',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
