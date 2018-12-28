<?php

use Illuminate\Database\Seeder;

class AuthorizationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authorization_status')->insert(array(
               'authorization_status_name' => 'Por autorizar',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('authorization_status')->insert(array(
               'authorization_status_name' => 'Autorizado',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('authorization_status')->insert(array(
               'authorization_status_name' => 'No autorizado',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));
    }
}
