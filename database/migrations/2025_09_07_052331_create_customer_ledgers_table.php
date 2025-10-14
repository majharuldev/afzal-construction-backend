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
        Schema::create('customer_ledgers', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id');
            $table->string('payment_rec_id')->nullable();
            $table->string('trip_id')->nullable();
            $table->string('bill_date')->nullable();
            $table->string('working_date')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('load_point')->nullable();
            $table->string('unload_point')->nullable();
            $table->string('bill_amount')->nullable();
            $table->string('vat')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('status')->nullable();
            $table->string('chalan')->nullable();
            $table->string('fuel_cost')->nullable();
            $table->string('body_cost')->nullable();
            $table->string('created_by')->nullable();
            $table->string('delar_name')->nullable();
            $table->string('masking')->nullable();
            $table->string('unload_charge')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_ledgers');
    }
};
