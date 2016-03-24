<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public function restaurants()
    {
        return $this->belongsToMany('App\Restaurant');
    }
}
