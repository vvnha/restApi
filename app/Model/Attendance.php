<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function user(){
        return $this->belongsto('App\User','userID');
    }
    protected function shift(){
        return $this->belongsto('App\Model\Shift','shiftID');
    }
}