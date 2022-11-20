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
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('id')->default(1);
            $table->string('site_title')->unique();
            $table->text('logo')->nullable();
            $table->text('favicon')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('support_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('business_hours')->nullable();
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
        Schema::dropIfExists('settings');
    }
};
