<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoxOffice extends Model
{
    public function film() {
        return $this->belongsTo('App\Film');
    }
}
