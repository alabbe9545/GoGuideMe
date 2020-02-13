<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    public function country(){
    	return $this->belongsTo('App\Country');
    }

    public function attractions(){
    	return $this->hasMany('App\Attraction');
    }
}
