<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function sections()
    {
        return $this->hasMany('App\Section');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
