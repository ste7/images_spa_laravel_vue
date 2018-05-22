<?php

namespace App;

use JWTAuth;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'path',
        'user_id'
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }


    public function likes() {
        return $this->hasMany(Like::class);
    }


    public function myLike() {
        $user = JWTAuth::parseToken()->authenticate();

        return $this->hasMany(Like::class)->where('user_id', $user->id);
    }


    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
