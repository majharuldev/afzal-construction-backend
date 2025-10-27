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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            $table->BigInteger('user_id'); // vehicle belongs to a user
            $table->string('date');
            $table->string('customer')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('load_point')->nullable();
            $table->string('additional_load')->nullable();
            $table->string('unload_point')->nullable();
            $table->string('transport_type')->nullable();
            $table->string('trip_type')->nullable();
            $table->string('trip_no')->nullable();
            $table->string('sms_sent')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('vehicle_size')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('additional_cost')->nullable();
            $table->string('product_details')->nullable();
            $table->string('driver_mobile')->nullable();
            $table->string('challan')->nullable();
            $table->string('driver_adv')->nullable();
            $table->string('remarks')->nullable();
            $table->string('food_cost')->nullable();
            $table->string('total_exp')->nullable();
            $table->string('total_rent')->nullable();
            $table->string('vendor_rent')->nullable();
            $table->string('advance')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('parking_cost')->nullable();
            $table->string('night_guard')->nullable();
            $table->string('toll_cost')->nullable();
            $table->string('feri_cost')->nullable();
            $table->string('police_cost')->nullable();
            $table->string('others_cost')->nullable();
            $table->string('chada')->nullable();
            $table->string('labor')->nullable();
            $table->string('fuel_cost')->nullable();
            $table->string('challan_cost')->nullable();
            $table->string('d_day')->nullable();
            $table->string('d_total')->nullable();
            $table->string('d_amount')->nullable();

            // equip extra
            $table->string('work_time')->nullable();
            $table->string('rate')->nullable();
            $table->string('work_place')->nullable();
            // more
            $table->string('trip_count')->nullable();
            $table->string('trans__cost')->nullable();
            $table->string('log_ref')->nullable();
            $table->string('log_sign')->nullable();
            $table->string('image')->nullable();
            $table->string('extra_bill')->nullable();

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
        Schema::dropIfExists('trips');
    }
};
