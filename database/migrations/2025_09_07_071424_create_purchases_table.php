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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id');
            $table->string('date')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('category')->nullable();
            $table->string('item_name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('purchase_amount')->nullable();
            $table->string('bill_image')->nullable();
            $table->string('remarks')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('priority')->nullable();
            $table->string('validity')->nullable();
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
        Schema::dropIfExists('purchases');
    }
};
