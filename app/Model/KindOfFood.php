<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KindOfFood extends Model
{
    protected $table = 'kindoffoods';
    protected $primaryKey = 'parentID';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function food(){
        return $this->hasMany('App\Model\Foods','parentID');
    }
}
