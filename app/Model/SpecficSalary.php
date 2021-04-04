<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpecficSalary extends Model
{
    protected $table = 'specificSalarys';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function kindOfSalary(){
        return $this->belongsTo('App\Model\KindOfSalary','kindOfSalaryID');
    }
    protected function user(){
        return $this->belongsTo('App\User','userID');
    }
    protected function specficSalary(){
        return $this->belongsTo('App\Model\User','userID');
    }
    protected function salary(){
        return $this->hasMany('App\Model\Salary','specificSalaryID');
    }
}