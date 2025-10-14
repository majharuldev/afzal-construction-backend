<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\VendorLedger;
use Illuminate\Http\Request;

class VendorLedgerController extends Controller
{
    public function index()
    {
        $data = VendorLedger::all();

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
