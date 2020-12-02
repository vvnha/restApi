<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SessionUser extends Model
{
    protected $table = 'sessionusers';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $fillable = [
        'token', 'refresh_token', 'token_expried', 'refresh_token_expried', 'user_id'
    ];
    protected $guarded = [];
}
