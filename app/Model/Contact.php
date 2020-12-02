<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'contactID';
    protected $keyType = 'integer';
    protected $guarded = [];
    protected function user(){
        return $this->belongsTo('App\Model\User','userID');
    }
}
