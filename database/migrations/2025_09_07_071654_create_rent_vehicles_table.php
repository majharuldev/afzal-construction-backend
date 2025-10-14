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
        Schema::create('rent_vehicles', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id');
            $table->string('vehicle_name_model')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('vehicle_size_capacity')->nullable();
            $table->string('registration_zone')->nullable();
            $table->string('registration_serial')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_vehicles');
    }
};
