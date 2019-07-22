<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    public function sales()
    {
        return $this->belongsToMany('App\Sale', 'sales_products', 'product_id', 'sale_id');
    }
}
