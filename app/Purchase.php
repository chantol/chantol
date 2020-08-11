<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Purchase extends Model
{
    use softDeletes;
    protected $table="purchases";
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
    public function purchase_detail()
    {
        return $this->hasMany('App\Purchase_Detail');
    }
     public function purchase_payment()
    {
        return $this->hasMany('App\Purchase_Payment');
    }
   
   
}
