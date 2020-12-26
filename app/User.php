<?php

namespace App;

use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone','password', 'positionID'
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
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    protected function position(){
        return $this->belongsTo('App\Model\Position','positionID');
    }
    protected function contact(){
        return $this->hasMany('App\Model\Contact','userID');
    }
    protected function orderTable(){
        return $this->hasMany('App\Model\OrderTb','userID');
    }
    protected function foodList(){
        return $this->hasManyThrough('App\Model\OrderDetail','App\Model\OrderTb','userID','orderID','id');
    }
}
