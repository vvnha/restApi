<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'orderDetails';
    protected $primaryKey = 'detailID';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function order(){
        return $this->belongsTo('App\Model\OrderTb','orderID');
    }
    protected function food(){
        return $this->hasOne('App\Model\Foods','foodID');
    }
}
