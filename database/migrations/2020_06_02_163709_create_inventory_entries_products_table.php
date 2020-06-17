<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryEntriesProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_entries_products', function (Blueprint $table) {
            $table->unsignedInteger('inventory_entry_id');
            $table->unsignedInteger('product_id');
            $table->float('product_entry_amount', 8, 2);
            $table->float('product_unit_cost', 8, 2);

            $table->foreign('inventory_entry_id')->references('inventory_entry_id')->on('inventory_entries');
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
        Schema::dropIfExists('inventory_entries_products');
    }
}
