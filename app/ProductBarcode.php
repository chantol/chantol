<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBarcode extends Model
{
	
	protected $table="product_barcodes";
    public function Product()
    {
    	return $this->belongsTo('App\Product');
    }
}
