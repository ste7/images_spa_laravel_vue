<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'image_id',
        'user_id',
    ];


    public function images() {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
