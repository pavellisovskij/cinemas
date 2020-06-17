<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $timestamps = false;

    public function places() {
        return $this->belongsToMany('App\Place');
    }
}
