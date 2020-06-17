<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryExitsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_exits_products', function (Blueprint $table) {
            $table->unsignedInteger('inventory_exit_id');
            $table->unsignedInteger('product_id');
            $table->float('product_exit_amount', 8, 2);
            $table->string('product_exit_justification', 100);

            $table->foreign('inventory_exit_id')->references('inventory_exit_id')->on('inventory_exits');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_exits_products');
    }
}
