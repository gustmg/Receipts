<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostics', function (Blueprint $table) {
            $table->increments('diagnostic_id');
            $table->timestamp('diagnostic_init_date');
            $table->timestamp('diagnostic_close_date');
            $table->unsignedInteger('diagnostic_worker_id');
            $table->unsignedInteger('diagnostic_device_id');

            $table->foreign('diagnostic_worker_id')->references('worker_id')->on('workers');
            $table->foreign('diagnostic_device_id')->references('device_id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnostics');
    }
}
