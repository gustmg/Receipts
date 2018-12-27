<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->increments('revision_id');
            $table->timestamp('revision_date');
            $table->mediumText('revision_description');
            $table->boolean('revision_finished_succesfully');
            $table->unsignedInteger('revision_service_id');
            $table->unsignedInteger('revision_authorization_status_id');
            $table->unsignedInteger('revision_diagnostic_id');
            $table->unsignedInteger('revision_worker_id');

            $table->foreign('revision_service_id')->references('service_id')->on('services');
            $table->foreign('revision_authorization_status_id')->references('authorization_status_id')->on('authorization_status');
            $table->foreign('revision_diagnostic_id')->references('diagnostic_id')->on('diagnostics');
            $table->foreign('revision_worker_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revisions');
    }
}
