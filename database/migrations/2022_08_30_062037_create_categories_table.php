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
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->integer('is_parent')->default(0)->comment('0 = Parent Cat');
            $table->integer('is_featured')->default(0)->comment('0 = Disabled, 1 = Enabled');
            $table->integer('status')->default(0)->comment('0 = Active, 1 = Inactive, 2 = Soft Deleted');
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
        Schema::dropIfExists('categories');
    }
};
