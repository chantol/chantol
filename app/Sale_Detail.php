<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
class Sale_Detail extends Model
{
    use softDeletes;
    protected $table='sale_details';
    protected $dates=['deleted_at'];
    public $timestamps=false;
    
    public function sale()
    {
    	return $this->belongsTo('App\Sale');
    }
     public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public static function convertqtysale($pid,$qty)
    {
        $qtystr='';
        $result='';
        $somnal='0';
        $pbarcode=ProductBarcode::where('product_id',$pid)->orderBy('multiple','DESC')->get();
        foreach ($pbarcode as $key => $pb) {
            if($key==0){
                $result=intdiv((float)$qty, (float)$pb->multiple);
                $somnal=(float)$qty % (float)$pb->multiple;
            }else{
                $result=intdiv((float)$somnal, (float)$pb->multiple);
                $somnal=(float)$somnal % (float)$pb->multiple;
            }
            if($result<>0){
                $qtystr .=$result . $pb->unit;
            }
            if ($somnal==0) {
                return $qtystr;
            }
            $key++;
        }
        return $qtystr;
    }

     public static function convertqtysale1($pid,$qty)
    {
        $qtystr='';
        $result='';
        $somnal='0';
        $pbarcode=ProductBarcode::where('product_id',$pid)->orderBy('multiple','DESC')->get();
        foreach ($pbarcode as $key => $pb) {
            if($key==0){
                $result=intdiv((float)$qty, (float)$pb->multiple);
                $somnal=(float)$qty % (float)$pb->multiple;
            }else{
                $result=intdiv((float)$somnal, (float)$pb->multiple);
                $somnal=(float)$somnal % (float)$pb->multiple;
            }
            if ($key>0) {
               $qtystr .=';'.$result . $pb->unit;
            }else{
                $qtystr .=$result . $pb->unit;
            }
            
            $key++;
        }
        echo $qtystr;
        return $qtystr;
    }
}
