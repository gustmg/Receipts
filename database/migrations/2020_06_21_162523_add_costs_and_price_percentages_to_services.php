<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCostsAndPricePercentagesToServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->float('service_cost', 8, 2)->default('0');
            $table->integer('service_base_price_percentage')->default('0');
            $table->integer('service_retail_price_percentage')->default('0');
            $table->integer('service_wholesale_price_percentage')->default('0');
            $table->float('service_stock')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('service_cost');
            $table->dropColumn('service_base_price_percentage');
            $table->dropColumn('service_retail_price_percentage');
            $table->dropColumn('service_wholesale_price_percentage');
            $table->dropColumn('service_stock');
        });
    }
}