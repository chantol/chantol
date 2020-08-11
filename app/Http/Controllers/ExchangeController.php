<?php

namespace App\Http\Controllers;
use App\Exchange;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    public function index()
     {
      $xchange=Exchange::all();
       return view('products.exchange',compact('xchange'));
     }
     public function saveexchange(Request $request)
     {
     	//return($request->all());
     	foreach ($request->id as $key => $value) {
     				$ex=Exchange::find($value);
     				$ex->user_id=$request->userid;
     				$ex->exchange_cur=$request->excur[$key];
     				$ex->buy=$request->buy[$key];
     				$ex->sale=$request->sale[$key];
     				$ex->save();
              }  
              return response()->json(['success'=>'Update Exchange Rate Completed.']);   
     }
     public function saveexchange1(Request $request)
     {
     	//return($request->all());
     	
     				$ex=Exchange::find($request->id);
     				$ex->user_id=$request->userid;
     				$ex->buy=$request->buy;
     				$ex->sale=$request->sale;
     				$ex->save();
     				
     				return response()->json(['success'=>'Update Exchange Rate Completed.']);

                 
     }
}
