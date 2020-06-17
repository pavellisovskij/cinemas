<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public $timestamps = false;

    public function film() {
        return $this->belongsToMany('App\Film');
    }
}
