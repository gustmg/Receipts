<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryExitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_exits', function (Blueprint $table) {
            $table->increments('inventory_exit_id');
            $table->dateTime('inventory_exit_created_at');
            $table->unsignedInteger('inventory_exit_worker_id');
            $table->unsignedInteger('inventory_exit_warehouse_id');

            $table->foreign('inventory_exit_worker_id')->references('id')->on('users');
            $table->foreign('inventory_exit_warehouse_id')->references('warehouse_id')->on('warehouses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_exits');
    }
}
