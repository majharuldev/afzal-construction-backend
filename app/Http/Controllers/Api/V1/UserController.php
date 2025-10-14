<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // fetch all users

        return response()->json([
            'message' => 'Users fetched successfully',
            'users' => $users
        ], 200);
    }
}
