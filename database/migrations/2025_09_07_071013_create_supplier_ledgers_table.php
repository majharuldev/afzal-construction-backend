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
        Schema::create('supplier_ledgers', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id');
            $table->string('date')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('purchase_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('purchase_amount')->nullable();
            $table->string('pay_amount')->nullable();
            $table->string('status')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('created_by')->nullable();
            $table->string('catagory')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('item_name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_ledgers');
    }
};
