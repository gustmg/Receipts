<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_services', function (Blueprint $table) {
            $table->unsignedInteger('sale_id');
            $table->unsignedInteger('service_id');
            $table->integer('service_quantity');
            $table->decimal('service_unit_price',8,2);

            $table->foreign('sale_id')->references('sale_id')->on('sales');
            $table->foreign('service_id')->references('service_id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_services');
    }
}
