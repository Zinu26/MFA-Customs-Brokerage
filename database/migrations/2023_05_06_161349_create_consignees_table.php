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
        // Schema::create('consignees', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('user_id');
        //     $table->string('tin')->unique();
        //     $table->string('contact');
        //     $table->string('address');
        //     $table->boolean('status')->default(false);
        //     $table->timestamps();

        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignees');
    }
};
