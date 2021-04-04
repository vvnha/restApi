<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EatTime extends Model
{
    protected $table = 'eatTimes';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function order(){
        return $this->belongsto('App\Model\OrderTb','orderID');
    }
}