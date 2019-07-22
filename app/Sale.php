<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'sale_id';
    protected $with = ['client', 'user', 'payment_form', 'products', 'services'];

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

    public function products()
    {
        return $this->belongsToMany('App\Product', 'sales_products', 'sale_id', 'product_id')->withPivot('product_quantity', 'product_unit_price');
    }

    public function services()
    {
        return $this->belongsToMany('App\Service', 'sales_services', 'sale_id', 'service_id')->withPivot('service_quantity', 'service_unit_price');
    }
}
