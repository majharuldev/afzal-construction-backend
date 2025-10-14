<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $Employees = Employee::all();
        return response()->json([
            'success' => true,
            'data' => $Employees
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:employees,email',
            'mobile' => 'required',
            'address' => 'nullable|string',
            'status' => 'required|string'
        ]);

        $Employee = Employee::create($request->all() + ['user_id' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully',
            'data' => $Employee
        ], 201);
    }

    public function show($id)
    {
        $Employee = Employee::find($id);
        if (!$Employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $Employee]);
    }

    public function update(Request $request, $id)
    {
        $Employee = Employee::find($id);
        if (!$Employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }

        $Employee->update($request->all());
        return response()->json(['success' => true, 'message' => 'Employee updated successfully', 'data' => $Employee]);
    }

    public function destroy($id)
    {
        $Employee = Employee::find($id);
        if (!$Employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }

        $Employee->delete();
        return response()->json(['success' => true, 'message' => 'Employee deleted successfully']);
    }
}
