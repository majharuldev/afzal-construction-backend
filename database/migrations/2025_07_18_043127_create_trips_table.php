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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            $table->BigInteger('user_id'); // vehicle belongs to a user
            $table->string('start_date');
            $table->string('end_date')->nullable();
            $table->string('customer')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('load_point')->nullable();
            $table->string('additional_load')->nullable();
            $table->string('unload_point')->nullable();
            $table->string('transport_type')->nullable();
            $table->string('trip_type')->nullable();
            $table->string('trip_id')->nullable();
            $table->string('sms_sent')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('vehicle_size')->nullable();
            $table->string('product_details')->nullable();
            $table->string('driver_mobile')->nullable();
            $table->string('challan')->nullable();
            $table->string('driver_adv')->nullable();
            $table->string('remarks')->nullable();
            $table->string('food_cost')->nullable();
            $table->string('total_exp')->nullable();
            $table->string('total_rent')->nullable();
            $table->string('vendor_rent')->nullable();
            $table->string('advance')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('parking_cost')->nullable();
            $table->string('night_guard')->nullable();
            $table->string('toll_cost')->nullable();
            $table->string('feri_cost')->nullable();
            $table->string('police_cost')->nullable();
            $table->string('others_cost')->nullable();
            $table->string('chada')->nullable();
            $table->string('labor')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
