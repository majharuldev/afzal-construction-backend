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
        Schema::create('maintainces', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id'); // vehicle belongs to a user
            $table->string('date');
            $table->string('service_type');
            $table->string('parts');
            $table->string('maintaince_type');
            $table->string('vehicle_no');
            $table->string('parts_price');
            $table->string('service_charge');
            $table->string('total_cost');
            $table->string('priority');
            $table->string('validity');
            $table->string('notes');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintainces');
    }
};
