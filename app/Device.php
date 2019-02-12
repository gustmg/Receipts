<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    protected $primaryKey = 'device_id';

    public function receipts()
    {
    	return $this->belongsToMany('App\Receipt');
    }

    public function accesories()
    {
    	return $this->belongsToMany('App\Accesory');
    }

    public function diagnostics()
    {
    	return $this->hasMany('App\Diagnostic');
    }

    public function service_status()
    {
    	return $this->belongsTo('App\ServiceStatus');
    }
}