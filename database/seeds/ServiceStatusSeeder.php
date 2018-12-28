<?php

use Illuminate\Database\Seeder;

class ServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_status')->insert(array(
               'service_status_name' => 'Sin diagnosticar',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('service_status')->insert(array(
               'service_status_name' => 'En diagnóstico',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('service_status')->insert(array(
               'service_status_name' => 'Diagnosticado',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('service_status')->insert(array(
               'service_status_name' => 'En reparación',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('service_status')->insert(array(
               'service_status_name' => 'En almacén',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('service_status')->insert(array(
               'service_status_name' => 'Entregado',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));
    }
}
