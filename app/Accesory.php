<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accesory extends Model
{
    protected $table = 'accesories';
    protected $primaryKey = 'accesory_id';

    public function devices()
    {
    	return $this->belongsToMany('App\Device');
    }
}
