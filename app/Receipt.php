<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipts';
    protected $primaryKey = 'receipt_id';
    protected $with = ['client', 'user', 'devices'];

    public function client()
    {
    	return $this->belongsTo('App\Client', 'receipt_client_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'receipt_worker_id');
    }

    public function devices()
    {
        return $this->hasMany('App\Device', 'device_receipt_id');
    }
}
