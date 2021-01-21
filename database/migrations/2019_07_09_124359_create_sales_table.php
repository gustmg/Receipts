<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('sale_id');
            $table->unsignedInteger('sale_worker_id');
            $table->unsignedInteger('sale_client_id');
            $table->unsignedInteger('sale_payment_form_id');
            $table->boolean('sale_invoiced');
            $table->decimal('sale_total_amount',8,2);
            $table->timestamps();

            $table->foreign('sale_worker_id')->references('id')->on('users');
            $table->foreign('sale_client_id')->references('client_id')->on('clients');
            $table->foreign('sale_payment_form_id')->references('payment_form_id')->on('payment_form');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
