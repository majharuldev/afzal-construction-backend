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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id');
            $table->string('date')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('rent_category')->nullable();
            $table->string('work_area')->nullable();
            $table->string('opening_balance')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
