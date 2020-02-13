<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    public function zone(){
    	return $this->belongsTo('App\Zone');
    }

    public function country(){
    	return $this->belongsTo('App\Country');
    }
}
