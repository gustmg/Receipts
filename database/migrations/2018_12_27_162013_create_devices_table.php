<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('device_id');
            $table->string('device_name');
            $table->string('device_serial_number')->nullable();
            $table->mediumText('device_trouble_description');
            $table->mediumText('device_commentary')->nullable();
            $table->unsignedInteger('device_receipt_id');
            $table->timestamps();

            $table->foreign('device_receipt_id')->references('receipt_id')->on('receipts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
