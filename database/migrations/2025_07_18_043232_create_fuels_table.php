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
        Schema::create('fuels', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id'); // vehicle belongs to a user
            $table->string('date');
            $table->string('vehicle_no');
            $table->string('unit_price');
            $table->string('fuel_type');
            $table->string('total_cost');
            $table->string('pump_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuels');
    }
};
