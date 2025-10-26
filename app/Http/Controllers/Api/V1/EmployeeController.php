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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|unique:employees,email',
    //         'mobile' => 'required',
    //         'address' => 'nullable|string',
    //         'status' => 'required|string'
    //     ]);

    //     $Employee = Employee::create($request->all() + ['user_id' => Auth::id()]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Employee created successfully',
    //         'data' => $Employee
    //     ], 201);
    // }




    public function store(Request $request)
    {
        $image = null;

        // ✅ শুধু image থাকলে upload করবে
        if ($request->hasFile('image')) {
            $image_name = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/employee'), $image_name);
            $image = $image_name;
        }

        // ✅ create data (image optional + user_id auto add)
        $employee = Employee::create(
            $request->except('image') + [
                'user_id' => Auth::id(),
                'image' => $image,
            ]
        );

        // ✅ Full image URL তৈরি
        $image_url = $image ? url('uploads/employee/' . $image) : null;

        return response()->json([
            'status' => 'Success',
            'data' => $employee,
            'image_url' => $image_url, // ✅ full image URL পাঠানো হচ্ছে
        ], 200);
    }



    public function update(Request $request, $id)
    {
        $validation = validator([
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg'
        ]);
        $image = null;
        $data = Employee::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($data->image && file_Exists(public_path('uploads/employee/' . $data->image))) {
                unlink(public_path('uploads/employee/' . $data->image));
            }
            $image_name = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/employee'), $image_name);
            $image = $image_name;
        }

        $data->update($request->except('image') + ['image' => $image]);

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }






    public function show($id)
    {
        $Employee = Employee::find($id);
        if (!$Employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $Employee]);
    }




    // public function update(Request $request, $id)
    // {
    //     $Employee = Employee::find($id);
    //     if (!$Employee) {
    //         return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
    //     }

    //     $Employee->update($request->all());
    //     return response()->json(['success' => true, 'message' => 'Employee updated successfully', 'data' => $Employee]);
    // }

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
