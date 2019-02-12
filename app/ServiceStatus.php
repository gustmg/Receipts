<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceStatus extends Model
{
    protected $table = 'service_status';
    protected $primaryKey = 'service_status_id';

    public function devices()
    {
    	return $this->hasMany('App\Device');
    }
}
