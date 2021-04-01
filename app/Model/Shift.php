<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shifts';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function attendance(){
        return $this->hasMany('App\Model\Attendance','shiftID');
    }
}