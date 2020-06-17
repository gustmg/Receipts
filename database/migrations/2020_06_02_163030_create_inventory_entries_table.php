<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_entries', function (Blueprint $table) {
            $table->increments('inventory_entry_id');
            $table->dateTime('inventory_entry_created_at');
            $table->float('inventory_entry_total_cost');
            $table->unsignedInteger('inventory_entry_worker_id');
            $table->unsignedInteger('inventory_entry_warehouse_id');

            $table->foreign('inventory_entry_worker_id')->references('id')->on('users');
            $table->foreign('inventory_entry_warehouse_id')->references('warehouse_id')->on('warehouses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_entries');
    }
}
