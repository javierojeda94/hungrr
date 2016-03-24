<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public function menus()
    {
        return $this->hasMany('App\Menu');
    }

    public function schedules()
    {
        return $this->belongsToMany('App\Schedule');
    }

    public function owners()
    {
        return $this->belongsToMany('App\Owner');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
