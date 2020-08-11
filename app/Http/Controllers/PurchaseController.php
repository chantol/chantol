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
use App\Purchase_Payment;
use App\Category;
class PurchaseController extends Controller
{
    public function readcustomerdebtname(Request $request)
    {
           // return($request->all());
        $output='';
        
        $customers=supplier::where('name_slug','like','%'. preg_replace('/\s+/', '', $request->q) .'%')->where('type',0)->get();
        
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
     public function accountpay(Request $request)
    {
        $invoices=Purchase::where('balance','=',-1)
        ->orderBy('id','asc')
        ->get();
        $customers=Purchase::where('balance','>',0)->select('supplier_id')->distinct()->get();
        return view('purchases.accountpay',compact('customers','invoices'));
    }
    public function invoicelistsearchforpay(Request $request)
    {
        //return ($request->all());
        if($request->ajax()){
            $start_date=date('Y-m-d',strtotime($request->start_date));
            $end_date=date('Y-m-d',strtotime($request->end_date));
            if($request->alldate=='true'){
                
                 $invoices=Purchase::where('supplier_id',$request->cid)
                                    ->where('balance',$request->operater,'0')
                                    ->orderBy('id','asc')
                                    ->get();
            }else{
               
                 $invoices=Purchase::where('supplier_id',$request->cid)
                                    ->whereBetween(DB::raw('DATE(purchases.invdate)'), array($start_date, $end_date))
                                    ->where('balance',$request->operater,'0')
                                    ->orderBy('id','asc')
                                    ->get();
            }
            return view('purchases.p_invoice',compact('invoices')); 
        }
    }
    public function printallinv(Request $request)
    {
        //return($request->all());
        $start_date=date('Y-m-d',strtotime($request->start_date));
        $end_date=date('Y-m-d',strtotime($request->end_date));
        $invs=Purchase::whereBetween(DB::raw('DATE(purchases.invdate)'), array($start_date, $end_date))
                                ->orderBy('id','ASC');
                               
        if($request->supplier){
            $invoices=$invs->where('supplier_id',$request->supplier)->get();
        }else if($request->delivery){
             $invoices=$invs->where('delivery_id',$request->supplier)->get();
        }else if($request->items){
             
             $invoices = Purchase::join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                                ->whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchase_details.product_id',$request->items)
                                ->select('purchases.*')
                                ->distinct()
                                ->get();
        }else if($request->productcode){
              $invoices = Purchase::join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                                ->whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchase_details.product_id',$request->productcode)
                                ->select('purchases.*')
                                ->distinct()
                                ->get();
        }else if($request->barcode){
              $invoices = Purchase::join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                                ->whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchase_details.barcode',$request->barcode)
                                ->select('purchases.*')
                                ->distinct()
                                ->get();
        
        }else{
            $invoices=$invs->get();
        }
        
        return view('purchases.printmultiinv',compact('invoices'));
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
                $invoices = Purchase::whereBetween(DB::raw('DATE(purchases.invdate)'), array($start_date, $end_date))
                                ->where('purchases.supplier_id',$request->supplier)
                                ->whereBetween('p_paid',array($a,$b))
                                ->get();
            }else if($request->delivery){
                $invoices = Purchase::whereBetween(DB::raw('DATE(purchases.invdate)'), array($start_date, $end_date))
                                ->where('purchases.delivery_id',$request->delivery)
                                ->whereBetween('p_paid',array($a,$b))
                                ->get();
            }else if($request->invoice){
                $invoices = Purchase::where('purchases.id',$request->invoice)->get();
            }
            
            else{
                $invoices=Purchase::whereBetween(DB::raw('DATE(invdate)'), array($start_date, $end_date))
                                    ->whereBetween('p_paid',array($a,$b))
                                    ->orderBy('id','asc')
                                    ->get();
            }
           
        }
        
            return view('purchases.p_invoice',compact('invoices')); 
            //return response($invoices);
    }
    public function showpurchasedetail(Request $request)
    {
        if($request->ajax()){
            $pdt=Purchase_Detail::where('purchase_id',$request->id)->orderBy('id','ASC')->get();
            return view('purchases.p_invoice_detail_items',compact('pdt'));
        }
    }
    public function showpaiddetail(Request $request)
    {
        if($request->ajax()){
            $tpaid=Purchase_Payment::where('purchase_id',$request->id)->sum('paidamt');
            $pdt=Purchase_Payment::where('purchase_id',$request->id)->orderBy('id','ASC')->get();
            //dump($tpaid);
            return view('purchases.paidlist_modal_body',compact('pdt','tpaid'));
        }
    }
    public function totalinvpaid(Request $request)
    {
        if($request->ajax()){
            $buyinv = trim((int)$request->buyinv);
            $totalpaid=DB::table('purchase_payments')
            ->select(DB::raw('sum(paidamt) as totalpaid'))
            ->where('purchase_id',$buyinv)
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
            DB::table('purchase_payments')->where('id',$request->id)->delete();
            $tpaid=Purchase_Payment::where('purchase_id',$buyinv)->sum('paidamt');
            
            $paidps=floor((float)$tpaid / (float)$totalinv) * 100;
            $bal=$totalinv - $tpaid;
            DB::table('purchases')->where('id',$buyinv)->update(['deposit'=>$tpaid,'p_paid'=>$paidps,'balance'=>$bal]);

            $pdt=Purchase_Payment::where('purchase_id',$buyinv)->orderBy('id','ASC')->get();
            return view('purchases.paidlist_modal_body',compact('pdt','tpaid'));


        }
    }
    public function paid()
    {
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh');   
        $suppliers=Supplier::where('active',1)->where('type',0)->get();
        $deliveries=Delivery::where('active',1)->get();
        $invoices=Purchase::whereDate('created_at',$current)
        ->whereBetween('p_paid',array(0,99))
        ->orderBy('id','asc')
        ->get();
        $items=Product::all();
        return view('purchases.purchasepaid',compact('invoices','suppliers','deliveries','items'));
    }
    function savepaid(Request $request)
    {

        $dd = Carbon::now();
        $dd->timezone('Asia/Phnom_Penh'); 
        $payondate=date('Y-m-d',strtotime($request->paydate));
        foreach ($request->paid_inv as $key => $value) {
            $data=array('purchase_id'=>(int)$value,
                        'user_id'=>$request->user_id,
                        'dd'=>$payondate,
                        'paidamt'=>str_replace(',','',$request->paid_deposit[$key]),
                        'cur'=>$request->getpaidcur,
                        'paynote'=>$request->paynote,
                        'paymethod'=>$request->paymethod,
                        'created_at'=>$dd,
                        'updated_at'=>$dd);
            if(purchase_payment::insert($data)){
                $olddep=str_replace(',','',str_replace($request->getpaidcur,'',$request->deposited[$key]));
                $newdep=str_replace(',','',$request->paid_deposit[$key]);
                $tdeposit= (float)$olddep+(float)$newdep;

                 DB::table('purchases')->where('id',(int)$value)->update(['p_paid'=>$request->pps[$key],'deposit'=>$tdeposit,'balance'=>abs($request->balance[$key])]);
            };

        }
        return response($tdeposit);
        
    }
    public function editpurchaseinv(Request $request)
    {
        if($request->ajax()){
            $pinv=DB::table('purchases')
                        ->join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                        ->join('products','purchase_details.product_id','=','products.id')
                        ->join('users','purchases.user_id','=','users.id')
                        ->join('suppliers','purchases.supplier_id','=','suppliers.id')
                        ->join('deliveries','purchases.delivery_id','=','deliveries.id')
                        ->select('products.*','purchase_details.*','purchase_details.discount as discount1','users.name as username','suppliers.name as supname','deliveries.name as dename','purchases.*','products.cur as cur_product','purchase_details.cur as cur_detail','purchase_details.id as idd')
                        ->where('purchases.id',$request->id)
                        ->whereNull('purchase_details.deleted_at')
                        ->orderBy('purchase_details.id','DESC')
                        ->get();
            return response($pinv);
        }
    }


  

    public function updatepurchase(Request $request)
    {
          //return($request->all());
          $validator = Validator::make($request->all(), [
            
            'productid.*' => 'required',
            'barcode.*' => 'required',
            'qty1.*' => 'required|numeric' //input array validate
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
            $p=Purchase::find($request->purchase_id);
            $p->invdate=$invdate;
            $p->user_id=$request->userid;
            $p->supplier_id=$request->sel_supplier;
            $p->delivery_id=$request->sel_delivery;
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
                $pdt=Purchase_Detail::where('purchase_id',$request->purchase_id);
                $pdt->delete();
                // foreach ($request->productid as $key => $value) {
                //     $data=array('purchase_id'=>$request->purchase_id,
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
                //                 'submit'=>$request->submit,
                //                 'submitdate'=>$invdate,
                //                 'created_at'=>$current,
                //                 'updated_at'=>$current);
                //     Purchase_Detail::insert($data);
                // }

                $countrow=count($request->productid)-1;
                for($key=$countrow;$key>=0;$key--){
                    $data=array('purchase_id'=>$request->purchase_id,
                                'product_id'=>$request->productid[$key],
                                'barcode'=>$request->barcode[$key],
                                'qty'=>$request->qty1[$key],
                                'unit'=>$request->unit1[$key],
                                'qtycut'=>$request->qty2[$key],
                                'quantity'=>$request->qty3[$key],
                                'unitprice'=>$request->unitprice[$key],
                                'discount'=>$request->discount[$key],
                                'amount'=> str_replace(',','',$request->amount[$key]) ,
                                'cur'=> $request->cur1[$key],
                                'focunit'=>$request->focunit[$key],
                                'sunit'=>$request->sunit[$key],
                                'multiunit'=>$request->multi[$key],
                                'qtyunit'=>(float)$request->qty3[$key]*(float)$request->multi[$key],
                                'submit'=>$request->submit[$key],
                                'submitdate'=>$invdate,
                                'invdiscount'=>$request->invdiscount,
                                'created_at'=>$current,
                                'updated_at'=>$current);
                    Purchase_Detail::insert($data);
                }

                return response()->json(['success'=>'Update order completed.']);
            }
        }
       
         return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function storepurchase(Request $request)
    {
        //return response($request->all());
        $validator = Validator::make($request->all(), [
            
            'productid.*' => 'required',
            'barcode.*' => 'required',
            'qty1.*' => 'required|numeric' //input array validate
        ]);

        
        $date = str_replace('/', '-', $request->invdate);
        $invdate= date('Y-m-d', strtotime($date));

        if ($validator->passes()) {
            $current = Carbon::now();
            $current->timezone('Asia/Phnom_Penh');
            $p=new Purchase;
            $p->invdate=$invdate;
            $p->user_id=$request->userid;
            $p->supplier_id=$request->sel_supplier;
            $p->delivery_id=$request->sel_delivery;
            $p->carnum=$request->carnum;
            $p->driver=$request->driver;
            $p->invnote=$request->invnote;
            $p->subtotal=str_replace(',','',$request->subtotal);
            $p->shipcost=$request->shipcost;
            $p->discount=$request->invdiscount;
            $p->total=str_replace(',','',$request->lasttotal);
            $p->cur=$request->lastcur;
            $p->deposit=0;
            $p->balance=str_replace(',','',$request->lasttotal);
            if($request->deposit>0){
                $p->deposit=str_replace(',','',$request->deposit);
                $p->balance=str_replace(',','',$request->lastbal);
            }
            $p->created_at=$current;
            $p->updated_at=$current;
            if ($p->save()) {
                $id=$p->id;
                // foreach ($request->productid as $key => $value) {
                //     $data=array('purchase_id'=>$id,
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
                //     Purchase_Detail::insert($data);
                //     }

                $countrow=count($request->productid)-1;
                for($key=$countrow;$key>=0;$key--){
                    $data=array('purchase_id'=>$id,
                                'product_id'=>$request->productid[$key],
                                'barcode'=>$request->barcode[$key],
                                'qty'=>$request->qty1[$key],
                                'unit'=>$request->unit1[$key],
                                'qtycut'=>$request->qty2[$key],
                                'quantity'=>$request->qty3[$key],
                                'unitprice'=>$request->unitprice[$key],
                                'discount'=>$request->discount[$key],
                                'amount'=> str_replace(',','',$request->amount[$key]) ,
                                'cur'=> $request->cur1[$key],
                                'focunit'=>$request->focunit[$key],
                                'sunit'=>$request->sunit[$key],
                                'multiunit'=>$request->multi[$key],
                                'qtyunit'=>(float)$request->qty3[$key]*(float)$request->multi[$key],
                                'submitdate'=>$invdate,
                                'invdiscount'=>$request->invdiscount,
                                'created_at'=>$current,
                                'updated_at'=>$current);
                    Purchase_Detail::insert($data);
                }
                if($request->deposit>0){
                    $spm=new purchase_payment;
                    $spm->purchase_id=$id;
                    $spm->user_id=$request->userid;
                    $spm->dd=$current;
                    $spm->paidamt=str_replace(',','',$request->deposit);
                    $spm->cur=$request->lastcur;
                    $spm->save();

                }
            }
            return response()->json(['success'=>'Save order completed.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
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
        $newsup->type=0;
        $newsup->save();
        if($newsup){
            return response($newsup);
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
        $suppliers=Supplier::where('active',1)->where('type',0)->get();
        $deliveries=Delivery::where('active',1)->get();
        $cats=Category::where('active',1)->get();
        $invoices=Purchase::whereDate('created_at',$current)->orderBy('id','asc')->get();
    	return view('purchases.index',compact('suppliers','deliveries','invoices','cats'));
    }
    public function SearchItemBarcode(Request $request)
    {
    	$data=ProductBarcode::join('products','product_barcodes.product_id','=','products.id')
    				->where('product_barcodes.barcode','=',$request->barcode)
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

    public function purchaseprint($id)
    {
        $pinv=Purchase::join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                        ->join('products','purchase_details.product_id','=','products.id')
                        ->join('users','purchases.user_id','=','users.id')
                        ->join('suppliers','purchases.supplier_id','=','suppliers.id')
                        ->join('deliveries','purchases.delivery_id','=','deliveries.id')
                        ->select('purchases.*','purchase_details.*','users.name as username','suppliers.name as supname','deliveries.name as dename','products.*','products.cur as productcur','purchases.cur as purcur','purchase_details.cur as cur')
                        ->where('purchases.id',$id)
                        ->get();
                        

                        //return($pinv);
        return view('purchases.purchase_invoice_print',compact('pinv'));
    }

    public function destroypurchase(Request $request)
    {
       $p=Purchase::findOrFail($request->id);
       if(!is_null($p)){
            if($p->delete()){
                $pd=Purchase_Detail::where('purchase_id',$request->id);
                $pd->delete();
               }
       }
    }

    public function invoiceLists()
    {
        $current = Carbon::now();
        $current->timezone('Asia/Phnom_Penh');   
        $suppliers=Supplier::where('active',1)->where('type',0)->get();
        $deliveries=Delivery::where('active',1)->get();
        $invoices=Purchase::whereDate('created_at',$current)->orderBy('id','asc')->paginate(10);
        $items=Product::all();
        return view('purchases.invoicelist',compact('invoices','suppliers','deliveries','items'));
    }
    public function invoicelistsearch(Request $request)
    {
        if($request->ajax()){
           
            $start_date=date('Y-m-d',strtotime($request->start_date));
            $end_date=date('Y-m-d',strtotime($request->end_date));
            
            // $invoices=Purchase::whereDate('created_at','>=',$start_date)
            //                  ->whereDate('created_at','<=',$end_date);
            if($request->barcode){
                $invoices = Purchase::join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                                ->whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchase_details.barcode',$request->barcode)
                                ->select('purchases.*')
                                ->distinct()
                                ->paginate(10);

            }
            else if($request->productcode){
                $invoices = Purchase::join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                                ->whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchase_details.product_id',$request->productcode)
                                ->select('purchases.*')
                                ->distinct()
                                ->paginate(10);
            }
            else if($request->supplier){
                $invoices = Purchase::whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchases.supplier_id',$request->supplier)
                                ->paginate(10);
            }
            else if($request->delivery){
                $invoices = Purchase::whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchases.delivery_id',$request->delivery)
                                ->paginate(10);
            }
            
            else{

                $invoices=Purchase::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
                                    ->orderBy('id','asc')
                                    ->paginate(10);
            }
           
        }
        
             return view('purchases.purchaselist',compact('invoices'));
        
        
        //return response($invoices);
        
    }
    public function paginate_fetch_data(Request $request)
    {
        if($request->ajax()){
            $start_date=date('Y-m-d',strtotime($request->start_date));
            $end_date=date('Y-m-d',strtotime($request->end_date));
            if($request->search_by=='barcode'){
                 $invoices = Purchase::join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                                ->whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchase_details.barcode',$request->search_val)
                                ->select('purchases.*')
                                ->distinct()
                                ->paginate(10);
            }else if($request->search_by=='productcode'){
                $invoices = Purchase::join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                                ->whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchase_details.product_id',$request->search_val)
                                ->select('purchases.*')
                                ->distinct()
                                ->paginate(10);
            }else if($request->search_by=='supplier'){
                $invoices = Purchase::whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchases.supplier_id',$request->search_val)
                                ->paginate(10);
            }else if($request->search_by=='delivery'){
                $invoices = Purchase::whereBetween(DB::raw('DATE(purchases.created_at)'), array($start_date, $end_date))
                                ->where('purchases.delivery_id',$request->search_val)
                                 ->paginate(10);
            }else if($request->search_by=='date'){
                  $invoices=Purchase::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
                                    ->orderBy('id','asc')
                                    ->paginate(10);
            }else{
                $invoices=Purchase::whereDate('created_at',$current)->orderBy('id','asc')->paginate(10);
            }

           
            return view('purchases.purchaselist',compact('invoices'))->render();
        }
    }
   
    public function invoicelistedit($purchaseid)
    {

        $invoices=Purchase::findOrFail($purchaseid);
        if(!is_null($invoices)){
            $suppliers=Supplier::where('active',1)->where('type',0)->get();
            $deliveries=Delivery::where('active',1)->get();
            $invoices=Purchase::join('purchase_details','purchases.id','=','purchase_details.purchase_id')
                            ->join('products','purchase_details.product_id','=','products.id')
                            ->join('users','purchases.user_id','=','users.id')
                            ->where('purchases.id',$purchaseid)
                            ->whereNull('purchase_details.deleted_at')
                            ->select('purchases.*','purchase_details.*','products.name as productname','purchases.discount as invdiscount','users.name as username','purchases.id as invid','purchase_details.cur as dcur')
                            ->orderBy('purchase_details.id','DESC')
                            ->get();
            //dump($invoices);
            
                return view('purchases.purchase-edit',compact('invoices','suppliers','deliveries'));
          
            }else{
                return("Not found");
            }
    }

     public function edititemaftersubmitin(Request $request)
    {
        $resetsubmit=1;
        $sdate=date('Y-m-d',strtotime($request->dd));
        $delstock=DB::table('stock_processes')->where('product_id',$request->pid)->whereDate('dd','=',$sdate)->where('mode',1)->delete();
        $pstock=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->sum('quantity');
        $avgcost=DB::table('stock_processes')->where('product_id',$request->pid)->where('active',1)->whereIn('mode',[0,1])->value(DB::raw("SUM(amount / quantity)"));
        if(is_null($avgcost)){
            $avgcost=0;
        }
                DB::table('products')->where('id',$request->pid)->update(['stock'=>$pstock,'costprice'=>$avgcost]);
        if($delstock){
                $resetsubmit=DB::table('purchase_details')->whereDate('submitdate',$sdate)->where('product_id',$request->pid)->whereNull('deleted_at')->update(['submit'=>false]);
        }

        return response($resetsubmit);
    }

}
