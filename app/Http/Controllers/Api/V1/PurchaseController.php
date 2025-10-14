<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\SupplierLedger;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{


    public function index()
    {
        $data = Purchase::all();

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }



    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Insert into purchases table
            $purchase = Purchase::create([
                'user_id'          => Auth::id(),
                'date'             => $request->date,
                'supplier_name'    => $request->supplier_name,
                'category'         => $request->category,
                'item_name'        => $request->item_name,
                'quantity'         => $request->quantity,
                'unit_price'       => $request->unit_price,
                'purchase_amount'  => $request->purchase_amount,
                'remarks'          => $request->remarks,
                'driver_name'      => $request->driver_name,
                'branch_name'      => $request->branch_name,
                'vehicle_no'       => $request->vehicle_no,
                'vehicle_category' => $request->vehicle_category,
                'priority'         => $request->priority,
                'validity'         => $request->validity,
                'next_service_date'         => $request->next_service_date,
                'service_date'         => $request->service_date,
                'last_km'         => $request->last_km,
                'next_km'         => $request->next_km,
                'status'           => 'pending',
                'created_by'       => Auth::id(),
            ]);

            $ledger = SupplierLedger::create([
                'user_id'        => Auth::id(),
                'date'           => $request->date,
                'mode'           => 'Purchase',
                'purchase_id'    => $purchase->id,
                'purchase_amount' => $request->purchase_amount,
                'unit_price'     => $request->unit_price,
                'created_by'     => Auth::id(),
                'catagory'       => $request->category,
                'supplier_name'  => $request->supplier_name,
                'item_name'      => $request->item_name,
                'quantity'       => $request->quantity,
                'remarks'        => $request->remarks,
            ]);

            $payment = Payment::create([
                'user_id'        => Auth::id(),
                'date'           => $request->date,
                'supplier_name'  => $request->supplier_name,
                'category'       => $request->category,
                'item_name'      => $request->item_name,
                'purchase_id'    => $purchase->id,
                'quantity'       => $request->quantity,
                'unit_price'     => $request->unit_price,
                'total_amount'   => $request->purchase_amount,
                'pay_amount'     => 0,
                'due_amount'     => $request->purchase_amount,
                'remarks'        => $request->remarks,
                'driver_name'    => $request->driver_name,
                'branch_name'    => $request->branch_name,
                'vehicle_no'     => $request->vehicle_no,
                'status'         => 'pending',
                'created_by'     => Auth::id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase created successfully',
                'data'    => [
                    'purchase' => $purchase,
                    'ledger'   => $ledger,
                    'payment'  => $payment,
                ]
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
        $data = Purchase::findOrFail($id);

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::findOrFail($id);


            $purchase->update([
                'user_id' => Auth::id(),
                'date'             => $request->date,
                'supplier_name'    => $request->supplier_name,
                'category'         => $request->category,
                'item_name'        => $request->item_name,
                'quantity'         => $request->quantity,
                'unit_price'       => $request->unit_price,
                'purchase_amount'  => $request->purchase_amount,
                // 'bill_image'       => $image,
                'remarks'          => $request->remarks,
                'driver_name'      => $request->driver_name,
                'branch_name'      => $request->branch_name,
                'fuel_capacity'      => $request->fuel_capacity,
                'fuel_category'      => $request->fuel_category,
                'service_cost'      => $request->service_cost,
                'vehicle_no'       => $request->vehicle_no,
                'vehicle_category'       => $request->vehicle_category,
                'status'           => "pending",
                'priority'           => $request->priority,
                'validity'           => $request->validity,
                'next_service_date'         => $request->next_service_date,
                'service_date'         => $request->service_date,
                'last_km'         => $request->last_km,
                'next_km'         => $request->next_km,
                'created_by'       => $request->created_by,
            ]);



            // 4. Update supplier ledger
            SupplierLedger::updateOrCreate(
                ['purchase_id' => $purchase->id],
                [
                    'user_id' => Auth::id(),
                    'date'            => $request->date,
                    'mode'            => 'Purchase',
                    'purchase_amount' => $request->purchase_amount,
                    'unit_price'      => $request->unit_price,
                    'created_by'      => $request->created_by,
                    'catagory'        => $request->category,
                    'supplier_name'   => $request->supplier_name,
                    'item_name'       => $request->item_name,
                    'quantity'        => $request->quantity,
                    'remarks'         => $request->remarks,
                ]
            );

            // 5. Update payment
            Payment::updateOrCreate(
                ['purchase_id' => $purchase->id],
                [
                    'user_id' => Auth::id(),
                    'date'          => $request->date,
                    'supplier_name' => $request->supplier_name,
                    'category'      => $request->category,
                    'item_name'     => $request->item_name,
                    'quantity'      => $request->quantity,
                    'unit_price'    => $request->unit_price,
                    'total_amount'  => $request->purchase_amount,
                    'remarks'       => $request->remarks,
                    'pay_amount'      => "0",
                    'due_amount'      => $request->purchase_amount,
                    'driver_name'   => $request->driver_name,
                    'branch_name'   => $request->branch_name,
                    'vehicle_no'    => $request->vehicle_no,
                    'status'        => 'pending',
                    'created_by'    => $request->created_by,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase updated successfully',
                'data'    => $purchase
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
            $purchase = Purchase::findOrFail($id);

            // Delete related records first
            SupplierLedger::where('purchase_id', $purchase->id)->delete();
            Payment::where('purchase_id', $purchase->id)->delete();

            // Delete purchase
            $purchase->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase deleted successfully'
            ]);
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
