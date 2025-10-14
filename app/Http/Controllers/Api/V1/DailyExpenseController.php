<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DailyExpense;
use Illuminate\Http\Request;
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


        // Create with authenticated user_id
        $dailyExpense = DailyExpense::create([
            'user_id' => Auth::id(),  // <-- user_id backend থেকে নেওয়া হচ্ছে
            'date' => $request->date,
            'particulars' => $request->particulars,
            'payment_category' => $request->payment_category,
            'branch_name' => $request->branch_name,
            'paid_to' => $request->paid_to,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'DailyExpense created successfully',
            'data' => $dailyExpense
        ], 201);
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
        $DailyExpense = DailyExpense::find($id);

        $DailyExpense->update($request->only([
            'date',
            'particulars',
            'payment_category',
            'paid_to',
            'amount',
            'status'
        ]));

        return response()->json(['message' => 'DailyExpense updated successfully', 'data' => $DailyExpense]);
    }

    // 🔹 Delete DailyExpense
    public function destroy($id)
    {
        $DailyExpense = DailyExpense::find($id);
        $DailyExpense->delete();

        return response()->json(['message' => 'DailyExpense deleted']);
    }
}
