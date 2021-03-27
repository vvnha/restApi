<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KindOfSalary extends Model
{
    protected $table = 'kindOfSalarys';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function salary(){
        return $this->hasMany('App\Model\SpecficSalary','kindOfSalaryID');
    }
}