<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\FundTransfer;
use App\Models\OfficeLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FundTransferController extends Controller
{
    public function index()
    {
        $data = FundTransfer::all();

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
            $FundTransfer = FundTransfer::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'purpose'        => $request->purpose,
                'branch_name'  => $request->branch_name,
                'person_name'  => $request->person_name,
                'type' => $request->type,
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'remarks' => $request->remarks,
                'created_by'   => $request->created_by,

            ]);

            // Insert into branch_ledgers
            OfficeLedger::create([
                'user_id' => Auth::id(),
                'date'        => $request->date,
                'accounts_id' => $FundTransfer->id,
                'branch_name' => $request->branch_name,
                'cash_in'     => $request->amount,
                'remarks'     => $request->remarks,
                'created_by'  => $request->created_by,
            ]);


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ' created successfully',
                'data'    => $FundTransfer
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
        $data = FundTransfer::findOrFail($id);

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Find the FundTransfer record
            $FundTransfer = FundTransfer::findOrFail($id);

            // Update FundTransfer
            $FundTransfer->update([
                'user_id' => Auth::id(),
                'date'        => $request->date,
                'purpose'        => $request->purpose,
                'branch'      => $request->branch,
                'person_name' => $request->person_name,
                'type'        => $request->type,
                'amount'      => $request->amount,
                'bank_name'   => $request->bank_name,
                'remarks'     => $request->remarks,
                'created_by'  => $request->created_by,

            ]);

            // Update Branch_Ledger
            OfficeLedger::where('accounts_id', $FundTransfer->id)
                ->update([
                    'user_id' => Auth::id(),
                    'date'        => $request->date,
                    'branch_name' => $request->branch_name,
                    'cash_in'     => $request->amount,
                    'remarks'     => $request->remarks,
                    'created_by'  => $request->created_by,
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully',
                'data'    => $FundTransfer
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
        $data = FundTransfer::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
