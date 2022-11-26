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
            $table->increments('id');
            $table->integer('inv_id')->default(1);
            $table->integer('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('lastName')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address_1')->nullable();
            $table->text('address_2')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('division_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('zipcode')->nullable();
            $table->text('status')->nullable();
            $table->text('add_info')->nullable();
            // Payment Gateway Info
            $table->integer('payment_method')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->integer('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('transaction_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
