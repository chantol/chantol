<?php

namespace App\Http\Controllers;
use App\Expanse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Validator;
class ExpanseController extends Controller
{
    public function index()
    {
    	$current = Carbon::now();
    	$current->timezone('Asia/Phnom_Penh'); 
    	$expanses=Expanse::whereDate('dd',$current)->orderBy('id')->get();
    	$units=DB::table('expanses')->select('unit')->distinct()->get();
    	$types=DB::table('expanses')->select('type')->distinct()->get();
    	$names=DB::table('expanses')->select('name')->distinct()->get();
    	$total=DB::table('expanses')
    			->select(DB::raw('sum(qty * price) as tamount,cur'))
    			->whereDate('dd',$current)
    			->groupBy('cur')
    			->get();

    	return view('expanses.index',compact('expanses','units','types','names','total'));
    }
    public function getexpanse(Request $request)
    {
    	$d1=date('Y-m-d',strtotime($request->d1));
    	$d2=date('Y-m-d',strtotime($request->d2));
    	$total=DB::table('expanses')
    			->select(DB::raw('sum(qty * price) as tamount,cur'))
    			->whereBetween(DB::raw('DATE(dd)'), array($d1, $d2))
    			->groupBy('cur')
    			->get();
    	if($request->type==''){
    		$expanses=Expanse::whereBetween(DB::raw('DATE(dd)'), array($d1, $d2))
    					->orderBy('dd')->orderBy('id')->get();
    	}else{
    		$expanses=Expanse::whereBetween(DB::raw('DATE(dd)'), array($d1, $d2))->where('type',$request->type)
    					->orderBy('dd')->orderBy('id')->get();
    	}
    	
    	return view('expanses.expanse_list',compact('expanses','total','d1','d2'));
    }

    public function expansereportprint(Request $request)
    {
    	$d1=date('Y-m-d',strtotime($request->d1));
    	$d2=date('Y-m-d',strtotime($request->d2));
    	$total=DB::table('expanses')
    			->select(DB::raw('sum(qty * price) as tamount,cur'))
    			->whereBetween(DB::raw('DATE(dd)'), array($d1, $d2))
    			->groupBy('cur')
    			->get();
    	if($request->type==''){
    		$expanses=Expanse::whereBetween(DB::raw('DATE(dd)'), array($d1, $d2))
    					->orderBy('dd')->orderBy('id')->get();
    	}else{
    		$expanses=Expanse::whereBetween(DB::raw('DATE(dd)'), array($d1, $d2))->where('type',$request->type)
    					->orderBy('dd')->orderBy('id')->get();
    	}
    	
    	return view('expanses.expanseprint',compact('expanses','total','d1','d2'));
    }
    public function readexpanseid(Request $request)
    {
    	$exp=Expanse::find($request->id);
    	return response($exp);
    }
    public function saveexpanse(Request $request)
    {
    	 // return($request->all());
    	$validator = Validator::make($request->all(), [
        
        'name' => 'required',
        'qty'=>'required',
        'unit'=>'required',
        'price'=>'required',
        'cur'=>'required',
        
      ]);
    	 if ($validator->passes()) {
    	 	$ex=new Expanse;
    	 	$ex->type=$request->type;
    	 	$ex->user_id=$request->user_id;
    	 	$ex->dd=date('Y-m-d',strtotime($request->expdate));
    	 	$ex->name=$request->name;
    	 	$ex->qty=$request->qty;
    	 	$ex->unit=$request->unit;
    	 	$ex->price=str_replace(',','',$request->price);
    	 	$ex->cur=$request->cur;
    	 	$ex->note=$request->note;
    	 	if($ex->save()){
    	 		return response()->json(['success'=>'Save Expanse Completed.']);
    	 	}else{
    	 		return response()->json(['unsuccess'=>'Save Expanse Fail.']);
    	 	}
    	 	
    	 	
    	 }else{
    	 	return response()->json(['error'=>$validator->errors()->all()]);
    	 }
    }

    public function updateexpanse(Request $request)
    {
    	//return($request->all());
    	$validator = Validator::make($request->all(), [
        
        'name' => 'required',
        'qty'=>'required',
        'unit'=>'required',
        'price'=>'required',
        'cur'=>'required',
        
      ]);
    	 if ($validator->passes()) {
    	 	$ex=Expanse::find($request->record_id);
    	 	$ex->type=$request->type;
    	 	$ex->user_id=$request->user_id;
    	 	$ex->dd=date('Y-m-d',strtotime($request->expdate));
    	 	$ex->name=$request->name;
    	 	$ex->qty=$request->qty;
    	 	$ex->unit=$request->unit;
    	 	$ex->price=str_replace(',','',$request->price);
    	 	$ex->cur=$request->cur;
    	 	$ex->note=$request->note;
    	 	if($ex->save()){
    	 		return response()->json(['success'=>'Update Expanse Completed.']);
    	 	}else{
    	 		return response()->json(['unsuccess'=>'Update Expanse Fail.']);
    	 	}
    	 	
    	 	
    	 }else{
    	 	return response()->json(['error'=>$validator->errors()->all()]);
    	 }
    }
    public function deleteexpanse(Request $request)
    {
    	$ex=Expanse::find($request->id);
    	$ex->delete();
    }
}
