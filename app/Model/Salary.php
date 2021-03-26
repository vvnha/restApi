<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salarys';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function specficSalary(){
        return $this->belongsTo('App\Model\SpecficSalary','specificSalaryID');
    }
}