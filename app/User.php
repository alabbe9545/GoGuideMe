<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function visited_attractions(){
        return $this->belongsToMany('App\Attraction', 'visited_attractions', 'user_id', 'attraction_id');
    }

    public function awards(){
        return $this->belongsToMany('App\Award', 'awards_users', 'user_id','award_id');
    }

    public function canAct($role){
        $roles = \Auth::user()->roles;

        if($roles->where('name', $role)->first() !== null) return true;
        else return false;
    }
}
