<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    public function section()
    {
        return $this->belongsTo('App\Section');
    }
}
