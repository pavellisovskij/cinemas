<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    public function cinema() {
        return $this->belongsTo('App\Cinema');
    }

    public function films() {
        return $this->belongsToMany('App\Film');
    }
}
