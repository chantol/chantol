<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sale_payment extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function sale()
    {
    	return $this->belongsTo('App\Sale');
    }
    public static function getpayment($inv)	
    {
    	$payments=sale_payment::where('sale_id',$inv)->orderBy('dd')->get();
    	return($payments);
    }
}
