<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryEntry extends Model
{
    protected $table = 'inventory_entries';
    protected $primaryKey = 'inventory_entry_id';
    public $timestamps = false;
    protected $with = ['warehouse', 'products'];

    public function warehouse() {
        return $this->belongsTo('App\Warehouse', 'inventory_entry_warehouse_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'inventory_entries_products', 'inventory_entry_id', 'product_id')->withPivot('product_entry_amount', 'product_unit_cost');
    }
}
