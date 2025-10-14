<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\OfficeLedger;
use Illuminate\Http\Request;

class OfficeLedgerController extends Controller
{
   public function index()
    {
        $OfficeLedger = OfficeLedger::all();
        return response()->json([
            'success' => true,
            'data' => $OfficeLedger
        ]);
    }

}
