<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Law extends Model
{
     public function sale()
    {
        return $this->hasMany('App\Sale');
    }
}
