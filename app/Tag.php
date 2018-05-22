<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];


    public function images() {
        return $this->belongsToMany(Image::class);
    }
}
