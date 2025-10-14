<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DriverLedger;
use Illuminate\Http\Request;

class DriverLedgerController extends Controller
{
    public function index()
    {
        $drivers = DriverLedger::all();
        return response()->json($drivers);
    }
}
