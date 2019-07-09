<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'sale_id';

    public function client()
    {
        return $this->belongsTo('App\Client', 'sale_client_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'sale_worker_id');
    }

    public function payment_form()
    {
        return $this->belongsTo('App\PaymentForm', 'sale_payment_form_id');
    }
}
