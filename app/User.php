<?php

namespace App;

use JWTAuth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function user() {
        return JWTAuth::parseToken()->authenticate();
    }


    public function exists($email) {
        return User::where('email', $email)->first();
    }

    public function service($service) {
        return $this->hasOne(ServiceUser::class)->where('service', $service);
    }


    public function images() {
        return $this->hasMany(Image::class, 'user_id');
    }

    public function didILike($id) {
        return $this->hasMany(Like::class)->where('image_id', $id)->first();
    }


    public function likes() {
        return $this->hasMany(Like::class);
    }


    public function myLikes() {
        $user = JWTAuth::parseToken()->authenticate();

        return $this->hasMany(Like::class)->where('user_id', $user->id);
    }
}
