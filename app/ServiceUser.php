<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceUser extends Model
{
    protected $fillable = [
        'user_id',
        'service'
    ];
}
