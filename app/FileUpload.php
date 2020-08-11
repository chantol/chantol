<?php

namespace App;
use Image;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
       public static function uploadphoto($request,$fileName,$folderpath,$default="")
    {
    	
    	if($request->hasFile($fileName)){

	        $image=$request->file($fileName);
	        $img=time().'.'. $image->getClientOriginalExtension();
	        $location=public_path('logo/'.$img);
	        Image::make($image)->save($location);

	         return $img;
	        
      }else{
      	
      	return '';
      }

    }
}
