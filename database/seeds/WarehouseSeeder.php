<?php

use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouses')->insert(array(
            'warehouse_name' => 'Almacén principal',
            'warehouse_address' => 'Calle Encino #1-A, Sta Cruz Buenavista. Puebla, Pue.',
            'warehouse_phone' => '2227853012',
        ));

    }
}
