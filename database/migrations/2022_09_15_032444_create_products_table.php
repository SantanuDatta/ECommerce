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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('long_desc')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('regular_price')->default(1);
            $table->unsignedInteger('offer_price')->nullable();
            $table->integer('is_featured')->default(0)->comment('0 = Disabled, 1 = Enabled');
            $table->integer('product_type')->default(0)->comment('0 = Physical, 1 = Digital, 2 = Organic');
            $table->integer('brand_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('mfg_date')->nullable();
            $table->string('exp_date')->nullable();
            $table->string('sku_code')->nullable();
            $table->string('product_tags')->nullable();
            $table->text('additional_info')->nullable();
            $table->integer('status')->default(0)->comment('0 = Inactive, 1 = Active, 2 = Soft Deleted');
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
        Schema::dropIfExists('products');
    }
};
