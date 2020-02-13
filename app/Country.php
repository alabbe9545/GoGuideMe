<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function zones(){
    	return $this->hasMany('App\Zone');
    }
}
