<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salecloselist extends Model
{
     public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }
     public function closelistpayment()
    {
        return $this->hasMany('App\Salecloselistpayment');
    }
    public static function getpaid($clid)
    {
    	$paid=Salecloselistpayment::where('salecloselist_id',$clid)->orderBy('id','ASC')->get();
    	return($paid);
    }
    public static function getpaid1($clid,$paydate)
    {
        $pd=date('Y-m-d',strtotime($paydate));
        $paid=Salecloselistpayment::where('salecloselist_id',$clid)->whereDate('paydate','<=',$pd)->orderBy('id','ASC')->get();
        return($paid);
    }
}
