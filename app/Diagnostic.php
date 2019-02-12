<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    protected $table = 'diagnostics';
    protected $primaryKey = 'diagnostic_id';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function device()
    {
    	return $this->belongsTo('App\Device');
    }

    public function revisions()
    {
    	return $this->hasMany('App\Revision');
    }
}
