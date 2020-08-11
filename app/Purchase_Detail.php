<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Exchange;
class Purchase_Detail extends Model
{
	use softDeletes;
    
    protected $table='Purchase_Details';
     protected $dates=['deleted_at'];
    public function purchase()
    {
    	return $this->belongsTo('App\Purchase');
    }
     public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public static function exchangecurrency($cur,$curchange,$amount)
    {   

        $curex=$cur . '-' . $curchange;
        $curex1=$curchange . '-' . $cur;
        $rate=1;
        $amt=0;
        $getrate=Exchange::where('exchange_cur',$curex)->first();
        if($getrate){
            $rate=$getrate->buy;
            $amt=$amount*$rate;
            return $amt;
        }else{
            $getrate=Exchange::where('exchange_cur',$curex1)->first();
            if($getrate){
                $rate=$getrate->sale;
            }else{
                $rate=1;
            }
        }
        $amt=$amount/$rate;
        return $amt;
        
    }
}
