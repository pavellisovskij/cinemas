<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public $timestamps = false;

    public function options() {
        return $this->belongsToMany('App\Option');
    }
}
