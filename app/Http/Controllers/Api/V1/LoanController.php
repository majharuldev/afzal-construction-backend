<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\loan;
use App\Models\OfficeLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $data = loan::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {


        DB::beginTransaction();

        try {
            // Create Salary Advance entry
            $salary = loan::create([
                'user_id'      => Auth::id(),
                'date'         => $request->date,
                'employee_id'         => $request->employee_id,
                'amount'         => $request->amount,
                'adjustment'         => $request->adjustment,
                'branch_name'  => $request->branch_name,
                'monthly_deduction'         => $request->monthly_deduction,
                'remarks'      => $request->remarks,
                'status'      => $request->status,
                'created_by'   => $request->created_by
            ]);

            // Create Office Ledger entry
            OfficeLedger::create([
                'user_id'      => Auth::id(),
                'date'         => $request->date,
                'loan_id'  => $salary->id,
                'branch_name'  => $request->branch_name,
                'cash_out'     => $request->amount,
                'remarks'      => $request->remarks,
                'created_by'   => $request->created_by
            ]);

            DB::commit();

            return response()->json([
                'status' => 'Success',
                'message' => 'Salary advance created successfully.',
                'data' => $salary
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'Error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $data = loan::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Find the Salary Advance entry
            $salary = loan::findOrFail($id);

            // Update Salary Advance fields
            $salary->update([
                'date'               => $request->date,
                'employee_id'        => $request->employee_id,
                'amount'             => $request->amount,
                'adjustment'         => $request->adjustment,
                'monthly_deduction'  => $request->monthly_deduction,
                'remarks'            => $request->remarks,
                'status'             => $request->status,
                'created_by'         => $request->created_by,
            ]);

            // Update related Office Ledger record (if exists)
            $ledger = OfficeLedger::where('advanced_id', $salary->id)->first();

            if ($ledger) {
                $ledger->update([
                    'date'         => $request->date,
                    'branch_name'  => $request->branch_name,
                    'cash_out'     => $request->amount,
                    'remarks'      => $request->remarks,
                    'created_by'   => $request->created_by,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'Success',
                'message' => 'Salary advance updated successfully.',
                'data' => $salary
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'Error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {

        $loan = loan::findOrFail($id);


        OfficeLedger::where('loan_id', $loan->id)->delete();


        $loan->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Loan and related ledger deleted successfully.',

        ], 200);
    }
}
