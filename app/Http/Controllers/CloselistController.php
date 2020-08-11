<?php

namespace App\Http\Controllers;
use App\Salecloselist;
use App\Salecloselistpayment;
use Illuminate\Http\Request;
use DB;
class CloselistController extends Controller
{
    public function closereport(Request $request)
    {
    	$d1=date('Y-m-d',strtotime($request->d1));
    	$d2=date('Y-m-d',strtotime($request->d2));
    	$tcls=DB::table('salecloselists')
    					->select(DB::raw('sum(total) as t_total,sum(deposit) as t_deposit,cur'))
    					->whereDate('d1',$d1)->whereDate('d2',$d2)
    					->groupBy('cur')
    					->get();
    	$closelists=Salecloselist::whereDate('d1',$d1)->whereDate('d2',$d2)->orderBy('cur')->orderBy('id')->get();
    	if($closelists && count($closelists)>0){
    		if($request->dt){
    			return view('closelists.viewclosereport1',compact('closelists','tcls'));
    		}else{
    			return view('closelists.viewclosereport',compact('closelists'));
    		}
    		
    	}else{
    		return response()->json(['error'=>'no customer list found.']);
    	}
    	
    }
    public function showreportpay(Request $request)
    {
    	$pd=date('Y-m-d',strtotime($request->paydate));
    	$text=['paydate'=>$request->paydate];
    	
    	$totalpay=DB::table('salecloselistpayments')->select(DB::raw('sum(payamt) as tpay,cur'))
    												->where('paydate',$pd)
    												->groupBy('cur')
    												->get();
    	$paylists=Salecloselistpayment::where('paydate',$pd)->orderBy('id','ASC')->get();
    	if($paylists && count($paylists)>0){
    		return view('closelists.viewclosepaymentreport',compact('totalpay','paylists','text'));
    	}else{
    		return response()->json(['error'=>'no customer list found.']);
    	}
    }

   public function showreportpay1(Request $request)
    {
    	$pd=date('Y-m-d',strtotime($request->paydate));
    	$text=['paydate'=>$request->paydate];
    	
    	$totalpay=DB::table('salecloselistpayments')->select(DB::raw('sum(payamt) as tpay,cur'))
    												->where('paydate',$pd)
    												->groupBy('cur')
    												->get();
    	$paylists=Salecloselistpayment::where('paydate',$pd)->orderBy('id','ASC')->get();
    	if($paylists && count($paylists)>0){
    		return view('closelists.viewclosepaymentreport1',compact('totalpay','paylists','text'));
    	}else{
    		return response()->json(['error'=>'no customer list found.']);
    	}
    }
}
