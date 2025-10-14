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
        Schema::create('office_ledgers', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id');
              $table->string('date')->nullable();
            $table->string('trip_id')->nullable();
            $table->string('purchase_id')->nullable();
            $table->string('payment_rec_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('remarks')->nullable();
            $table->string('mode')->nullable();
            $table->string('unload_point')->nullable();
            $table->string('load_point')->nullable();
            $table->string('trip_expense')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('cash_in')->nullable();
            $table->string('cash_out')->nullable();
            $table->string('ref')->nullable();
            $table->string('status')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('created_by')->nullable();
            $table->string('customer')->nullable();
            $table->string('balance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_ledgers');
    }
};
