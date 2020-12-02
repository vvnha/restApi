<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    protected $table = 'foods';
    protected $primaryKey = 'foodID';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function kindOfFood(){
        return $this->belongsTo('App\Model\KindOfFood','parentID');
    }
    protected function detail(){
        return $this->belongsTo('App\Model\OrderDetail','foodID');
    }
}
