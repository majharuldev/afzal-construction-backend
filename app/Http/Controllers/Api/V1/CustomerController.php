<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $Customers = Customer::all();
        return response()->json($Customers);
    }

    public function store(Request $request)
    {
           
  
        $Customer = Customer::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'opening_balance' => $request->opening_balance,
            'status' => $request->status,
            'rate' => $request->rate,
            'created_by' => $request->created_by,

        ]);

        return response()->json(['message' => 'Customer created successfully', 'data' => $Customer]);
    }

    public function show($id)
    {
        $Customer = Customer::find($id);
        if (!$Customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return response()->json($Customer);
    }

    public function update(Request $request, $id)
    {
        $Customer = Customer::find($id);
        if (!$Customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $Customer->update($request->all());
        return response()->json(['message' => 'Customer updated successfully', 'data' => $Customer]);
    }

    public function destroy($id)
    {
        $Customer = Customer::find($id);
        if (!$Customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $Customer->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
