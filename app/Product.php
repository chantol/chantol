<?php

namespace App;
use App\Category;
use App\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
class Product extends Model
{
    use softDeletes;
    protected $dates=['deleted_at'];
    protected $table="products";
    //protected $fillable=['code','name'];
    public $timestamps=false;
    public function Category()
    {
    	return $this->belongsTo('App\Category');
    }
    public function Brand()
    {
    	return $this->belongsTo('App\Brand');
    }
    public function Barcode()
    {
    	return $this->hasMany('App\ProductBarcode');
    }
    public function getImage()
    {
        if(!$this->image){
            return asset('logo/NoPicture.jpg');
        }
        return asset('photo/'. $this->image);
    }
     public static function getcategoryname($catid)
    {
        $cats=Category::find($catid);
        if($cats){
            return $cats->name;
        }else{
            return 'N/A';
        }
        
    }
    public static function getbrandname($brid)
    {
        $brand=Brand::find($brid);
        if($brand){
            return $brand->name;
        }else{
            return 'N/A';
        }
        
    }
}
