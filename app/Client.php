<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'client_id';

    public function receipts()
    {
    	return $this->hasMany('App\Receipt');
    }
}
