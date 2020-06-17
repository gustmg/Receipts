<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->string('product_description')->nullable();
            $table->timestamps();
            $table->float('product_cost', 8, 2)->default('0');
            $table->integer('product_base_price_percentage')->default('0');
            $table->integer('product_retail_price_percentage')->default('0');
            $table->integer('product_wholesale_price_percentage')->default('0');
            $table->float('product_stock')->default('0');
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
}
