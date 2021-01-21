<?php

use Illuminate\Database\Seeder;

class PaymentFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_form')->insert(array(
               'payment_form_name' => 'Efectivo',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));

        DB::table('payment_form')->insert(array(
               'payment_form_name' => 'Tarjeta crédito / débito',
               'created_at' => date('Y-m-d H:m:s'),
               'updated_at' => date('Y-m-d H:m:s')
        ));

        DB::table('payment_form')->insert(array(
            'payment_form_name' => 'Transferencia',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
     ));
    }
}
