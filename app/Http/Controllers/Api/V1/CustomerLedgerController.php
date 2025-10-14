<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CustomerLedger;
use Illuminate\Http\Request;

class CustomerLedgerController extends Controller
{

    public function index()
    {
        $data = CustomerLedger::all();

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
