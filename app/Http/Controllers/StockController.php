<?php

namespace App\Http\Controllers;
use App\Category;
use App\Brand;
use App\Product;
use App\StockProcess;
use DB;
use Validator;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
    	$cats=Category::where('active',1)->get();
        $brands=Brand::where('active',1)->get();
        $stocks=Product::all();
        //$stockdate=DB::table('stock_processes')->select('dd')->distinct()->orderBy('dd','desc')->take(30)->get();
        $totalstock=DB::table('products')->select(DB::raw('sum(stock * costprice) as tstock,cur'))
                        ->whereNull('deleted_at')
        								->groupBy('cur')->get();
		//dump($totalstock);       								
    	return view('stocks.stockinfo',compact('cats','brands','stocks','totalstock'));
	}
	public function stockhistory()
    {
    	$stocks=Product::all();
    	$cats=Category::where('active',1)->get();
      $brands=Brand::where('active',1)->get();
      $stockdate=DB::table('stock_processes')->select(DB::raw('Date(dd) as dd'))->distinct()->orderBy('dd','DESC')->get();  
      //dump($stockdate);								
    	return view('stocks.stockhistory',compact('cats','brands','stockdate','stocks'));
	}
	public function searchmain(Request $request)
	{
		
		if($request->category){
			$stocks=Product::where('category_id',$request->category)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(stock * costprice) as tstock,cur'))
										->where('category_id',$request->category)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();
		}else if($request->brand){
			$stocks=Product::where('brand_id',$request->brand)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(stock * costprice) as tstock,cur'))
										->where('brand_id',$request->brand)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();
		}else if($request->item){
			$stocks=Product::where('id',$request->item)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(stock * costprice) as tstock,cur'))
										->where('id',$request->item)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();
		}else if($request->barcode){
			$getpid=DB::table('product_barcodes')->select('product_id')->where('barcode',$request->barcode)->first();
			
			$stocks=Product::where('id',$getpid->product_id)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(stock * costprice) as tstock,cur'))
										->where('id',$getpid->product_id)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();
			
		}else if($request->productcode){
			$stocks=Product::where('code',$request->productcode)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(stock * costprice) as tstock,cur'))
										->where('code',$request->productcode)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();
		}else{
			$stocks=Product::all();
			$totalstock=DB::table('products')->select(DB::raw('sum(stock * costprice) as tstock,cur'))
                        ->whereNull('deleted_at')
        								->groupBy('cur')->get();
		}
		
        return view('stocks.stocklist',compact('stocks','totalstock'));

	}
	public function search(Request $request)
	{
		$this->UpdateStockSearch($request);
		if($request->category){
			$stocks=Product::where('category_id',$request->category)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(amount1) as tstock,cur'))
										->where('category_id',$request->category)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();
		}else if($request->brand){
			$stocks=Product::where('brand_id',$request->brand)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(amount1) as tstock,cur'))
										->where('brand_id',$request->brand)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();
		}else if($request->item){
			$stocks=Product::where('id',$request->item)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(amount1) as tstock,cur'))
										->where('id',$request->item)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();

		}else if($request->barcode){
			$getpid=DB::table('product_barcodes')->select('product_id')->where('barcode',$request->barcode)->first();
			//return response($getpid->product_id);
			$stocks=Product::where('id',$getpid->product_id)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(amount1) as tstock,cur'))
										->where('id',$getpid->product_id)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();
     	}else if($request->productcode){
			$stocks=Product::where('code',$request->productcode)->get();
			$totalstock=DB::table('products')->select(DB::raw('sum(amount1) as tstock,cur'))
										->where('code',$request->productcode)
                    ->whereNull('deleted_at')
        						->groupBy('cur')->get();
		
		}else{
			$stocks=Product::all();
			$totalstock=DB::table('products')->select(DB::raw('sum(amount1) as tstock,cur'))
                        ->whereNull('deleted_at')
        								->groupBy('cur')->get();
		}
		
        return view('stocks.stocklistsearch',compact('stocks','totalstock'));

	}
	public function UpdateStockSearch(Request $request)
	{
		if($request->ajax()){
            $search_date=date('Y-m-d',strtotime($request->choosedate));
            if($request->category){
            	$products=Product::where('category_id',$request->category)->get();
            }else if($request->brand){
            	$products=Product::where('brand_id',$request->brand)->get();
            }else if($request->item){
            	$products=Product::where('id',$request->item)->get();
            }else if($request->barcode){
            	$getpid=DB::table('product_barcodes')->select('product_id')->where('barcode',$request->barcode)->first();
				$products=Product::where('id',$getpid->product_id)->get();
            }else if($request->productcode){
            	$products=Product::where('code',$request->productcode)->get();
            }else{
            	$products=Product::all();
            }
            $avgcost=0;
            $mystock=0;
            foreach ($products as $key => $p) {
            	$cost=DB::table('stock_processes')
            			->select(DB::raw('sum(amount)/sum(quantity) as costprice'))
           				->whereDate('dd','<=',$search_date)
           				->where('product_id',$p->id)
           				->whereIn('mode',[0,1])
                  ->where('active',1)
           				->get();
           		if($cost[0]->costprice){
           			$avgcost=$cost[0]->costprice;
           		}else{
           			$avgcost=0;
           		}
           		$stock=DB::table('stock_processes')
            			->select(DB::raw('sum(quantity) as stockleft'))
           				->whereDate('dd','<=',$search_date)
           				->where('product_id',$p->id)
                  ->where('active',1)
           				->get();
           		if($stock[0]->stockleft){
           			$mystock=$stock[0]->stockleft;
           		}else{
           			$mystock=0;
           		}
           		$amountstock= $mystock * $avgcost;
           		
           		DB::table('products')->where('id',$p->id)->update(['stockdate'=>$search_date,'stock1'=>$mystock,'amount1'=>$amountstock]);
            }
		}
	}
	public function showstockproccess(Request $request)
	{
		$date=date('Y-m-d',strtotime($request->showdate));
		$stockprocess=StockProcess::whereDate('dd','<=',$date)
                              ->where('product_id',$request->pid)
                              ->where('active',1)
                              ->orderBy('dd','ASC')
                              ->orderBy('id','ASC')
                              ->get();
    //return($stockprocess);
		return view('stocks.stockprocesslist',compact('stockprocess'));
	}
	public function removestockprocess(Request $request)
	{
      //return($request->all());
        $dd=date('Y-m-d',strtotime($request->dd));
		    DB::table('stock_processes')
                                    ->where('id',$request->id)
                                    ->where('product_id',$request->pid)
                                    ->delete();
        if($request->mode==0){
          //reset item close stock to active
          DB::table('stock_processes')->where('closeid',$request->id)->where('product_id',$request->pid)
                                      ->update(['active'=>1,'closeid'=>0]);
          DB::table('sale_details')->where('closestock_id',$request->id)->where('product_id',$request->pid)->update(['submit'=>0,'closestock_id'=>0]);
          DB::table('purchase_details')->where('closestock_id',$request->id)->where('product_id',$request->pid)->update(['submit'=>0,'closestock_id'=>0]);
        }

        $pstock=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->sum('quantity');
        $avgcost=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->whereIn('mode',[0,1])->value(DB::raw("SUM(amount) / SUM(quantity)"));
       
        if(is_null($avgcost)){
            $avgcost=0;
        }
        
		    if($request->mode==-1){
            DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock]);
            DB::table('sale_details')->where('product_id',$request->pid)->whereDate('submitdate',$dd)->update(['submit'=>false]);
            return response()->json(['success'=>'Remove Completed.']);
        }else if($request->mode==1){
           
            DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock,'costprice'=>$avgcost]);
            DB::table('purchase_details')->where('product_id',$request->pid)->whereDate('submitdate',$dd)->update(['submit'=>false]);
            return response()->json(['success'=>'Remove Completed.']);
        }else{

            DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock,'costprice'=>$avgcost]);
            return response()->json(['success'=>'Remove Completed.']);
        }

	}
  public function saveclosestock(Request $request)
  {
    //return($request->all());
     $validator = Validator::make($request->all(), [
            'stockqty' => 'required|numeric',
            'cost' => 'required',
        ]);

    $strmode='';
    if($request->job==0){
      $strmode='Close Stock';
    }else if($request->job==2){
      $strmode='Adjust Stock';
    }
    $closedate=date('Y-m-d',strtotime($request->closedate));

    // $exists_sale=DB::table('sales')->join('sale_details','sales.id','=','sale_details.sale_id')
    //                             ->whereDate('sales.invdate','<=',$closedate)
    //                             ->whereNull('sales.deleted_at')
    //                             ->where('sale_details.submit',0)
    //                             ->whereNull('sale_details.deleted_at')
    //                             ->exists();
    // if($exists_sale){
    //   return response()->json(['ext'=>'there are sold items not yet submit.']);
    // }
    // $exists_buy=DB::table('purchases')->join('purchase_details','purchases.id','=','purchase_details.purchase_id')
    //                             ->whereDate('purchases.invdate','<=',$closedate)
    //                             ->whereNull('purchases.deleted_at')
    //                             ->where('purchase_details.submit',0)
    //                             ->whereNull('purchase_details.deleted_at')
    //                             ->exists();
    // if($exists_buy){
    //   return response()->json(['ext'=>'there are bought items not yet submit.']);
    // }                        

    if ($validator->passes()) {
        
        $ss=new StockProcess;
        $ss->dd=$closedate;
        $ss->user_id=$request->user_id;
        $ss->product_id=$request->pid;
        $ss->mode=$request->job;
        $ss->desr=$strmode;
        $ss->quantity=$request->stockqty;
        $ss->unit=$request->unit;
        $ss->amount=(float) $request->stockqty * (float) str_replace(',','',$request->cost);
        $ss->cur=$request->cur;
        $ss->active=1;
        if($ss->save()){
          $id=$ss->id;
          if($request->job==0){
            DB::table('stock_processes')->where('dd','<=',$closedate)
                                        ->where('id','<',$id)
                                        ->where('active',1)
                                        ->where('product_id',$request->pid)
                                        ->update(['active'=>'0','closeid'=>$id]);
            DB::table('sale_details')->where('submitdate','<=',$closedate)
                                     ->where('product_id',$request->pid)
                                     ->where('submit',0)
                                     ->update(['submit'=>1,'closestock_id'=>$id]);
            DB::table('purchase_details')->where('submitdate','<=',$closedate)
                                     ->where('product_id',$request->pid)
                                     ->where('submit',0)
                                     ->update(['submit'=>1,'closestock_id'=>$id]);

          }
           $pstock=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->sum('quantity');
           $avgcost=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->whereIn('mode',[0,1])->value(DB::raw("SUM(amount) / SUM(quantity)"));
           
            if(is_null($avgcost)){
                $avgcost=0;
            }
            DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock,'costprice'=>$avgcost]);
            return response()->json(['success'=>'Save Completed.']);
        }
     }else{
        return response()->json(['error'=>$validator->errors()->all()]);
     }

    

  }




}