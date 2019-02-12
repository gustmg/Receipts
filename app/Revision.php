<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = 'revisions';
    protected $primaryKey = 'revision_id';

    public function service()
    {
    	return $this->belongsTo('App\Service');
    }

    public function authorization_status()
    {
    	return $this->belongsTo('App\AuthorizationStatus');
    }

    public function diagnostic()
    {
    	return $this->belongsTo('App\Diagnostic');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
