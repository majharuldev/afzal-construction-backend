<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintaince extends Model
{

    protected $fillable = [
        'user_id',
        'date',
        'service_type',
        'parts',
        'maintaince_type',
        'vehicle_no',
        'parts_price',
        'service_charge',
        'total_cost',
        'priority',
        'validity',
        'notes',
        'status',
    ];



}
