<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryExit extends Model
{
    protected $table = 'inventory_exits';
    protected $primaryKey = 'inventory_exit_id';
    public $timestamps = false;
    protected $with = ['warehouse', 'products'];

    public function warehouse() {
        return $this->belongsTo('App\Warehouse', 'inventory_exit_warehouse_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'inventory_exits_products', 'inventory_exit_id', 'product_id')->withPivot('product_exit_amount', 'product_exit_justification');
    }
}
