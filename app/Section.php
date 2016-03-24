<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }

    public function elements()
    {
        return $this->hasMany('App\Element');
    }
}
