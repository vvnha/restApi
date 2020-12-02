<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'cmID';
    protected $keyType = 'integer';
    protected $guarded = [];
}
