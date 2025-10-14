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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id'); // vehicle belongs to a user
            $table->string('operator_name')->nullable();
            $table->string('vehicle_name')->nullable();
            $table->string('insurance_date')->nullable();
            $table->string('vehcile_size')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('reg_zone')->nullable();
            $table->string('reg_serial')->nullable();
            $table->string('reg_no')->nullable();
            $table->string('reg_date')->nullable();
            $table->string('status')->nullable();
            $table->string('tax_date')->nullable();
            $table->string('route_per_date')->nullable();
            $table->string('fitness_date')->nullable();
            $table->string('fuel_capcity')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
