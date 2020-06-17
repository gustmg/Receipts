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

    public function inventory_entries() {
        return $this->belongsToMany('App\InventoryEntry', 'inventory_entries_products', 'product_id', 'inventory_entry_id');
    }

    public function inventory_exits() {
        return $this->belongsToMany('App\InventoryExit', 'inventory_exits_products', 'product_id', 'inventory_exit_id');
    }
}
