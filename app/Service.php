<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'service_id';

    public function revisions()
    {
    	return $this->hasMany('App\Revision');
    }

    public function sales()
    {
        return $this->belongsToMany('App\Sale', 'sales_services', 'service_id', 'sale_id');
    }
}
