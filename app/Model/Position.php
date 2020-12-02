<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';
    protected $primaryKey = 'positionID';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function user(){
        return $this->hasMany('App\Model\User','positionID');
    }
}
