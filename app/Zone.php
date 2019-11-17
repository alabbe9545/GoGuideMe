<?php

namespace GoGuideMe;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    public function country(){
    	return $this->belongsTo('GoGuideMe\Country');
    }

    public function attractions(){
    	return $this->hasMany('GoGuideMe\Attraction');
    }
}
