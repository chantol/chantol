<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\ProductBarcode;
use App\Supplier;
use App\Delivery;
use App\Purchase;
use App\Purchase_Detail;
use Carbon\Carbon;
use Validator;
use App\Category;
use App\Brand;
use App\StockProcess;
use App\Exchange;
class AddstockController extends Controller
{
     public function submititembuy(Request $request)
    {
        //return($request->all());
        //return response($request->all());
        //check if submit already
        $date1 = str_replace('/', '-', $request->start_date);
        $submitdate= date('Y-m-d', strtotime($date1));
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh');
        
          foreach ($request->productid as $key => $value) {
             $checkclosestock=DB::table('stock_processes')->where('product_id',$value)
                                                        ->where('mode',0)
                                                        ->where('active',1)
                                                        ->where('dd','>',$submitdate)
                                                        ->exists();
            if($checkclosestock){
                 DB::table('purchase_details')->where('product_id',$value)->whereDate('submitdate',$submitdate)->update(['submit'=>true]);
            }else{
                $data=array('dd'=>$submitdate,
                    'user_id'=>$request->userid,
                    'product_id'=>$value,
                    'mode'=>1,
                    'desr'=>'Stock In',
                    'quantity'=>$request->qty[$key] + $request->foc[$key],
                    'unit'=>$request->unit[$key],
                    'amount'=>str_replace(',','',$request->amountusd[$key]),
                    'cur'=>$request->pcur[$key],
                    'active'=>1,
                    'created_at'=>$current,
                    'updated_at'=>$current);
                    if($request->submit[$key]==0){
                        StockProcess::insert($data);
                        //update stock
                        $pstock=DB::table('stock_processes')->where('product_id',$value)->where('active',1)->sum('quantity');
                        $avgcost=DB::table('stock_processes')->where('product_id',$value)->where('active',1)->whereIn('mode',[0,1])->value(DB::raw("SUM(amount) / SUM(quantity)"));
                        
                        DB::table('products')->where('id',$value)->update(['stock'=>$pstock,'costprice'=>$avgcost]);
                        DB::table('purchase_details')->where('product_id',$value)->whereDate('submitdate',$submitdate)->update(['submit'=>true]);
                        }
                    }
            
                }

                 return response()->json(['success'=>'Submit Items Completed.']);

        }
            
       
     public function submitbyitem(Request $request)
    {
            //return($request->all());
            $date = str_replace('/', '-', $request->dd);
            $startdate= date('Y-m-d', strtotime($date));

            if($request->submit==0){
                 $this->savesubmitbyitem($request);
                 return response()->json(['savesuccess'=>'Submit Completed.']);
            }else{
                DB::table('stock_processes')->whereDate('dd',$startdate)->where('mode',1)->where('product_id',$request->pid)->delete();
                $pstock=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->sum('quantity');
                $avgcost=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->whereIn('mode',[0,1])->value(DB::raw("SUM(amount) / SUM(quantity)"));
                if(is_null($avgcost)){
                    $avgcost=0;
                }
                DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock,'costprice'=>$avgcost]);
                DB::table('purchase_details')->where('product_id',$request->pid)->whereDate('submitdate',$startdate)->update(['submit'=>false]);
                return response()->json(['delsuccess'=>'Remove Completed.']);
            }

            
    }

    
    public function savesubmitbyitem(Request $request)
    {
            $date = str_replace('/', '-', $request->dd);
            $submitdate= date('Y-m-d', strtotime($date));
            $current = Carbon::now();
            $current->timezone('Asia/Phnom_Penh');
            $checkclosestock=DB::table('stock_processes')->where('product_id',$request->pid)
                                                    ->where('mode',0)
                                                    ->where('active',1)
                                                    ->where('dd','>',$submitdate)
                                                    ->exists();
            if($checkclosestock){
                DB::table('purchase_details')->where('product_id',$request->pid)->whereDate('submitdate',$submitdate)->update(['submit'=>true]);
            }else{
                $data=array('dd'=>$submitdate,
                            'user_id'=>$request->userid,
                            'product_id'=>$request->pid,
                            'mode'=>1,
                            'quantity'=>$request->qty + $request->foc,
                            'unit'=>$request->unit,
                            'amount'=>str_replace(',','',$request->amountusd),
                            'cur'=>$request->pcur,
                            'desr'=>'Stock In',
                            'active'=>1,
                            'created_at'=>$current,
                            'updated_at'=>$current);
                StockProcess::insert($data);
                //update stock
                DB::table('purchase_details')->where('product_id',$request->pid)->whereDate('submitdate',$submitdate)->update(['submit'=>true]);
                $pstock=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->sum('quantity');
                $avgcost=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->whereIn('mode',[0,1])->value(DB::raw("SUM(amount) / SUM(quantity)"));

                DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock,'costprice'=>$avgcost]);
            }
            

    }

    public function addstock()
    {
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh'); 
        $current=date('Y-m-d',strtotime($current));  
        $categories=Category::where('active',1)->get();
        $brands=Brand::where('active',1)->get();
        $buydate=DB::table('purchase_details')->select('submitdate')->distinct()->where('submit',0)->orderBy('submitdate','ASC')->get();
        $items=Product::all();
        $exchanges=Exchange::all();
        $item_buy=$this->GetSearch($current,"purchases.invdate","=",$current);
        return view('stocks.addstock',compact('categories','brands','items','buydate','item_buy','exchanges'));
    }

    public function summaryitembuy(Request $request)
    {
        if($request->ajax()){
            $start_date=date('Y-m-d',strtotime($request->start_date));
           
            if($request->barcode){
                $getpid=DB::table('product_barcodes')->select('product_id')->where('barcode',$request->barcode)->first();
                //return response($getpid->product_id);
                if($getpid){
                    $barcode=$getpid->product_id;
                }else{
                    $barcode='';
                }
                $item_buy=$this->GetSearch($start_date,"purchase_details.product_id","=",$barcode);
            }
            else if($request->productcode){
                $item_buy=$this->GetSearch($start_date,"purchase_details.product_id","=",$request->productcode);
            }
            else if($request->category){
                $item_buy=$this->GetSearch($start_date,"categories.id","=",$request->category);
            }
            else if($request->brand){
                $item_buy=$this->GetSearch($start_date,"brands.id","=",$request->brand);
            }
            else{
                $item_buy=$this->GetSearch($start_date,"purchases.invdate","=",$start_date);
            }
        }
            return view('stocks.itembuylist',compact('item_buy'));
    }

    public function GetSearch($dd,$searchby='',$op='',$q='')
    {
        $item_buy=Purchase_Detail::join('products','purchase_details.product_id','=','products.id')
                                ->join('purchases','purchase_details.purchase_id','=','purchases.id')
                                ->join('categories','products.category_id','=','categories.id')
                                ->join('brands','products.brand_id','=','brands.id')
                                ->select(DB::raw('sum(qtyunit) as tqty,sum(focunit) as tfoc,sum(amount) as tamount,product_id,purchase_details.cur as dcur,purchases.invdate as buydate,purchase_details.submit as submit'))
                                ->whereDate('purchases.invdate','=',$dd)
                                ->where($searchby,$op,$q)
                                ->groupBy('product_id','dcur','buydate','submit')
                                ->orderBy('submit','ASC')
                                ->orderBy('categories.name','ASC')
                                ->orderBy('products.id','ASC')
                                ->get();
        return($item_buy);
    }

}
