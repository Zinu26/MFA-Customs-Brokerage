<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('close_shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id');
            $table->string('consignee_name');
            $table->string('entry_number');
            $table->string('bl_number');
            $table->date('arrival_date');
            $table->date('process_started');
            $table->date('process_finished');
            $table->date('predicted_delivery_date');
            $table->date('delivered_date');
            $table->string('size');
            $table->string('weight');
            $table->string('shipment_details');
            $table->string('shipping_line');
            $table->string('port_of_origin');
            $table->string('destination_address');
            $table->string('delivery_status');
            $table->boolean('status')->default(false);

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('close_shipments');
    }
};
