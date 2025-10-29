<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
     protected $guarded=[''];

        public function items()
    {
        return $this->hasMany(purchase_items::class);
    }
}
