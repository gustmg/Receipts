<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('receipt_id');
            $table->timestamp('receipt_date');
            $table->unsignedInteger('receipt_worker_id');
            $table->unsignedInteger('receipt_client_id');
            $table->timestamps();

            $table->foreign('receipt_worker_id')->references('id')->on('users');
            $table->foreign('receipt_client_id')->references('client_id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
