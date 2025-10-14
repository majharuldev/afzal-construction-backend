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
        Schema::create('daily_expenses', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id'); // vehicle belongs to a user
            $table->string('date');
            $table->string('branch_name');
            $table->string('particulars');
            $table->string('payment_category');
            $table->string('paid_to');
            $table->string('amount');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_expenses');
    }
};
