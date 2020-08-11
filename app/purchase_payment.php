<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_payment extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function purchase()
    {
    	return $this->belongsTo('App\Purchase');
    }
}
