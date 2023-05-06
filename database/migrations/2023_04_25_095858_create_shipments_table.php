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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('consignee_name');
            $table->date('arrival');
            $table->date('process_started')->nullable()->default;
            $table->date('process_finished')->nullable()->default;
            $table->date('predicted_delivery_date')->nullable()->default;
            $table->string('port_of_origin')->nullable()->default;
            $table->string('destination_address')->nullable()->default;
            $table->string('size');
            $table->string('item_description');
            $table->string('weight');
            $table->string('bl_number');
            $table->string('shipping_line');
            $table->string('do_status');
            $table->string('shipment_status');
            $table->string('billing_status');
            $table->string('delivery_status');
            $table->boolean('status')->default(false);

            $table->timestamps();

            // $table->foreign('consignee_name')->references('name')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
