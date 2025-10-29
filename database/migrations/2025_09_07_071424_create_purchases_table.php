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
            $table->unsignedBigInteger('user_id');
            $table->date('date')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('category')->nullable();
            $table->decimal('purchase_amount', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('service_charge')->nullable();
            $table->string('remarks')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('priority')->nullable();
            $table->date('validity')->nullable();
            $table->string('status')->nullable();
            $table->boolean('sms_sent')->default(false);
            $table->date('service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->integer('last_km')->nullable();
            $table->integer('next_km')->nullable();
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
