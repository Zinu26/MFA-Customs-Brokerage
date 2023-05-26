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
            $table->string('consignee_name')->nullable();
            $table->string('bl_number')->nullable();
            $table->string('entry_number')->nullable();
            $table->date('arrival_date')->nullable();
            $table->date('process_started')->nullable();
            $table->date('process_finished')->nullable();
            $table->date('predicted_delivery_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->string('port_of_origin')->nullable();
            $table->string('destination_address')->nullable();
            $table->string('size')->nullable();
            $table->string('shipment_details')->nullable();
            $table->string('weight')->nullable();
            $table->string('shipping_line')->nullable();
            $table->string('do_status')->nullable();
            $table->string('shipment_status')->nullable();
            $table->string('billing_status')->nullable();
            $table->string('delivery_status')->nullable();
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
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('shipments');
    }
};
