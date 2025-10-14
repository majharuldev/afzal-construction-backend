<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\GarageCustomerLedger;
use Illuminate\Http\Request;

class GarageCustomerLedgerController extends Controller
{
    public function index()
    {
        $GarageExpenses = GarageCustomerLedger::all();
        return response()->json([
            'success' => true,
            'data' => $GarageExpenses
        ]);
    }
}
