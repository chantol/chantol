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
use App\sale_payment;
use App\Law;
use App\Exchange;
use App\Salecloselist;
use App\Salecloselistpayment;
use App\Company;
class SaleController extends Controller
{
    public function getbuyinvtotal(Request $request)
    {
        $buytotal=DB::table('purchases')->select('total','cur')
                                        ->where('id',$request->buyinv)
                                        ->get();
        return response($buytotal);
    }
    public function getcostfrombuyinv(Request $request)
    {
        $cost=DB::table('purchase_details')->select(DB::raw('(amount/qty) as buycost,cur'))
                                            ->where('purchase_id',$request->buyinv)
                                            ->where('product_id',$request->pid)
                                            ->get();
        return($cost);
    }
    public function getbuyinv(Request $request)
    {
        $buyinv=DB::table('purchases')->select('id')->where('supplier_id',$request->supid)->orderBy('id','DESC')->take(10)->get();
        return response($buyinv);
    }
    public function printallcustomerdebtinvoice()
    {
        $invs=Sale::whereColumn('deposit','<','total')
                    ->where('close','0')
                    ->orderBy('supplier_id')
                    ->orderBy('id')
                    ->get();
        $totalall=DB::table('sales')
                    ->select(DB::raw('sum(total-deposit) as tdebt,cur'))
                    ->where('close','0')
                    ->whereColumn('deposit','<','total')
                    ->groupBy('cur')
                    ->get();
        return view('sales.alldebtinv',compact('invs','totalall'));
    }
    public function getcusvalue(Request $request)
    {
        $cus=Supplier::where('id',$request->id)->first();
        return response($cus);
    }
    public function readcustomerdebtname(Request $request)
    {
           // return($request->all());
        $output='';
        // $customers=Sale::join('suppliers','sales.supplier_id','=','suppliers.id')
        //                 ->where('sales.close',0)
        //                 ->where('sales.balance','>',0)
        //                 ->where('suppliers.name_slug','like','%'. preg_replace('/\s+/', '', $request->q) .'%')
        //                 ->select('supplier_id')->distinct()->get();
        $customers=supplier::where('name_slug','like','%'. preg_replace('/\s+/', '', $request->q) .'%')->where('type',1)->get();
        
        foreach ($customers as $key => $cus) {
            $output .='<tr>
                           <td style="width:auto;">'. ++$key .'</td>
                           <td style="padding:0px;"><a href="#" class="btn btn-default cusname" style="height:40px;width:100%;text-align:left;font-family:khmer os content;padding-top:10px;" data-id="'. $cus->id .'" data-cname="'. $cus->name .'">'. $cus->name .'</a></td>
                       </tr>';
        }
        if($output==''){
            $output='<tr><td colspan=2>not found</td></tr>';
        }
        return response($output);
    }
    public function accountreceive(Request $request)
    {
        $invoices=Sale::where('close',-1)
        ->where('balance','>',0)
        ->orderBy('id','asc')
        ->get();
        $customers=Sale::where('close',0)->where('balance','>',0)->select('supplier_id')->distinct()->get();
        return view('sales.accountreceive',compact('customers','invoices'));
    }
    public function searchitemcode(Request $request)
    {
        //return($request->all());
        $pid=Product::where('code',$request->code)->select('id')->get();
        //return ($pid);
        if(count($pid)===0){
            //or use count($pid)===0
            //isset($pid) && count($pid) > 0
            $pid=Product::join('product_barcodes','products.id','=','product_barcodes.product_id')
            ->where('product_barcodes.barcode',$request->code)
            ->select('products.id as id','product_barcodes.id as bcid')
            ->get();
            //return($pid[0]->id);
        }
        if(count($pid)>0){
            $ic=DB::table('products')
                ->join('product_barcodes','products.id','=','product_barcodes.product_id')
                ->where('products.id',$pid[0]->id)
                ->orderBy('product_barcodes.id','ASC')
                ->get();
            return response($ic);
        }
    }

    public function closesaleinvoicereport()
    {
        return view('closelists.closesalereport');
    }
    public function savecloselist(Request $request)
    {
        //return ($request->all());

        $validator = Validator::make($request->all(), [
            'cusid' => 'required',
        ]);

        $d1=date('Y-m-d',strtotime($request->start_date));
        $d2=date('Y-m-d',strtotime($request->end_date));
        $d1d2=$request->start_date . '_' . $request->end_date;
        $dodate=date('Y-m-d',strtotime($request->dodate));
        $cur=$request->icur;
        if ($validator->passes()) {
            $scl=new Salecloselist;
            $scl->dd=$dodate;
            $scl->user_id=$request->userid;
            $scl->supplier_id=$request->cusid;
            $scl->d1=$d1;
            $scl->d2=$d2;
            $scl->d1d2=$d1d2;
            $scl->ivamount=str_replace(',','',str_replace($cur,'',$request->inv_total));
            $scl->ivdeposit=str_replace(',','',str_replace($cur,'',$request->inv_deposit));
            $scl->ivbalance=str_replace(',','',str_replace($cur,'',$request->inv_bal));
            $scl->oldlist=str_replace(',','',str_replace($cur,'',$request->old_debt));
            $scl->total=str_replace(',','',str_replace($cur,'',$request->newbalance));
            $scl->deposit=0;
            
            $scl->cur=$cur;
            $scl->islast=1;
            if($scl->save()){
                $closeid=$scl->id;
                DB::table('salecloselists')->where('id','<>',$closeid)->where('supplier_id',$request->cusid)->where('cur',$cur)->update(['islast'=>0]);
                if(isset($request->invnum)){
                    foreach ($request->invnum as $key => $value) {
                        DB::table('sales')->where('id',$value)->update(['close'=>$closeid]);
                    }
                }
                
                    return response()->json(['success'=>'Close List Completed.']);
            }
        }
        return response()->json(['error'=>'Save list not allow.']);
    }
        
    public function savecloselistpaid(Request $request)
    {
        //return($request->all());
        $validator = Validator::make($request->all(), [
            'receive' => 'required',
        ]);
        if ($validator->passes()) {
            $dodate=date('Y-m-d',strtotime($request->dodate));
            $s=new Salecloselistpayment;
            $s->salecloselist_id=$request->closelistid;
            $s->paydate=$dodate;
            $s->user_id=$request->userid;
            $s->payamt=str_replace(',','',$request->receive);
            $s->cur=$request->icur;
            $s->note=$request->note;
            $s->balance=str_replace(',','',str_replace($request->icur,'',$request->balance));
        if($s->save()){
            $tpaid=DB::table('salecloselistpayments')
                        ->where('salecloselist_id',$request->closelistid)
                        ->sum('payamt');
            DB::table('salecloselists')->where('id',$request->closelistid)->update(['deposit'=>$tpaid]);
            return response()->json(['success'=>'Paid to list completed.']);
            }
        }
        
        return response()->json(['error'=>'paid to list not allow.']);
    
    }
    public function deletepaidlist(Request $request)
    {
        $pdt=Salecloselistpayment::findOrFail($request->id);
        if($pdt->delete()){
            $tpaid=DB::table('salecloselistpayments')
                        ->where('salecloselist_id',$request->clid)
                        ->sum('payamt');
            DB::table('salecloselists')->where('id',$request->clid)->update(['deposit'=>$tpaid]);
            return response()->json(['success'=>'Remove Paid Completed.']);
        }
         return response()->json(['error'=>'delete paid list not allow.']);
    
    }
    public function deletecloselist(Request $request)
    {
        $cl=Salecloselist::findOrFail($request->id);
        if($cl->delete()){
            $preid=Salecloselist::where('supplier_id',$request->cusid)->where('cur',$request->cur)->orderBy('id','DESC')->take(1)->get();
            if($preid && count($preid)>0){
                DB::table('salecloselists')->where('id',$preid[0]->id)->update(['islast'=>true]);
            }
            DB::table('salecloselistpayments')->where('salecloselist_id',$request->id)->delete();
            DB::table('sales')->where('close',$request->id)->update(['close'=>0]);
             return response()->json(['success'=>'Remove Completed.']);
        }
         return response()->json(['error'=>'delete close list faile.']);
    }
    public function getsaleinvoice(Request $request)
    {
        //return($request->all());
            $start_date=date('Y-m-d',strtotime($request->d1));
            $end_date=date('Y-m-d',strtotime($request->d2));
            $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                            ->where('sales.supplier_id',$request->cid)
                            ->where('cur',$request->cur)
                            ->where('close',0)
                            ->get();
            $totalmoney=DB::table('sales')
                            ->select(DB::raw('sum(total) as t_total,sum(deposit) as t_deposit'))
                            ->whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                            ->where('sales.supplier_id',$request->cid)
                            ->where('cur',$request->cur)
                            ->where('close',0)
                            ->get();

            $listdebt=DB::table('salecloselists')
            ->Where('supplier_id',$request->cid)
            ->Where('cur',$request->cur)
            ->select(DB::raw('(total-deposit) as balance'))
            ->orderBy('id','DESC')
            ->take(1)->get();
            //$closelist=Salecloselist::where('supplier_id',$request->cid)->where('islast',1)->get();
            $closelist=Salecloselist::Where('supplier_id',$request->cid)
            ->Where('cur',$request->cur)
            ->orderBy('id','DESC')
            ->take(1)->get();

            return view('sales.s_invoice1',compact('invoices','totalmoney','listdebt','closelist'));
    }
     public function getsaleinvoice1(Request $request)
    {
        //return($request->all());
            $start_date=date('Y-m-d',strtotime($request->d1));
            $end_date=date('Y-m-d',strtotime($request->d2));
            $closelist=Salecloselist::where('supplier_id',$request->cid)
                                    ->whereDate('d1',$start_date)
                                    ->whereDate('d2',$end_date)
                                    ->where('cur',$request->cur)
                                    ->get();
            
            
            return view('closelists.s_invoice2',compact('closelist'));
    }
    public function getlastcloselist(Request $request)
    {
        //return($request->all());
            $start_date=date('Y-m-d',strtotime($request->d1));
            $end_date=date('Y-m-d',strtotime($request->d2));
            $closelist=Salecloselist::where('supplier_id',$request->cid)
                                    ->whereDate('d1',$start_date)
                                    ->whereDate('d2',$end_date)
                                    ->where('cur',$request->cur)
                                    ->get();
            
            
            return view('closelists.customerlist',compact('closelist'));
    }
    public function getclosesaleinvoice(Request $request)
    {
        $invoices=Sale::where('close',$request->clid)->orderBy('invdate')->get();
        return view('closelists.getclosesaleinvoice',compact('invoices'));
    }
    public function getpaidlistdetail(Request $request)
    {
       
        $pdt=Salecloselistpayment::where('salecloselist_id',$request->clid)->orderBy('paydate','ASC')->orderBy('id','ASC')->get();
        return view('closelists.getpaidlistdetail',compact('pdt'));
        
    }
     public function searchcategory(Request $request)
    {
        $cats=Category::where('active','1')->where('name','like','%'. $request->q .'%')->get();
        $output='';
        foreach ($cats as $key => $row) {
           $output .='<tr>
                    <td style="width:auto;">'. ++$key .'</td>
                    <td style="padding:0px;"><a href="#" class="catname btn btn-default" style="height:40px;width:100%;text-align:left;font-family:khmer os content;padding-top:10px;" data-id="'. $row->id .'">'. $row->name .'</a></td>
                    </tr>';
        }
        if($output==''){
            $output='<tr><td></td><td>Not found</td></tr>';
        }
        return response($output);
    }
    public function closesaleinvoice()
    {
        $current = Carbon::now();
        $customers=Supplier::where('type','1')->get();
        $invoices=Sale::whereNull('created_at');
        $totalmoney=DB::table('sales')
                            ->select(DB::raw('sum(total) as t_total,sum(deposit) as t_deposit'))
                            ->whereBetween(DB::raw('DATE(sales.invdate)'), array($current, $current))
                            ->where('sales.supplier_id',0)
                            ->where('cur','R')
                            ->get();
        $listdebt=DB::table('salecloselists')
            ->Where('supplier_id',0)
            ->Where('cur','N')
            ->select(DB::raw('(total-deposit) as balance'))
            ->orderBy('id','DESC')
            ->take(1)->get();
        $closelist=Salecloselist::where('id',0)->get();
        return view('closelists.closeinvoice',compact('customers','invoices','totalmoney','listdebt','closelist'));
    }
    public function closesaleinvoicepayment()
    {
        $current = Carbon::now();
        $customers=Supplier::where('type','1')->get();
        $closelist=Salecloselist::where('id',0)->get();
        
        return view('closelists.closeinvoicepayment',compact('customers','closelist'));
    }
    public function searchcustomer(Request $request)
    {
        
         $start_date=date('Y-m-d',strtotime($request->d1));
         $end_date=date('Y-m-d',strtotime($request->d2));
         $customers=Sale::join('suppliers','sales.supplier_id','=','suppliers.id')
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                    ->where('close','0')
                    ->select('supplier_id','suppliers.name as supname','cur')
                    ->distinct()
                    ->orderBy('suppliers.name')
                    ->get();
        return view('sales.searchcusname',compact('customers'));
       
       
        //return response($customers);
       
    }
    public function searchcustomeroldlist(Request $request)
    {

        $d1d2=Salecloselist::whereDate('d1','<',$request->d1)->select('d1d2')->orderBy('id','DESC')->take(1)->get();
        if($d1d2 && count($d1d2)>0){
            $customers=Salecloselist::where('d1d2',$d1d2[0]->d1d2)->where('islast','1')->whereColumn('deposit','<','total')->get();
            return view('closelists.searchcusnameoldlist',compact('customers'));
        }
        
       
    }
    public function searchcustomercloselist(Request $request)
    {
        $start_date=date('Y-m-d',strtotime($request->d1));
        $end_date=date('Y-m-d',strtotime($request->d2));
        
         $customers=Salecloselist::join('suppliers','salecloselists.supplier_id','=','suppliers.id')
                    ->whereDate('d1',$start_date)
                    ->whereDate('d2',$end_date)
                    ->orderBy('suppliers.name','ASC')
                    ->get();
        return view('sales.searchcusname',compact('customers'));
       
       
    }
    public function searchcustomermodal(Request $request)
    {
        $search=$request->q;
        $customers=DB::table('suppliers')
                    ->where('type',1)
                    ->where(function($query) use($search){
                        $query->Where('name_slug','like','%'. $search.'%')
                                ->orWhere('tel','like','%'. $search.'%')
                                ->orWhere('customercode','like','%'. $search.'%');
                    })
                    ->get();
                    
        return view('modal.customersearch_modal',compact('customers'));


    }
     public function invoicelistsearchpaid(Request $request)
    {
        if($request->ajax()){
            //return($request->all());
            $start_date=date('Y-m-d',strtotime($request->start_date));
            $end_date=date('Y-m-d',strtotime($request->end_date));
            $a=$request->a;
            $b=$request->b;
            if($request->supplier){
                $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.supplier_id',$request->supplier)
                                ->whereBetween('p_paid',array($a,$b))
                                ->get();
            }else if($request->delivery){
                $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.delivery_id',$request->delivery)
                                ->whereBetween('p_paid',array($a,$b))
                                ->get();
            }else if($request->lawfee){
                $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.law_id',$request->lawfee)
                                ->whereBetween('p_paid',array($a,$b))
                                ->get();
            }else if($request->invoice){
                $invoices = Sale::where('sales.id',$request->invoice)->get();
            }else if($request->item){
                $pid=Product::where('name',$request->item)->first();
                //return($pid->id);
                $invoices=Sale::join('sale_details','sales.id','=','sale_details.sale_id')
                            // ->join('products','sale_details.product_id','=','products.id')
                            ->whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                            ->where('sale_details.product_id','=',$pid->id)
                            ->whereBetween('p_paid',array($a,$b))
                            ->select('sales.*')
                            ->get();
                            //return ($invoices);

            }
            else{
                $invoices=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                                    ->whereBetween('p_paid',array($a,$b))
                                    ->orderBy('id','asc')
                                    ->get();
            }
           
        }
            // $uri = $_SERVER['REQUEST_URI'];
            // if($uri=='/sale/paid'){
            //     return view('sales.s_invoice',compact('invoices')); 
            // }else if($uri=='/sale/paiddelivery'){
            //     return view('sales.s_invoice_delivery',compact('invoices')); 
            // }
            return view('sales.s_invoice',compact('invoices')); 
            //return response($invoices);
    }
    public function invoicelistsearchfordebt(Request $request)
    {
        //return ($request->all());
        if($request->ajax()){
            $start_date=date('Y-m-d',strtotime($request->start_date));
            $end_date=date('Y-m-d',strtotime($request->end_date));
            if($request->alldate=='true'){
                
                 $invoices=Sale::where('supplier_id',$request->cid)
                                    ->where('balance',$request->operater,'0')
                                    ->orderBy('id','asc')
                                    ->get();
            }else{
               
                 $invoices=Sale::where('supplier_id',$request->cid)
                                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                    ->where('balance',$request->operater,'0')
                                    ->orderBy('id','asc')
                                    ->get();
            }
            return view('sales.s_invoice',compact('invoices')); 
        }
    }
     public function invoicelistsearchpaidfordelivery(Request $request)
    {
        if($request->ajax()){
            //return($request->all());
            $start_date=date('Y-m-d',strtotime($request->start_date));
            $end_date=date('Y-m-d',strtotime($request->end_date));
            
            if($request->supplier){
                $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.supplier_id',$request->supplier)
                                ->whereColumn('totaldelivery',$request->operater,'deposit_carfee')
                                ->get();
            }else if($request->delivery){
                $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.delivery_id',$request->delivery)
                                ->whereColumn('totaldelivery',$request->operater,'deposit_carfee')
                                ->get();
            }else if($request->lawfee){
                $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.law_id',$request->lawfee)
                                ->whereColumn('totaldelivery',$request->operater,'deposit_carfee')
                                ->get();
            }else if($request->invoice){
                $invoices = Sale::where('sales.id',$request->invoice)->get();
            }
            
            else{
                $invoices=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                                    ->whereColumn('totaldelivery',$request->operater,'deposit_carfee')
                                    ->orderBy('id','asc')
                                    ->get();
            }
           
        }
            
        return view('sales.s_invoice_delivery',compact('invoices')); 
    }

    public function invoicelistsearchpaidforlaw(Request $request)
    {
        if($request->ajax()){
            //return($request->all());
            $start_date=date('Y-m-d',strtotime($request->start_date));
            $end_date=date('Y-m-d',strtotime($request->end_date));
            
            if($request->supplier){
                $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.supplier_id',$request->supplier)
                                ->whereColumn('lawfee',$request->operater,'deposit_lawfee')
                                ->get();
            }else if($request->delivery){
                $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.delivery_id',$request->delivery)
                                ->whereColumn('lawfee',$request->operater,'deposit_lawfee')
                                ->get();
            }else if($request->lawfee){
                $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.law_id',$request->lawfee)
                                ->whereColumn('lawfee',$request->operater,'deposit_lawfee')
                                ->get();
            }else if($request->invoice){
                $invoices = Sale::where('sales.id',$request->invoice)->get();
            }
            
            else{
                $invoices=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                                    ->whereColumn('lawfee',$request->operater,'deposit_lawfee')
                                    ->orderBy('id','asc')
                                    ->get();
            }
           
        }
            
        return view('sales.s_invoice_law',compact('invoices')); 
    }

    public function showsaledetail(Request $request)
    {
        if($request->ajax()){
            $pdt=Sale_Detail::where('sale_id',$request->id)->orderBy('id','ASC')->get();
            return view('sales.s_invoice_detail_items',compact('pdt'));
        }
    }
    public function showpaiddetail(Request $request)
    {
        if($request->ajax()){
             $uri = $_SERVER['REQUEST_URI'];
             
            if(strpos($uri,'customer')>0){
                $tpaid=sale_payment::where('sale_id',$request->id)->where('paymethod','customer')->sum('paidamt');
                $pdt=sale_payment::where('sale_id',$request->id)->where('paymethod','customer')->orderBy('id','ASC')->get();
            }else if(strpos($uri,'delivery')>0){
                $tpaid=sale_payment::where('sale_id',$request->id)->where('paymethod','delivery')->sum('paidamt');
                $pdt=sale_payment::where('sale_id',$request->id)->where('paymethod','delivery')->orderBy('id','ASC')->get();
            }else if(strpos($uri,'law')>0){
                $tpaid=sale_payment::where('sale_id',$request->id)->where('paymethod','law')->sum('paidamt');
                $pdt=sale_payment::where('sale_id',$request->id)->where('paymethod','law')->orderBy('id','ASC')->get();
            }
            
            return view('closelists.paidlist_modal_body',compact('pdt','tpaid'));
        }
    }
    public function totalinvpaid(Request $request)
    {
        if($request->ajax()){
            $buyinv = trim((int)$request->buyinv);
            $totalpaid=DB::table('sale_payments')
            ->select(DB::raw('sum(paidamt) as totalpaid'))
            ->where('sale_id',$buyinv)
            ->where('paymethod',$request->paytype)
            ->get();
            return response($totalpaid);
        }
    }
     public function delpaid(Request $request)
    {
        if($request->ajax()){
            //return($request->all());
            $totalinv=str_replace(',','',$request->totalinv);
            $buyinv = trim((int)$request->purinv);
            DB::table('sale_payments')->where('id',$request->id)->delete();
            $tpaid=sale_payment::where('sale_id',$buyinv)->where('paymethod',$request->paymethod)->sum('paidamt');
            if($request->paymethod=='customer'){
                $paidps=floor((float)$tpaid / (float)$totalinv) * 100;
                $bal=$totalinv - $tpaid;
                DB::table('sales')->where('id',$buyinv)->update(['deposit'=>$tpaid,'p_paid'=>$paidps,'balance'=>$bal]);
            }else if($request->paymethod=='delivery'){
                DB::table('sales')->where('id',$buyinv)->update(['deposit_carfee'=>$tpaid]);
            }else if($request->paymethod=='law'){
                DB::table('sales')->where('id',$buyinv)->update(['deposit_lawfee'=>$tpaid]);
            }
            

            $pdt=sale_payment::where('sale_id',$buyinv)->where('paymethod',$request->paymethod)->orderBy('id','ASC')->get();
            return view('closelists.paidlist_modal_body',compact('pdt','tpaid'));


        }
    }
    
    public function customerpaid()
    {
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh');   
        $suppliers=Supplier::where('active',1)->where('type',1)->get();
        $deliveries=Delivery::where('active',1)->get();
        $lawfees=Law::where('active',1)->get();
        $invoices=Sale::whereDate('created_at',$current)
        ->whereBetween('p_paid',array(0,99))
        ->orderBy('id','asc')
        ->get();
        $items=Product::all();
        return view('sales.salepaid',compact('invoices','suppliers','deliveries','items','lawfees'));
    }
    public function paid_delivery()
    {
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh');   
        $suppliers=Supplier::where('active',1)->where('type',1)->get();
        $deliveries=Delivery::where('active',1)->get();
        $lawfees=Law::where('active',1)->get();
        $invoices=Sale::whereDate('created_at',$current)
        ->whereColumn('totaldelivery','>','deposit_carfee')
        ->orderBy('id','asc')
        ->get();
        $items=Product::all();
        return view('sales.salepaid_delivery',compact('invoices','suppliers','deliveries','items','lawfees'));
    }
    public function paid_law()
    {
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh');   
        $suppliers=Supplier::where('active',1)->where('type',1)->get();
        $deliveries=Delivery::where('active',1)->get();
        $lawfees=Law::where('active',1)->get();
        $invoices=Sale::whereDate('created_at',$current)
        ->whereColumn('lawfee','>','deposit_lawfee')
        ->orderBy('id','asc')
        ->get();
        $items=Product::all();
        return view('sales.salepaid_law',compact('invoices','suppliers','deliveries','items','lawfees'));
    }
    function savepaid(Request $request)
    {
        
        //return($request->all());
        $dd = Carbon::now();
        $dd->timezone('Asia/Phnom_Penh'); 
        $payondate=date('Y-m-d',strtotime($request->paydate));
        foreach ($request->paid_inv as $key => $value) {
                    $data=array('sale_id'=>(int)$value,
                                'user_id'=>$request->user_id,
                                'dd'=>$payondate,
                                'paidamt'=>str_replace(',','',$request->paid_deposit[$key]),
                                'cur'=>$request->getpaidcur,
                                'paynote'=>$request->paynote,
                                'paymethod'=>$request->paymethod,
                                'created_at'=>$dd,
                                'updated_at'=>$dd);
                    if(sale_payment::insert($data)){
                        $olddep=str_replace(',','',str_replace($request->getpaidcur,'',$request->deposited[$key]));
                        $newdep=str_replace(',','',$request->paid_deposit[$key]);
                        $tdeposit= (float)$olddep+(float)$newdep;
                        if($request->paymethod == 'customer'){
                            DB::table('sales')->where('id',(int)$value)->update(['p_paid'=>$request->pps[$key],'deposit'=>$tdeposit,'balance'=>abs(str_replace(',','',$request->balance[$key]))]);
                        }else if($request->paymethod == 'delivery'){
                                DB::table('sales')->where('id',(int)$value)->update(['deposit_carfee'=>$tdeposit]);
                        }else if($request->paymethod == 'law'){
                                DB::table('sales')->where('id',(int)$value)->update(['deposit_lawfee'=>$tdeposit]);
                        }
                         
                    }
                };

            
            return response($tdeposit);

    }

    public function editsaleinv(Request $request)
    {
        if($request->ajax()){
            $pinv=DB::table('sales')
                        ->join('sale_details','sales.id','=','sale_details.sale_id')
                        ->join('products','sale_details.product_id','=','products.id')
                        ->join('users','sales.user_id','=','users.id')
                        ->join('suppliers','sales.supplier_id','=','suppliers.id')
                        ->join('deliveries','sales.delivery_id','=','deliveries.id')
                        ->join('laws','sales.law_id','=','laws.id')
                        
                        ->select('products.*','sale_details.*','sale_details.discount as discount1','users.name as username','suppliers.name as supname','deliveries.name as dename','laws.name as lawname','sales.*','products.cur as cur_product','sale_details.cur as cur_detail')
                        ->where('sales.id',$request->id)
                        ->whereNull('sale_details.deleted_at')
                        ->orderBy('sale_details.id','DESC')
                        ->get();
            return response($pinv);
        }
    }


    public function updatesale(Request $request)
    {
          //return($request->all());
          $validator = Validator::make($request->all(), [
            
            'productid.*' => 'required',
            'barcode.*' => 'required',
            'qty1.*' => 'required|numeric', //input array validate
            'sel_delivery'=>'required',
            'sel_supplier'=>'required',
            'sel_law'=>'required'
        ]);
        if ($validator->passes()) {
            $current = Carbon::now();
            $current->timezone('Asia/Phnom_Penh');
            if($request->invdate){
                 $date = str_replace('/', '-', $request->invdate);
            }else{
                 $date = str_replace('/', '-', $request->invdate1);
            }
           
            $invdate= date('Y-m-d', strtotime($date));
            $p=Sale::find($request->sale_id);
            $p->invdate=$invdate;
            $p->user_id=$request->userid;
            $p->supplier_id=$request->sel_supplier;
            $p->delivery_id=$request->sel_delivery;
            $p->buyinv=$request->buyinv;
            $p->buyfrom=$request->buyfrom;
             if($request->buyinv <> ''){
                $totalbuyex=$this->exchange($request->buycur,$request->lastcur,str_replace(',','',$request->buytotal));
                $p->totalcost=$totalbuyex;
            }
            $p->carfee=str_replace(',','',$request->carfee);
            $p->totalweight=str_replace(',','',$request->totalweight);
            $p->totaldelivery=str_replace(',','',$request->totaldelivery);
            $p->law_id=$request->sel_law;
            $p->lawfee=str_replace(',','',$request->lawfee);
            $p->carnum=$request->carnum;
            $p->driver=$request->driver;
            $p->invnote=$request->invdesr;
            $p->subtotal=str_replace(',','',$request->subtotal);
            $p->shipcost=$request->shipcost;
            $p->discount=$request->invdiscount;
            $p->total=str_replace(',','',$request->lasttotal);
            $p->cur=$request->lastcur;
            //$p->created_at=$current;
            $p->updated_at=$current;
            if ($p->save()) {
                $pdt=Sale_Detail::where('sale_id',$request->sale_id);
                $pdt->delete();
                // foreach ($request->productid as $key => $value) {
                //     $data=array('sale_id'=>$request->sale_id,
                //                 'product_id'=>$value,
                //                 'barcode'=>$request->barcode[$key],
                //                 'qty'=>$request->qty1[$key],
                //                 'unit'=>$request->unit1[$key],
                //                 'qtycut'=>$request->qty2[$key],
                //                 'quantity'=>$request->qty3[$key],
                //                 'unitprice'=>$request->unitprice[$key],
                //                 'discount'=>$request->discount[$key],
                //                 'amount'=> str_replace(',','',$request->amount[$key]) ,
                //                 'cur'=> $request->cur1[$key],
                //                 'multiunit'=>$request->multi[$key],
                //                 'qtyunit'=>$request->qtyunit[$key],
                //                 'submit'=>$request->submit[$key],
                //                 'submitdate'=>$invdate,
                //                 'created_at'=>$current,
                //                 'updated_at'=>$current);
                //     Sale_Detail::insert($data);
                // }
                $countrow=count($request->productid)-1;
                for($key=$countrow;$key>=0;$key--){
                     $data=array('sale_id'=>$request->sale_id,
                                'product_id'=>$request->productid[$key],
                                'barcode'=>$request->barcode[$key],
                                'qty'=>$request->qty1[$key],
                                'unit'=>$request->unit1[$key],
                                'qtycut'=>$request->qty2[$key],
                                'unitcut'=>$request->unit2[$key],
                                'quantity'=>$request->qty3[$key],
                                'unitprice'=>str_replace(',','',$request->unitprice[$key]),
                                'discount'=>$request->discount[$key],
                                'amount'=> str_replace(',','',$request->amount[$key]),
                                'cur'=>$request->cur1[$key],
                                'focunit'=>$request->focunit[$key],
                                'sunit'=>$request->sunit[$key],
                                'multiunit'=>$request->multi[$key],
                                'qtyunit'=>(float)$request->qty1[$key]*(float)$request->multi[$key],
                                'submit'=>$request->submit[$key],
                                'cost'=>$request->costprice[$key],
                                'costcur'=>$request->costcur[$key],
                                'costex'=>$this->exchange($request->costcur[$key],$request->cur1[$key],$request->costprice[$key]),
                                'invdiscount'=>$request->invdiscount,
                                'submitdate'=>$invdate,
                                'created_at'=>$current,
                                'updated_at'=>$current);
                    Sale_Detail::insert($data);
                }

                return response()->json(['success'=>'Update Sale completed.']);
            }
        }
       
         return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function storesale(Request $request)
    {
        //return response($request->all());
        $validator = Validator::make($request->all(), [
            
            'productid.*' => 'required',
            'barcode.*' => 'required',
            'qty1.*' => 'required|numeric', //input array validate
            'sel_delivery'=>'required',
            'sel_supplier'=>'required',
            'sel_law'=>'required'
        ]);

        
        $date = str_replace('/', '-', $request->invdate);
        $invdate= date('Y-m-d', strtotime($date));
        $bal=str_replace(',','',$request->lasttotal);
        $dep=str_replace(',','',$request->deposit);
        if($bal==0){
            $psp=0;
        }else{
            $psp=floor(((float)$dep/(float)$bal)*100);
        }
        
        if ($validator->passes()) {
            $current = Carbon::now();
            $current->timezone('Asia/Phnom_Penh');
            $p=new Sale;
            $p->invdate=$invdate;
            $p->user_id=$request->userid;
            $p->supplier_id=$request->sel_supplier;
            $p->delivery_id=$request->sel_delivery;
            $p->buyinv=$request->buyinv;
            $p->buyfrom=$request->buyfrom;
            if($request->buyinv <> ''){
                $totalbuyex=$this->exchange($request->buycur,$request->lastcur,str_replace(',','',$request->buytotal));
                $p->totalcost=$totalbuyex;
            }
            
            $p->carfee=str_replace(',','',$request->carfee);
            $p->totalweight=str_replace(',','',$request->totalweight);
            $p->totaldelivery=str_replace(',','',$request->totaldelivery);
            
            $p->law_id=$request->sel_law;
            $p->lawfee=str_replace(',','', $request->lawfee);
            $p->carnum=$request->carnum;
            $p->driver=$request->driver;
            $p->invnote=$request->invnote;
            $p->subtotal=str_replace(',','',$request->subtotal);
            $p->shipcost=$request->shipcost;
            $p->discount=$request->invdiscount;
            $p->total=str_replace(',','',$request->lasttotal);
            $p->cur=$request->lastcur;
            $p->balance=str_replace(',','',$request->lasttotal);
            if($request->deposit>0){
                $p->deposit=str_replace(',','',$request->deposit);
                $p->balance=str_replace(',','',$request->lastbal);
                $p->p_paid=$psp;
            }
            $p->created_at=$current;
            $p->updated_at=$current;
            if ($p->save()) {
                $id=$p->id;
                // foreach ($request->productid as $key => $value) {
                //     $data=array('sale_id'=>$id,
                //                 'product_id'=>$value,
                //                 'barcode'=>$request->barcode[$key],
                //                 'qty'=>$request->qty1[$key],
                //                 'unit'=>$request->unit1[$key],
                //                 'qtycut'=>$request->qty2[$key],
                //                 'quantity'=>$request->qty3[$key],
                //                 'unitprice'=>$request->unitprice[$key],
                //                 'discount'=>$request->discount[$key],
                //                 'amount'=> str_replace(',','',$request->amount[$key]),
                //                 'cur'=>$request->cur1[$key],
                //                 'multiunit'=>$request->multi[$key],
                //                 'qtyunit'=>$request->qtyunit[$key],
                //                 'submitdate'=>$invdate,
                //                 'created_at'=>$current,
                //                 'updated_at'=>$current);
                //     Sale_Detail::insert($data);
                //     }
                //$totalcost=0;
                $countrow=count($request->productid)-1;
                for($key=$countrow;$key>=0;$key--){
                     //$totalcost += $request->qty1[$key] * $request->costprice[$key];
                     $data=array('sale_id'=>$id,
                                'product_id'=>$request->productid[$key],
                                'barcode'=>$request->barcode[$key],
                                'qty'=>$request->qty1[$key],
                                'unit'=>$request->unit1[$key],
                                'qtycut'=>$request->qty2[$key],
                                'unitcut'=>$request->unit2[$key],
                                'quantity'=>$request->qty3[$key],
                                'unitprice'=>str_replace(',','',$request->unitprice[$key]),
                                'discount'=>$request->discount[$key],
                                'amount'=> str_replace(',','',$request->amount[$key]),
                                'cur'=>$request->cur1[$key],
                                'focunit'=>$request->focunit[$key],
                                'sunit'=>$request->sunit[$key],
                                'multiunit'=>$request->multi[$key],
                                'qtyunit'=>(float)$request->qty1[$key]*(float)$request->multi[$key],
                                'cost'=>str_replace(',','',$request->costprice[$key]),
                                'costcur'=>$request->costcur[$key],
                                'costex'=>$this->exchange($request->costcur[$key],$request->cur1[$key],str_replace(',','',$request->costprice[$key])),
                                'invdiscount'=>$request->invdiscount,
                                'submitdate'=>$invdate,
                                'created_at'=>$current,
                                'updated_at'=>$current);
                    Sale_Detail::insert($data);
                }
                if($request->deposit>0){
                    $spm=new sale_payment;
                    $spm->sale_id=$id;
                    $spm->user_id=$request->userid;
                    $spm->dd=$current;
                    $spm->paidamt=str_replace(',','',$request->deposit);
                    $spm->cur=$request->lastcur;
                    $spm->save();

                }
                // if($request->buyinv==''){
                //     $tcostexc=$this->exchange($request->costcur[$key],$request->lastcur,str_replace(',','',$totalcost));
                //     DB::table('sales')->where('id',$id)->update(['totalcost'=>$tcostexc]);
                // }
            }
            return response()->json(['success'=>'Save Sale Completed.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function exchange($c1,$c2,$amount)
    {
        $curex=$c1 . '-' . $c2;
        $curex1=$c2 . '-' . $c1;
        $rate=1;
        $amt=0;
        $getrate=Exchange::where('exchange_cur',$curex)->first();
        if($getrate){
            $rate=$getrate->buy;
             $amt=$amount*$rate;
             return $amt;
        }else{
            $getrate=Exchange::where('exchange_cur',$curex1)->first();
            if($getrate){
                $rate=$getrate->sale;
            }else{
                $rate=1;
            }
        }
        $amt=(float)$amount/(float)$rate;
        return $amt;
    }
    public function postsupplier(Request $request)
    {

        $newsup=new Supplier();
        $newsup->name=$request->supplier_name;
        $newsup->name_slug=str_replace(' ','',$request->supplier_name);
        $newsup->sex=$request->sex;
        $newsup->tel=$request->tel;
        $newsup->email=$request->email;
        $newsup->address=$request->address;
        $newsup->type=1;
        $newsup->save();
        if($newsup){
            return response($newsup);
        }else{
            return null;
        }
    }
    public function postco(Request $request)
    {
        //return response($request->all());
        $newco=new Law();
        $newco->name=$request->co_name;
        $newco->tel=$request->co_tel;
        $newco->email=$request->co_email;
        $newco->address=$request->other;
        $newco->save();
        if($newco){
            return response($newco);
        }else{
            return null;
        }
    }
    public function postdelivery(Request $request)
    {

        $newsup=new Delivery();
        $newsup->name=$request->delivery_name;
        $newsup->tel=$request->tel;
        $newsup->email=$request->email;
        $newsup->address=$request->address;
        $newsup->save();
        if($newsup){
            return response($newsup);
        }else{
            return null;
        }
       
    }
    public function index()
    {    
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh');   
        $suppliers=Supplier::where('active',1)->where('type',1)->get();
        $buyfrom=Supplier::where('active',1)->where('type',0)->get();
        $deliveries=Delivery::where('active',1)->get();
        $cats=Category::where('active',1)->get();
        $co=Law::where('active',1)->get();
        $invoices=Sale::whereDate('created_at',$current)->orderBy('id','asc')->get();
    	return view('sales.index',compact('suppliers','deliveries','invoices','co','buyfrom','cats'));
    }
    public function SearchItemBarcode(Request $request)
    {
    	$data=ProductBarcode::join('products','product_barcodes.product_id','=','products.id')
    				->where('product_barcodes.barcode','=',$request->barcode)
                    ->select('products.*','product_barcodes.*','products.cur as pcur')
    				->first();
    	return response($data);
    }

     public function product_search(request $request)
    {
       // return($request->all());
        $output='';
        $output1='';
        if($request->ajax()){
            if($request->category){

                 $data=DB::table('products')
                            //->join('product_barcodes','products.id','=','product_barcodes.product_id')
                            //->select('products.*','product_barcodes.*')
                            ->Where('products.status','1')
                            ->Where('products.category_id',$request->category)
                            ->orderBy('products.id','asc')->get();
                    $total_row=$data->count();
            }else{
                $query=$request->get('query');
                 if($query != '')
                {
                     $data=DB::table('products')
                            //->join('product_barcodes','products.id','=','product_barcodes.product_id')
                            //->select('products.*','product_barcodes.*')
                            //->Where('products.status','1')
                            //->Where('product_barcodes.barcode','like','%'. $query .'%')
                            ->Where('products.code','like','%'. $query .'%')
                            ->orWhere('name','like','%'. $query .'%')
                            ->Where('products.status','1')
                            ->orderBy('name','asc')->get();
                    $total_row=$data->count();

                }else
                {
                    $total_row=0;
                }
            }
            
            if($total_row>0)
            {
                    foreach ($data as $key=>$row) {
                         $pbarcodes=ProductBarcode::where('product_id',$row->id)->orderBy('id')->get();
                         $output .= '<tr colspan="5" data-toggle="collapse" data-target="#pid'. $row->id .'" class="accordion-toggle">
									<td style="text-align:center;width:50px;">'. ++$key .'</td>
									<td style="width:150px;">'. $row->id . "-" . $row->code .'</td>
									<td style="font-family:khmer os system;width:300px;">'. $row->name .'</td>
									<td style="font-family:khmer os system;width:60px;">'. $row->itemunit .'</td>
									

                         			</tr>';

                                    $output1='<tr class="p">
                                            <td colspan="5" class="hiddenRow">
                                            <div class="accordian-body collapse p-3" id="pid'. $row->id .'">';


                            foreach ($pbarcodes as $key => $value) {
                                                $dc1=0;
                                               
                                                $p=strpos((float)$value->price,'.');
                                                if($p>0){
                                                    $fp=substr($value->price,$p,strlen($value->price)-$p);
                                                    $dc1=strlen((float)$fp)-2;
                                                    
                                                }
                                                
                               $output1 .='<p style="margin:0px;">
                               <input style="height:35px;width:100px;margin-left:58px;text-align:center;background-color:#ddd;" type="text" value="'. $value->barcode .'" readonly>
                               <input id="qty'. $row->id . $key .'" style="height:35px;width:50px;text-align:center;" type="text" value="" placeholder="Qty">
                                <input style="height:35px;width:70px;text-align:center;font-family:khmer os system;background-color:#ddd;" type="text" value="'. $value->unit .'" readonly>
                               <input style="height:35px;width:100px;text-align:right;background-color:#ddd;" type="text" value="'. number_format($value->price,$dc1,".",",") . $value->cur .'" readonly>
                               <a href="#" class="btn btn-info selproduct" data-barcode="'. $value->barcode .'" data-key="'. $key .'" data-id="'. $row->id .'">Add</a>
                               </p>';

                            }
                            $output1 .=' </div> 
                            </td> 
                        </tr>     ';
                            $output .=$output1;
                            $output1='';
                         
                    }
               
            }
            else
            {
                $output='<tr>
                            <td align="center" colspan="5">
                                No data found
                            </td>
                        </tr>';
            }
            $data=array(
                'table_data'=>$output,
                'total_data'=>$total_row
            );
            //echo json_encode($data);
            return response($data);

        }
    }

    public function saleprint($id)
    {
        $pinv=Sale::join('sale_details','sales.id','=','sale_details.sale_id')
                        ->join('products','sale_details.product_id','=','products.id')
                        ->join('users','sales.user_id','=','users.id')
                        ->join('suppliers','sales.supplier_id','=','suppliers.id')
                        ->join('deliveries','sales.delivery_id','=','deliveries.id')
                        ->select('sales.*','sale_details.*','users.name as username','suppliers.name as supname','deliveries.name as dename','sales.id as invnum','products.*')
                        ->where('sales.id',$id)
                        ->whereNull('sale_details.deleted_at')
                        ->get();
        $logo=Company::orderBy('id')->first();

                        //return($pinv);
        return view('sales.sale_invoice_print',compact('pinv','logo'));
    }
    public function saleprintall(Request $request)
    {
        //return ($request->all());
        $a=$request->a;
        $b=$request->b;
        $start_date=date('Y-m-d',strtotime($request->d1));
        $end_date=date('Y-m-d',strtotime($request->d2));
        if($request->searchby=='date'){
            $sinv=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                        ->whereBetween('p_paid',array($a,$b))
                        ->whereNull('deleted_at')
                        ->orderBy('id')
                        ->get();
        }else if($request->searchby=='sup'){
            if($request->id==0){
                $sinv=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                        ->whereBetween('p_paid',array($a,$b))
                        ->whereNull('deleted_at')
                        ->orderBy('id')
                        ->get();
            }else{
                $sinv=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                        ->where('supplier_id',$request->id)
                        ->whereBetween('p_paid',array($a,$b))
                        ->whereNull('deleted_at')
                        ->orderBy('id')
                        ->get();
            }
            
        }else if($request->searchby=='item'){
            $pid=Product::where('name',$request->id)->first();
             $sinv=Sale::join('sale_details','sales.id','=','sale_details.sale_id')
                            ->whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                            ->whereBetween('p_paid',array($a,$b))
                            ->where('sale_details.product_id','=',$pid->id)
                            ->whereNull('sale_details.deleted_at')
                            ->select('sales.*')
                            ->orderBy('sales.id')
                            ->get();
        }else if($request->searchby=='dev'){
            if($request->id==0){
                $sinv=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                        ->whereBetween('p_paid',array($a,$b))
                        ->whereNull('deleted_at')
                        ->orderBy('id')
                        ->get();
            }else{
                $sinv=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                        ->whereBetween('p_paid',array($a,$b))
                        ->where('delivery_id',$request->id)
                        ->whereNull('deleted_at')
                        ->orderBy('id')
                        ->get();
            }
        }else if($request->searchby=='law'){
            if($request->id==0){
                $sinv=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                        ->whereBetween('p_paid',array($a,$b))
                        ->whereNull('deleted_at')
                        ->orderBy('id')
                        ->get();
            }else{
                $sinv=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                        ->whereBetween('p_paid',array($a,$b))
                        ->where('law_id',$request->id)
                        ->whereNull('deleted_at')
                        ->orderBy('id')
                        ->get();
            }
        }else if($request->searchby=='inv'){
            $sinv=Sale::where('id',$request->id)
                        ->get();
        }
        
        $logo=Company::orderBy('id')->first();
        return view('sales.sale_invoice_print_all',compact('sinv','logo'));
    }
    public function destroysale(Request $request)
    {
       $p=Sale::findOrFail($request->id);
       if(!is_null($p)){
            if($p->delete()){
                $pd=Sale_Detail::where('sale_id',$request->id);
                $pd->delete();
               }
       }
    }

    public function invoiceLists()
    {
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh');   
        $suppliers=Supplier::where('active',1)->where('type',1)->get();
        $deliveries=Delivery::where('active',1)->get();
        $law=Law::where('active',1)->get();
        
        $invoices=Sale::whereDate('created_at',$current)->orderBy('id','asc')->paginate(10);
        $items=Product::all();
        return view('sales.invoicelist',compact('invoices','suppliers','deliveries','items','law'));
    }
    public function invoicelistsearch(Request $request)
    {
        //return($request->all());
        if($request->ajax()){
           
            $start_date=date('Y-m-d',strtotime($request->start_date));
            $end_date=date('Y-m-d',strtotime($request->end_date));
            
            // $invoices=Purchase::whereDate('created_at','>=',$start_date)
            //                  ->whereDate('created_at','<=',$end_date);
            if($request->search_by=='barcode'){
                $invoices = Sale::join('sale_details','sales.id','=','sale_details.sale_id')
                                ->whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sale_details.barcode',$request->barcode)
                                ->select('sales.*')
                                ->distinct()
                                ->paginate(10);

            }
            else if($request->search_by=='productcode'){
                $invoices = Sale::join('sale_details','sales.id','=','sale_details.sale_id')
                                ->whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sale_details.product_id',$request->productcode)
                                ->select('sales.*')
                                ->distinct()
                                ->paginate(10);
            }
            else if($request->search_by=='supplier'){
                if($request->supplier==0){
                    $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->orderBy('id')
                                ->paginate(10);
                }else{
                    $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.supplier_id',$request->supplier)
                                ->orderBy('id')
                                ->paginate(10);
                }
                
            }
            else if($request->search_by=='delivery'){
                if($request->delivery==0){
                     $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->orderBy('id')
                                ->paginate(10);
                }else{
                     $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.delivery_id',$request->delivery)
                                ->orderBy('id')
                                ->paginate(10);
                }
               
            }
            else if($request->search_by=='law'){
                if($request->law==0){
                    $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->orderBy('id')
                                ->paginate(10);
                }else{
                    $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.law_id',$request->law)
                                ->orderBy('id')
                                ->paginate(10);
                }
                
            }
            else if($request->search_by=='invoice'){
                $invoices = Sale::where('id',$request->invoice)->paginate(10);
                                
            }
            else{

                $invoices=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                                    ->orderBy('id','asc')
                                    ->paginate(10);
            }
           
        }
        
             return view('sales.salelist',compact('invoices'));
        
    }

    public function paginate_fetch_data(Request $request)
    {
        //return($request->all());
        if($request->ajax()){
            $start_date=date('Y-m-d',strtotime($request->start_date));
            $end_date=date('Y-m-d',strtotime($request->end_date));
            if($request->search_by=='barcode'){
                 $invoices = Sale::join('sale_details','sales.id','=','sale_details.sale_id')
                                ->whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sale_details.barcode',$request->search_val)
                                ->select('sales.*')
                                ->distinct()
                                ->paginate(10);
            }else if($request->search_by=='productcode'){
                $invoices = Sale::join('sale_details','sales.id','=','sale_details.sale_id')
                                ->whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sale_details.product_id',$request->search_val)
                                ->select('sales.*')
                                ->distinct()
                                ->paginate(10);
            }else if($request->search_by=='supplier'){
                if($request->search_val==0){
                    $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.supplier_id','<>',$request->search_val)
                                ->orderBy('id')
                                ->paginate(10);
                }else{
                    $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.supplier_id',$request->search_val)
                                ->orderBy('id')
                                ->paginate(10);
                }
                
            }else if($request->search_by=='delivery'){
                if($request->search_val==0){
                    $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                 ->orderBy('id')
                                 ->paginate(10);
                }else{
                    $invoices = Sale::whereBetween(DB::raw('DATE(sales.invdate)'), array($start_date, $end_date))
                                ->where('sales.delivery_id',$request->search_val)
                                 ->paginate(10);
                }
                
            }else if($request->search_by=='date'){
                  $invoices=Sale::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                                    ->orderBy('id','asc')
                                    ->paginate(10);
            }

           
            return view('sales.salelist',compact('invoices'))->render();
        }
    }
   
    public function invoicelistedit($saleid)
    {

        $invoices=Sale::findOrFail($saleid);
        if(!is_null($invoices)){
            $suppliers=Supplier::where('active',1)->where('type',1)->get();
            $buyfrom=Supplier::where('active',1)->where('type',0)->get();
            $deliveries=Delivery::where('active',1)->get();
            $co=Law::where('active',1)->get();
            $cats=Category::where('active',1)->get();
            $invoices=Sale::join('sale_details','sales.id','=','sale_details.sale_id')
                            ->join('products','sale_details.product_id','=','products.id')
                            ->join('users','sales.user_id','=','users.id')
                            ->where('sales.id',$saleid)
                            ->whereNull('sale_details.deleted_at')
                            ->select('sales.*','sale_details.*','products.name as productname','sales.discount as invdiscount','users.name as username','sales.id as invid')
                            ->orderBy('sale_details.id','DESC')
                            ->get();
            //dump($invoices); 
                return view('sales.sale-edit',compact('invoices','suppliers','deliveries','co','buyfrom','cats'));
            }else{
                return("Not found");
            } 
    }

    
   
    public function edititemaftersubmit(Request $request)
    {
        $resetsubmit=1;
        $sdate=date('Y-m-d',strtotime($request->dd));
        $delstock=DB::table('stock_processes')->where('product_id',$request->pid)->whereDate('dd','=',$sdate)->where('mode',-1)->delete();
        $pstock=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->sum('quantity');
                DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock]);
        if($delstock){
                $resetsubmit=DB::table('sale_details')->whereDate('submitdate',$sdate)->where('product_id',$request->pid)->whereNull('deleted_at')->update(['submit'=>false]);
        }

        return response($resetsubmit);
    }

}
