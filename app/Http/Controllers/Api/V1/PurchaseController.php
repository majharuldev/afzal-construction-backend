<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\SupplierLedger;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\purchase_items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PurchaseController extends Controller
{


    public function index()
    {
        $data = Purchase::all();
        $data->load('items');
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }


    public function store(Request $request)
    {
        // 1️⃣ Validate incoming request

        DB::beginTransaction();

        try {
            // 2️⃣ Handle image upload
            $image_name = null;
            if ($request->hasFile('image')) {
                $image_name = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('uploads/purchase'), $image_name);
            }

            // 3️⃣ Create Purchase
            $purchase = Purchase::create([
                'user_id'          => Auth::id(),
                'date'             => $request->date,
                'supplier_name'    => $request->supplier_name,
                'category'         => $request->category,
                'purchase_amount'  => $request->purchase_amount,
                'remarks'          => $request->remarks,
                'driver_name'      => $request->driver_name,
                'branch_name'      => $request->branch_name,
                'vehicle_no'       => $request->vehicle_no,
                'vehicle_category' => $request->vehicle_category,
                'priority'         => $request->priority,
                'validity'         => $request->validity,
                'image'            => $image_name,
                'next_service_date' => $request->next_service_date,
                'service_date'     => $request->service_date,
                'service_charge'     => $request->service_charge,
                'last_km'          => $request->last_km,
                'next_km'          => $request->next_km,
                'status'           => 'pending',
                'created_by'       => $request->created_by,
            ]);

            // 4️⃣ Insert multiple Purchase Items
            foreach ($request->item_name as $key => $name) {
                purchase_items::create([
                    'purchase_id' => $purchase->id,
                    'item_name'   => $name,
                    'quantity'    => $request->quantity[$key],
                    'unit_price'  => $request->unit_price[$key],
                    'total'       => $request->total[$key],
                ]);
            }

            // 5️⃣ Create Supplier Ledger Entry
            SupplierLedger::create([
                'user_id'         => Auth::id(),
                'date'            => $request->date,
                'mode'            => 'Purchase',
                'purchase_id'     => $purchase->id,
                'purchase_amount' => $request->purchase_amount,
                'created_by'      => Auth::id(),
                'catagory'        => $request->category,
                'supplier_name'   => $request->supplier_name,
                'remarks'         => $request->remarks,
            ]);

            // 6️⃣ Create Payment Entry
            Payment::create([
                'user_id'        => Auth::id(),
                'date'           => $request->date,
                'supplier_name'  => $request->supplier_name,
                'category'       => $request->category,
                'purchase_id'    => $purchase->id,
                'total_amount'   => $request->purchase_amount,
                'pay_amount'     => 0,
                'due_amount'     => $request->purchase_amount,
                'remarks'        => $request->remarks,
                'driver_name'    => $request->driver_name,
                'branch_name'    => $request->branch_name,
                'vehicle_no'     => $request->vehicle_no,
                'status'         => 'pending',
                'created_by'     => $request->created_by,
            ]);

            DB::commit();
            $purchase->load('items');
            return response()->json([
                'success' => true,
                'message' => 'Purchase created successfully',
                'data'    => $purchase
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
        $data->load('items');
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }




    public function update(Request $request, $id)
    {

        $purchase = Purchase::findOrFail($id);

        DB::beginTransaction();



        try {

            $image = $purchase->image;

            if ($request->hasFile('image')) {
                $image_name = time() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/purchase'), $image_name);
                $image = url('uploads/purchase/' . $image_name);
            }

            $purchase->update($request->except('image') + ['image' => $image]);




            $purchase->update([
                'date'              => $request->date,
                'supplier_name'     => $request->supplier_name,
                'category'          => $request->category,
                'purchase_amount'   => $request->purchase_amount,
                'remarks'           => $request->remarks,
                'driver_name'       => $request->driver_name,
                'branch_name'       => $request->branch_name,
                'vehicle_no'        => $request->vehicle_no,
                'vehicle_category'  => $request->vehicle_category,
                'priority'          => $request->priority,
                'validity'          => $request->validity,
                'image'             => $image_name, // Updated path or null
                'next_service_date' => $request->next_service_date,
                'service_date'      => $request->service_date,
                'service_charge'     => $request->service_charge,
                'last_km'           => $request->last_km,
                'next_km'           => $request->next_km,
                // ... (other fields) ...
            ]);


            purchase_items::where('purchase_id', $purchase->id)->delete();

            // B. Insert the new/updated items
            foreach ($request->item_name as $key => $name) {
                purchase_items::create([
                    'purchase_id' => $purchase->id,
                    'item_name'   => $name,
                    'quantity'    => $request->quantity[$key],
                    'unit_price'  => $request->unit_price[$key],
                    'total'       => $request->total[$key],
                ]);
            }

            // 3) Single ledger entry update
            SupplierLedger::where('purchase_id', $purchase->id)->update([
                'date'              => $request->date,
                'purchase_amount'   => $request->purchase_amount,
                'catagory'          => $request->category,
                'supplier_name'     => $request->supplier_name,
                'remarks'           => $request->remarks,
            ]);

            // 4) Single payment entry update
            Payment::where('purchase_id', $purchase->id)->update([
                'date'           => $request->date,
                'supplier_name'  => $request->supplier_name,
                'category'       => $request->category,
                'total_amount'   => $request->purchase_amount,
                'due_amount'     => $request->purchase_amount,
                'remarks'        => $request->remarks,
                'driver_name'    => $request->driver_name,
                'branch_name'    => $request->branch_name,
                'vehicle_no'     => $request->vehicle_no,
            ]);

            DB::commit();


            $purchase->load('items');
            // FINAL CLEANUP: Delete the OLD image only AFTER successful commit


            return response()->json([
                'success' => true,
                'message' => 'Purchase updated successfully',
                'data' => $purchase
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // Rollback Cleanup: If a NEW image was uploaded but the DB failed, delete the NEW image.
            // This prevents orphaned files.
            if ($image_name && $image_name != $purchase->image) {
                $new_image_path = public_path('uploads/purchase') . '/' . $image_name;
                if (File::exists($new_image_path)) {
                    File::delete($new_image_path);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong during update',
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
