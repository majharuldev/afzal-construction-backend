<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_ledgers', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id');
            $table->string('customer')->nullable();
            $table->string('trip_id')->nullable();
            $table->string('bill_id')->nullable();
            $table->string('date')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('load_point')->nullable();
            $table->string('unload_point')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('trip_rent')->nullable();
            $table->string('advance')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('pay_amount')->nullable();
      
            $table->string('work_time')->nullable();
            $table->string('rate')->nullable();
            $table->string('work_place')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_ledgers');
    }
};
