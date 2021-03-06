<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    protected $primaryKey = 'device_id';
    protected $with = ['accessories'];

    public function receipts()
    {
    	return $this->belongsToMany('App\Receipt');
    }

    public function accessories()
    {
    	return $this->hasMany('App\Accessory', 'accessory_device_id');
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