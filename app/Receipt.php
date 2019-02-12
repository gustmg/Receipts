<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipts';
    protected $primaryKey = 'receipt_id';

    public function client()
    {
    	return $this->belongsTo('App\Client');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function receipts()
    {
    	return $this->belongsToMany('App\Receipt');
    }
}
