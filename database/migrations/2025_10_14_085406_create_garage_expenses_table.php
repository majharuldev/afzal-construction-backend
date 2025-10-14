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
        Schema::create('garage_expenses', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id');
            $table->string('person_name')->nullable();
            $table->string('amount')->nullable();
            $table->string('date')->nullable();
            $table->string(' category')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garage_expenses');
    }
};
