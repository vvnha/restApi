<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class OrderTb extends Model
{
    protected $table = 'orderTables';
    protected $primaryKey = 'orderID';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected $fillable = [
       'userID', 'total', 'orderDate', 'perNum', 'service', 'dateClick', 'created_at', 'updated_at'
    ];
    protected function user(){
        return $this->belongsTo('App\Model\User','userID');
    }
    protected function detail(){
        return $this->hasMany('App\Model\OrderDetail','orderID');
    }
    
}
