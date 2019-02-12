<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_receipts', function (Blueprint $table) {
            $table->unsignedInteger('device_id');
            $table->unsignedInteger('receipt_id');

            $table->foreign('device_id')->references('device_id')->on('devices');
            $table->foreign('receipt_id')->references('receipt_id')->on('receipts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices_receipts');
    }
}
