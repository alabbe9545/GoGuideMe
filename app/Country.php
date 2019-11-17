<?php

namespace GoGuideMe;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function zones(){
    	return $this->hasMany('GoGuideMe\Zone');
    }
}
