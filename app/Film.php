<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function box_office() {
        return $this->hasOne('App\BoxOffice');
    }

    public function halls() {
        return $this->belongsToMany('App\Hall');
    }

    public function sessions() {
        return $this->hasMany('App\Session');
    }
}
