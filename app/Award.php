<?php

namespace GoGuideMe;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    public function zone(){
    	return $this->belongsTo('GoGuideMe\Zone');
    }

    public function country(){
    	return $this->belongsTo('GoGuideMe\Country');
    }
}
