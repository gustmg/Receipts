<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceServiceStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_service_status', function (Blueprint $table) {
            $table->unsignedInteger('device_id');
            $table->unsignedInteger('service_status_id');
            $table->mediumText('device_service_commentary')->nullable();
            $table->timestamps();

            $table->foreign('device_id')->references('device_id')->on('devices');
            $table->foreign('service_status_id')->references('service_status_id')->on('service_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_service_status');
    }
}
