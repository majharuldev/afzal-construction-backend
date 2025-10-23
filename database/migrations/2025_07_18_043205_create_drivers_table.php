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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id'); // vehicle belongs to a user
            $table->string('driver_name')->nullable();
            $table->string('driver_mobile')->nullable();
            $table->string('nid')->nullable();
            $table->string('address')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('opening_balance')->nullable();
            $table->string('note')->nullable();
            $table->string('lincense')->nullable();
            $table->string('expire_date')->nullable();
            $table->string('lincense_image')->nullable();
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
        Schema::dropIfExists('drivers');
    }
};
