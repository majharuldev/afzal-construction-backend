<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SupplierLedger;
use Illuminate\Http\Request;

class SupplierLedgerController extends Controller
{
      public function index()
    {
        $data = SupplierLedger::all();

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
