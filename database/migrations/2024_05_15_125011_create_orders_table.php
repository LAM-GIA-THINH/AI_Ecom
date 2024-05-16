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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->unsignedBigInteger('amount');
            $table->string('payment_method');
            $table->tinyInteger('payment_status');
            $table->tinyInteger('order_status');
            $table->unsignedBigInteger('sub_total');
            $table->unsignedBigInteger('shipping')->default(0);
            $table->string('tracking')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
