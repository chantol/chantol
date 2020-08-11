<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Sale_Detail;

class Sale extends Model
{
    use softDeletes;
    protected $table="sales";
    protected $dates=['deleted_at'];
    public $timestamps=false;
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }
     public function delivery()
    {
    	return $this->belongsTo('App\Delivery');
    }
    public function sale_detail()
    {
        return $this->hasMany('App\Sale_Detail');
    }
    public function sale_payment()
    {
        return $this->hasMany('App\sale_payment');
    }
    public function law()
    {
        return $this->belongsTo('App\Law');
    }
     public static function getinvdetail($inv)
     {
         $inv_detail=Sale_Detail::where('sale_id',$inv)->orderBy('id','ASC')->get();
         return ($inv_detail);
     }
    
}
