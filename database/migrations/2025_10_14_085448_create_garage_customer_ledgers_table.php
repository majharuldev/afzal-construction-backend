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
        Schema::create('garage_customer_ledgers', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id');
            $table->string('customer_name')->nullable();
            $table->string('vara_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('month_name')->nullable();
            $table->string('address')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('vehicle_qty')->nullable();
            $table->string('created_by')->nullable();
            $table->string('remarks')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garage_customer_ledgers');
    }
};
