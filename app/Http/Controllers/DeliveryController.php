<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Delivery;
use App\Law;
use DB;
use Validator;
use Carbon\Carbon;
class DeliveryController extends Controller
{
    
    public function deliveryregister()
    {
    	$deliveries=Delivery::where('active',1)->orderBy('id','DESC')->get();
      	$laws=Law::where('active',1)->orderBy('id','DESC')->get();
    	return view('deliveries.index',compact('deliveries','laws'));
    }
    public function savedelivery(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            
            'dev_name' => 'required',
            'dev_active' => 'required',
            
        ]);
    	if ($validator->passes()) {
    		$newdev=new Delivery;
	    	$newdev->name=$request->dev_name;
	    	$newdev->active=$request->dev_active;
	    	$newdev->tel=$request->tel;
	    	$newdev->email=$request->email;
	    	$newdev->address=$request->address;
	    	$newdev->save();
	    	return response()->json(['success'=>'Save Delivery Completed.']);
    	}
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
    
    public function updatedelivery(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'dev_name' => 'required',
            'dev_active' => 'required',
        ]);
    	if ($validator->passes()) {
    		$dev=Delivery::find($request->dev_id);
	    	$dev->name=$request->dev_name;
	    	$dev->active=$request->dev_active;
	    	$dev->tel=$request->tel;
	    	$dev->email=$request->email;
	    	$dev->address=$request->address;
	    	$dev->save();
	    	return response()->json(['success'=>'Update Delivery Completed.']);
    	}
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
    
    public function deldelivery(Request $request)
    {
    	$current = Carbon::now();
      	$current->timezone('Asia/Phnom_Penh');
    	$devsale=DB::table('sales')->where('delivery_id',$request->id)->exists();
    	if($devsale){
    		DB::table('deliveries')->where('id',$request->id)->update(['active'=>'-1','updated_at'=>$current]);
    	}else{
    		if($request->active==-1){
    			$dev=Delivery::find($request->id);
    			$dev->delete();
    		}else{
    			DB::table('deliveries')->where('id',$request->id)->update(['active'=>'-1','updated_at'=>$current]);
    		}
    	}
    }
    
     public function restoredelivery(Request $request)
    {
    	$current = Carbon::now();
      	$current->timezone('Asia/Phnom_Penh');
    	DB::table('deliveries')->where('id',$request->id)->update(['active'=>'1','updated_at'=>$current]);
    }
    
    public function getdelivery(Request $request)
    {
    	if($request->active==2){
    		$deliveries=Delivery::whereIn('active',['0','1'])->orderBy('id','DESC')->get();
    	}else{
    		$deliveries=Delivery::where('active',$request->active)->orderBy('id','DESC')->get();
    	}
   		
   		return view('deliveries.delivery-list',compact('deliveries'));
   		
    }
    
    // -----------------CO function----------------------//

     public function saveco(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            
            'co_name' => 'required',
            'co_active' => 'required',
            
        ]);
    	if ($validator->passes()) {
    		$newco=new Law;
	    	$newco->name=$request->co_name;
	    	$newco->active=$request->co_active;
	    	$newco->tel=$request->co_tel;
	    	$newco->email=$request->co_email;
	    	$newco->address=$request->co_address;
	    	$newco->save();
	    	return response()->json(['success'=>'Save CO Completed.']);
    	}
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
    
    public function updateco(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            
            'co_name' => 'required',
            'co_active' => 'required',
            
        ]);
    	if ($validator->passes()) {
    		$upco=Law::find($request->co_id);
	    	$upco->name=$request->co_name;
	    	$upco->active=$request->co_active;
	    	$upco->tel=$request->co_tel;
	    	$upco->email=$request->co_email;
	    	$upco->address=$request->co_address;
	    	$upco->save();
	    	return response()->json(['success'=>'Update CO Completed.']);
    	}
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
    
    public function delco(Request $request)
    {
    	$current = Carbon::now();
      	$current->timezone('Asia/Phnom_Penh');
    	$devsale=DB::table('sales')->where('law_id',$request->id)->exists();
    	if($devsale){
    		DB::table('laws')->where('id',$request->id)->update(['active'=>'-1','updated_at'=>$current]);
    	}else{
    		if($request->active==-1){
    			$dev=Law::find($request->id);
    			$dev->delete();
    		}else{
    			DB::table('laws')->where('id',$request->id)->update(['active'=>'-1','updated_at'=>$current]);
    		}
    	}
    }
    
     public function restoreco(Request $request)
    {
    	$current = Carbon::now();
      	$current->timezone('Asia/Phnom_Penh');
    	DB::table('laws')->where('id',$request->id)->update(['active'=>'1','updated_at'=>$current]);
    }
    
    public function getco(Request $request)
    {
    	if($request->active==2){
    		$laws=Law::whereIn('active',['0','1'])->orderBy('id','DESC')->get();
    	}else{
    		$laws=Law::where('active',$request->active)->orderBy('id','DESC')->get();
    	}
   		
   		return view('deliveries.co-list',compact('laws'));
   		
    }
       
}
