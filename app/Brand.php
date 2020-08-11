<?php

namespace App;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table="brands";
    protected $fillable=['category_id','name'];
    public function product(){
    	return $this->hasMany('App\Product');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public static function getcatbrand($catid)
    {
    	$brand=Brand::where('category_id',$catid)->orderBy('name')->get();
    	return $brand;
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
}
