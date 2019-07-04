<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $table = 'accessories';
    protected $primaryKey = 'accessory_id';

    public function devices()
    {
    	return $this->belongsToMany('App\Device');
    }
}
