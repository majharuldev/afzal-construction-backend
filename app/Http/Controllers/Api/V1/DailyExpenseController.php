<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\DailyExpense;
use App\Models\OfficeLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DailyExpenseController extends Controller
{
    public function index()
    {
        $DailyExpenses = DailyExpense::all();
        return response()->json($DailyExpenses);
    }

    // 🔹 Store new DailyExpense


    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            // Insert into trips table
            $dailyExpense = DailyExpense::create([
                'user_id' => Auth::id(),  // <-- user_id backend থেকে নেওয়া হচ্ছে
                'date' => $request->date,
                'particulars' => $request->particulars,
                'payment_category' => $request->payment_category,
                'branch_name' => $request->branch_name,
                'paid_to' => $request->paid_to,
                'amount' => $request->amount,
                'remarks' => $request->remarks,
                'status' => $request->status,
                'created_by'         => $request->created_by,
            ]);
            // Insert into branch_ledgers
            OfficeLedger::create([
                'user_id' => Auth::id(),
                'date'               => $request->date,
                'expense_id' => $dailyExpense->id,
                'branch_name' => $request->branch_name,
                'cash_out'      => $request->amount,
                'remarks' => $request->remarks,
                'created_by'         => $request->created_by,
            ]);


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ' created successfully',
                'data'    => $dailyExpense
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


    // 🔹 Show single DailyExpense
    public function show($id)
    {
        $DailyExpense = DailyExpense::find($id);
        return response()->json($DailyExpense);
    }

    // 🔹 Update DailyExpense
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Find the existing DailyExpense record
            $dailyExpense = DailyExpense::findOrFail($id);

            // Update DailyExpense fields
            $dailyExpense->update([
                'date' => $request->date,
                'particulars' => $request->particulars,
                'payment_category' => $request->payment_category,
                'branch_name' => $request->branch_name,
                'paid_to' => $request->paid_to,
                'amount' => $request->amount,
                'remarks' => $request->remarks,
                'status' => $request->status,
                'created_by' => $request->created_by,
            ]);

            // Update the related OfficeLedger record
            $officeLedger = OfficeLedger::where('expense_id', $dailyExpense->id)->first();

            if ($officeLedger) {
                $officeLedger->update([
                    'date' => $request->date,
                    'branch_name' => $request->branch_name,
                    'cash_out' => $request->amount,
                    'remarks' => $request->remarks,
                    'created_by' => $request->created_by,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully',
                'data' => $dailyExpense
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // 🔹 Delete DailyExpense
    public function destroy($id)
    {
        $DailyExpense = DailyExpense::find($id);

        OfficeLedger::where('expense_id', $DailyExpense->id)->delete();
        $DailyExpense->delete();

        return response()->json(['message' => 'DailyExpense deleted']);
    }
}
