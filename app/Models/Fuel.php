<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'vehicle_no',
        'unit_price',
        'fuel_type',
        'total_cost',
        'pump_name',
    ];
}
