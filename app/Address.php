<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false;

    public $fillable = ['longitude', 'latitude', 'street', 'phone', 'city', 'country'];

    public function cinema() {
        return $this->belongsTo('App\Cinema');
    }
}
