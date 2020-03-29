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

    public function users(){
        return $this->belongsToMany('App\User', 'awards_users', 'award_id', 'user_id');
    }
}
