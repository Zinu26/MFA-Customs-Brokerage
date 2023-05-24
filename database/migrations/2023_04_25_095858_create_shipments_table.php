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
            $table->unsignedBigInteger('user_id');
            $table->string('consignee_name')->nullable()->default;
            $table->string('bl_number')->nullable()->default;
            $table->string('entry_number')->nullable()->default;
            $table->date('arrival_date')->nullable()->default;
            $table->date('process_started')->nullable()->default;
            $table->date('process_finished')->nullable()->default;
            $table->date('predicted_delivery_date')->nullable()->default;
            $table->date('delivered_date')->nullable()->default;
            $table->string('port_of_origin')->nullable()->default;
            $table->string('destination_address')->nullable()->default;
            $table->string('size')->nullable()->default;
            $table->string('shipment_details')->nullable()->default;
            $table->string('weight')->nullable()->default;
            $table->string('shipping_line')->nullable()->default;
            $table->string('do_status')->nullable()->default;
            $table->string('shipment_status')->nullable()->default;
            $table->string('billing_status')->nullable()->default;
            $table->string('delivery_status')->nullable()->default;
            $table->boolean('status')->default(false);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('consignees')->onDelete('cascade');
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
