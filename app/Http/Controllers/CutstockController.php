<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\ProductBarcode;
use App\Supplier;
use App\Delivery;
use App\Sale;
use App\Sale_Detail;
use Carbon\Carbon;
use Validator;
use App\Category;
use App\Brand;
use App\StockProcess;
use App\Exchange;
class CutstockController extends Controller
{
     public function submititemsale(Request $request)
    {
        
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
                 DB::table('sale_details')->where('product_id',$value)->whereDate('submitdate',$submitdate)->update(['submit'=>true]);
            }else{
                $data=array('dd'=>$submitdate,
                    'user_id'=>$request->userid,
                    'product_id'=>$value,
                    'mode'=>-1,
                    'desr'=>'Stock Out',
                    'quantity'=>-1 * ($request->qty[$key] + $request->foc[$key]),
                    'unit'=>$request->unit[$key],
                    // 'amount'=>str_replace(',','',$request->amount[$key]),
                    // 'cur'=>$request->cur[$key],
                    'amount'=>str_replace(',','',$request->amountusd[$key]),
                    'cur'=>$request->pcur[$key],
                    'active'=>1,
                    'created_at'=>$current,
                    'updated_at'=>$current);
                    if($request->submit[$key]==0){
                        StockProcess::insert($data);
                        //update stock
                        $pstock=DB::table('stock_processes')->where('product_id',$value)->where('active',1)->sum('quantity');
                        DB::table('products')->where('id',$value)->update(['stock'=>$pstock]);
                        DB::table('sale_details')->where('product_id',$value)->whereDate('submitdate',$submitdate)->update(['submit'=>true]);
                        }
            }
        }
       
         
            
        return response()->json(['success'=>'Submit Items Completed.']);
        
    }
    public function delstockandsave(Request $request)
    {
            $date1 = str_replace('/', '-', $request->start_date);
            $startdate= date('Y-m-d', strtotime($date1));
            $current = Carbon::now();
            $current->timezone('Asia/Phnom_Penh');
            if(DB::table('stock_processes')->whereDate('dd',$startdate)->where('mode',-1)->delete()){
                foreach ($request->productid as $key => $value) {
                    $data=array('dd'=>$startdate,
                            'user_id'=>$request->userid,
                            'product_id'=>$value,
                            'mode'=>-1,
                            'desr'=>'Stock Out',
                            'quantity'=>-1 * ($request->qty[$key] + $request->foc[$key]),
                            'unit'=>$request->unit[$key],
                            // 'amount'=>str_replace(',','',$request->amount[$key]),
                            // 'cur'=>$request->cur[$key],
                            'amount'=>str_replace(',','',$request->amountusd[$key]),
                            'cur'=>$request->pcur[$key],
                            'active'=>1,
                            'created_at'=>$current,
                            'updated_at'=>$current);
                StockProcess::insert($data);

                //update stock
                $pstock=DB::table('stock_processes')->where('product_id',$value)->where('active',1)->sum('quantity');
                DB::table('products')->where('id',$value)->update(['stock'=>$pstock]);
                DB::table('sale_details')->where('product_id',$value)->whereDate('submitdate',$startdate)->update(['submit'=>true]);
                
                }
                return response()->json(['success'=>'Submit all item completed.']);
                
            }else{
                return response()->json(['errexist'=>'this date already submit.']);
                
            }
        
    }

     public function submitbyitem(Request $request)
    {
            //return($request->all());
            $date = str_replace('/', '-', $request->dd);
            $submitdate= date('Y-m-d', strtotime($date));

            if($request->submit==0){
                 $this->savesubmitbyitem($request);
                 return response()->json(['savesuccess'=>'Submit Completed.']);
            }else{
                DB::table('stock_processes')->whereDate('dd',$submitdate)->where('mode',-1)->where('product_id',$request->pid)->delete();
                $pstock=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->sum('quantity');
                DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock]);
                DB::table('sale_details')->where('product_id',$request->pid)->whereDate('submitdate',$submitdate)->update(['submit'=>false]);
                return response()->json(['delsuccess'=>'Remove Completed.']);
            }

            
    }

    public function delandsubmitbyitem(Request $request)
    {
         $date1 = str_replace('/', '-', $request->dd);
            $startdate= date('Y-m-d', strtotime($date1));
        if(DB::table('stock_processes')->whereDate('dd',$startdate)->where('mode',-1)->where('product_id',$request->pid)->delete()){
            $this->savesubmitbyitem($request);
            return response()->json(['success'=>'Submit Completed.']);
        }else{
            return response()->json(['error'=>'submit this item fail.']);
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
                DB::table('sale_details')->where('product_id',$request->pid)->whereDate('submitdate',$submitdate)->update(['submit'=>true]);
            }else{
                $data=array('dd'=>$submitdate,
                        'user_id'=>$request->userid,
                        'product_id'=>$request->pid,
                        'mode'=>-1,
                        'quantity'=>-1 * ($request->qty + $request->foc),
                        'unit'=>$request->unit,
                        'amount'=>str_replace(',','',$request->amountusd),
                        'cur'=>$request->pcur,
                        'desr'=>'Stock Out',
                        'active'=>1,
                        'created_at'=>$current,
                        'updated_at'=>$current);
            StockProcess::insert($data);
            //update stock
            DB::table('sale_details')->where('product_id',$request->pid)->whereDate('submitdate',$submitdate)->update(['submit'=>true]);
            $pstock=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->sum('quantity');
            DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock]);
        
            }
            
    }

    public function cutstock()
    {
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh');
        $current=date('Y-m-d',strtotime($current));   
        $categories=Category::where('active',1)->get();
        $brands=Brand::where('active',1)->get();
        $saledate=DB::table('sale_details')->select('submitdate')->distinct()->where('submit',0)->orderBy('submitdate','ASC')->get();
        $items=Product::all();
        $exchanges=Exchange::all();
        $item_sale=$this->GetSearch($current,"sales.invdate","=",$current);
        return view('stocks.cutstock',compact('categories','brands','items','saledate','item_sale','exchanges'));
    }

    public function summaryitemsale(Request $request)
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
                 $item_sale=$this->GetSearch($start_date,"sale_details.product_id","=",$barcode);
            }
            else if($request->productcode){
                $item_sale=$this->GetSearch($start_date,"sale_details.product_id","=",$request->productcode);
            }
            else if($request->category){
                $item_sale=$this->GetSearch($start_date,"categories.id","=",$request->category);
            }
            else if($request->brand){
                $item_sale=$this->GetSearch($start_date,"brands.id","=",$request->brand);
            }
            else{
                 $item_sale=$this->GetSearch($start_date,"sales.invdate","=",$start_date);
            }
        }
            return view('sales.itemsalelist',compact('item_sale'));
            //return response($items);
    }

     public function GetSearch($dd,$searchby='',$op='',$q='')
    {
        
        $item_sale=Sale_Detail::join('products','sale_details.product_id','=','products.id')
                                ->join('sales','sale_details.sale_id','=','sales.id')
                                ->join('categories','products.category_id','=','categories.id')
                                ->join('brands','products.brand_id','=','brands.id')
                                ->select(DB::raw('sum(qtyunit) as tqty,sum(focunit) as tfoc,sum(amount) as tamount,product_id,sale_details.cur as dcur,sales.invdate as saledate,sale_details.submit as submit'))
                                ->whereDate('sales.invdate','=',$dd)
                                ->where($searchby,$op,$q)
                                ->groupBy('product_id','dcur','saledate','submit')
                                ->orderBy('submit','ASC')
                                ->orderBy('categories.name','ASC')
                                ->orderBy('products.id','ASC')
                                ->get();                     
        return($item_sale);
    }

}
