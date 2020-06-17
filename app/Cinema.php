<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    public $fillable = ['name', 'description'];

    public function address()
    {
        return $this->hasOne('App\Address');
    }

    public function hall()
    {
        return $this->hasMany('App\Hall');
    }
}
