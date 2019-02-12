<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorizationStatus extends Model
{
    protected $table = 'authorization_status';
    protected $primaryKey = 'authorization_status_id';

    public function revision()
    {
    	return $this->belongsTo('App\Revision');
    }
}
