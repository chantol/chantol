<?php

namespace App\Http\Controllers;
use App\Sale_Detail;
use App\Purchase_Detail;
use Illuminate\Http\Request;
use DB;
use App\Supplier;
use App\Delivery;
use App\Law;
use App\Product;
use Excel;

class ReportController extends Controller
{
    public function autoprinttest()
    {
        return view('script.testprint');
    }
    public function scorereport()
    {
        $customers=Supplier::where('active',1)->where('type',1)->get();
        
        return view('reports.scorereport',compact('customers'));
    }
    public function getitemsalescore(Request $request)
    {
        $supid=0;
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        if($request->cusid==0){
            $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')->join('suppliers','sales.supplier_id','=','suppliers.id')
                ->select(DB::raw('sum(qtyunit) as sumqty,sale_details.product_id,suppliers.name as cusname,sales.supplier_id'))
                ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                ->groupBy('sales.supplier_id')
                ->groupBy('sale_details.product_id')
                ->get();
        }else{
            $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')->join('suppliers','sales.supplier_id','=','suppliers.id')
                ->select(DB::raw('sum(qtyunit) as sumqty,sale_details.product_id,suppliers.name as cusname,sales.supplier_id'))
                ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                ->where('sales.supplier_id',$request->cusid)
                ->groupBy('sales.supplier_id')
                ->groupBy('sale_details.product_id')
                ->get();
        }
        
        return view('reports.productsalescore',compact('itemsales','supid'));
       
    }
    public function salereport()
    {
        $suppliers=Supplier::where('active',1)->where('type',1)->get();
        $deliveries=Delivery::where('active',1)->get();
        $lawfees=Law::where('active',1)->get();
    	return view('reports.salereport',compact('suppliers','deliveries','lawfees'));
    }
    public function getitemsale(Request $request)
    {
        $supid=0;
    	$d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        if($request->g1=='products.category_id'){
             $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')->join('products','sale_details.product_id','=','products.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur,products.category_id'))
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                    ->groupBy('products.category_id')
                    ->groupBy('sale_details.product_id')
                    ->groupBy('sales.invdate')
                    ->groupBy('sale_details.cur')
                    ->get();
        }else{
             $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur'))
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                    ->groupBy($request->g1)
                    ->groupBy($request->g2)
                    ->groupBy('sale_details.cur')
                    ->get();
        }
       
       
        if($request->g1=='sales.invdate'){
            return view('reports.productsale',compact('itemsales','supid'));
        }elseif($request->g1=='sale_details.product_id'){
            return view('reports.productsale_byitem',compact('itemsales','supid'));
        }elseif($request->g1=='products.category_id'){
            return view('reports.productsale_bycat',compact('itemsales','supid'));
        }
    }

    public function reportsaleprint(Request $request)
    {
        $supid=0;
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        if($request->g1=='products.category_id'){
             $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')->join('products','sale_details.product_id','=','products.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur,products.category_id'))
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                    ->groupBy('products.category_id')
                    ->groupBy('sale_details.product_id')
                    ->groupBy('sales.invdate')
                    ->groupBy('sale_details.cur')
                    ->get();
        }else{
             $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur'))
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                    ->groupBy($request->g1)
                    ->groupBy($request->g2)
                    ->groupBy('sale_details.cur')
                    ->get();
        }
       
       
        if($request->g1=='sales.invdate'){
            return view('reports.productsaleprint',compact('itemsales','supid'));
        }elseif($request->g1=='sale_details.product_id'){
            return view('reports.productsale_byitemprint',compact('itemsales','supid'));
        }elseif($request->g1=='products.category_id'){
            return view('reports.productsale_bycatprint',compact('itemsales','supid'));
        
    }
}

    public function exportsalereport(Request $request)
    {
        $supid=0;
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        // if($request->g1=='products.category_id'){
        //      $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')->join('products','sale_details.product_id','=','products.id')
        //             ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur,products.category_id'))
        //             ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
        //             ->groupBy('products.category_id')
        //             ->groupBy('sale_details.product_id')
        //             ->groupBy('sales.invdate')
        //             ->groupBy('sale_details.cur')
        //             ->get()->toArray();
        // }else{
        //      $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
        //             ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur'))
        //             ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
        //             ->groupBy($request->g1)
        //             ->groupBy($request->g2)
        //             ->groupBy('sale_details.cur')
        //             ->get()->toArray();
        // }
       $itemsales=DB::table('sale_details')->join('sales','sale_details.sale_id','=','sales.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur'))
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                    ->groupBy($request->g1)
                    ->groupBy($request->g2)
                    ->groupBy('sale_details.cur')
                    ->get()->toArray();
       $report_data[]=array('Qty','Price','Amount','FOCunit','Tcost');
       foreach ($itemsales as $key => $itemsale) {
           $report_data[]=array(
            'Qty'       => $itemsale->sumqty,
            'Price'     => $itemsale->avgprice,
            'Amount'    => $itemsale->sumamount,
            'FOCunit'   => $itemsale->focqty,
            'Tcost'     => $itemsale->tcost

           );
       }
        Excel::create('Report Date',function($excel) use($report_data){
            $excel->setTitle('Report Data');
            $excel->sheet('Report Date',function($sheet) use($report_data){
                $sheet->fromArray($report_data,null,'A1',false,false);
            });
        })->download('xlsx');
    }


     function excel()
    {
     $customer_data = DB::table('suppliers')->get()->toArray();
     $customer_array[] = array('Name', 'Sex', 'Tel');
     foreach($customer_data as $customer)
     {
      $customer_array[] = array(
       'Name'  => $customer->name,
       'Sex'   => $customer->sex,
       'Tel'    => $customer->tel
      
      );
     }
     Excel::create('Customer Data', function($excel) use ($customer_array){
      $excel->setTitle('Customer Data');
      $excel->sheet('Customer Data', function($sheet) use ($customer_array){
       $sheet->fromArray($customer_array, null, 'A1', false, false);
      });
     })->download('xlsx');
    }


     public function getitemsaleforeq(Request $request)
    {
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,sum(focunit) as focqty,sale_details.product_id,sale_details.cur'))
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                    ->groupBy('sale_details.product_id')
                    ->groupBy('sale_details.cur')
                    ->get();
        
            return view('reports.productsale_eq',compact('itemsales'));
       
    }
    public function getitemsalebycustomer(Request $request)
    {
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        $supid=$request->supplierid;
        if($request->g1=='products.category_id'){
            $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')->join('products','sale_details.product_id','=','products.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur,products.category_id'))
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                    ->where('sales.supplier_id',$request->supplierid)
                    ->groupBy('products.category_id')
                    ->groupBy('sale_details.product_id')
                    ->groupBy('sales.invdate')
                    ->groupBy('sale_details.cur')
                    ->get();
        }else{
            $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur'))
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                    ->where('sales.supplier_id',$request->supplierid)
                    ->groupBy($request->g1)
                    ->groupBy($request->g2)
                    ->groupBy('sale_details.cur')
                    ->get();
        }
        if($request->g1=='sales.invdate'){
            return view('reports.productsale',compact('itemsales','supid'));
        }elseif($request->g1=='sale_details.product_id'){
            return view('reports.productsale_byitem',compact('itemsales','supid'));
        }elseif($request->g1=='products.category_id'){
            return view('reports.productsale_bycat',compact('itemsales','supid'));
        }
       

    }
     public function getitemsalebyitem(Request $request)
    {
        $supid=0;
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        $pid=Product::where('name',$request->item)->first();
        //dump($pid->id);
        if($pid){
            $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur'))
                    ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
                    ->where('sale_details.product_id',$pid->id)
                    ->groupBy('sales.invdate')
                    ->groupBy('sale_details.product_id')
                    ->groupBy('sale_details.cur')
                    ->get();
                    return view('reports.productsale_byitem',compact('itemsales','supid'));
        }
        

    }
    public function salereportshowdetail($pid,$invdate,$supid)
    {
        $supname='ទាំងអស់';
        if($supid==0){
            $saledetails=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
                            ->where('sale_details.product_id',$pid)
                            ->where('sales.invdate',$invdate)
                            ->get();
        }else{
            $sname=Supplier::where('id',$supid)->first();
            $supname=$sname->name;
            $saledetails=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
                            ->where('sale_details.product_id',$pid)
                            ->where('sales.invdate',$invdate)
                            ->where('sales.supplier_id',$supid)
                            ->get();
        }
        
        return view('reports.showsaledetail',compact('saledetails','supname'));
    }
    //--------------------------------purchase report-----------------------------------
    public function buyreport()
    {
        $suppliers=Supplier::where('active',1)->where('type',0)->get();
       
        return view('reports.buyreport',compact('suppliers'));
    }
    public function getitembuy(Request $request)
    {
        $supid=0;
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        if($request->g1=='products.category_id'){
             $itemsales=Purchase_Detail::join('purchases','purchase_details.purchase_id','=','purchases.id')->join('products','purchase_details.product_id','=','products.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,purchase_details.product_id,purchases.invdate,purchase_details.cur,products.category_id'))
                    ->whereBetween(DB::raw('DATE(purchases.invdate)'), array($d1, $d2))
                    ->groupBy('products.category_id')
                    ->groupBy('purchase_details.product_id')
                    ->groupBy('purchases.invdate')
                    ->groupBy('purchase_details.cur')
                    ->get();
        }else{
             $itemsales=Purchase_Detail::join('purchases','purchase_details.purchase_id','=','purchases.id')->join('products','purchase_details.product_id','=','products.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,purchase_details.product_id,purchases.invdate,purchase_details.cur,products.category_id'))
                    ->whereBetween(DB::raw('DATE(purchases.invdate)'), array($d1, $d2))
                    ->groupBy($request->g1)
                    ->groupBy($request->g2)
                    ->groupBy('purchase_details.cur')
                    ->get();
        }
       
       
        if($request->g1=='purchases.invdate'){
            return view('reports.productbuy',compact('itemsales','supid'));
        }elseif($request->g1=='purchase_details.product_id'){
            return view('reports.productbuy_byitem',compact('itemsales','supid'));
        }elseif($request->g1=='products.category_id'){
            return view('reports.productbuy_bycat',compact('itemsales','supid'));
        }
    }
     public function getitembuyforeq(Request $request)
    {
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        $itemsales=Purchase_Detail::join('purchases','purchase_details.purchase_id','=','purchases.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,sum(focunit) as focqty,purchase_details.product_id,purchase_details.cur'))
                    ->whereBetween(DB::raw('DATE(purchases.invdate)'), array($d1, $d2))
                    ->groupBy('purchase_details.product_id')
                    ->groupBy('purchase_details.cur')
                    ->get();
        
            return view('reports.productbuy_eq',compact('itemsales'));
       
    }
    public function getitembuybycustomer(Request $request)
    {
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        $supid=$request->supplierid;
        if($request->g1=='products.category_id'){
            $itemsales=Purchase_Detail::join('purchases','purchase_details.purchase_id','=','purchases.id')->join('products','purchase_details.product_id','=','products.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,purchase_details.product_id,purchases.invdate,purchase_details.cur,products.category_id'))
                    ->whereBetween(DB::raw('DATE(purchases.invdate)'), array($d1, $d2))
                    ->where('purchases.supplier_id',$request->supplierid)
                    ->groupBy('products.category_id')
                    ->groupBy('purchase_details.product_id')
                    ->groupBy('purchases.invdate')
                    ->groupBy('purchase_details.cur')
                    ->get();
        }else{
            $itemsales=Purchase_Detail::join('purchases','purchase_details.purchase_id','=','purchases.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,purchase_details.product_id,purchases.invdate,purchase_details.cur'))
                    ->whereBetween(DB::raw('DATE(purchases.invdate)'), array($d1, $d2))
                    ->where('purchases.supplier_id',$request->supplierid)
                    ->groupBy($request->g1)
                    ->groupBy($request->g2)
                    ->groupBy('purchase_details.cur')
                    ->get();
        }
        if($request->g1=='purchases.invdate'){
            return view('reports.productbuy',compact('itemsales','supid'));
        }elseif($request->g1=='purchase_details.product_id'){
            return view('reports.productbuy_byitem',compact('itemsales','supid'));
        }elseif($request->g1=='products.category_id'){
            return view('reports.productbuy_bycat',compact('itemsales','supid'));
        }
       

    }
     public function getitembuybyitem(Request $request)
    {
        $supid=0;
        $d1=date('Y-m-d',strtotime($request->d1));
        $d2=date('Y-m-d',strtotime($request->d2));
        $pid=Product::where('name',$request->item)->first();
        //dump($pid->id);
        if($pid){
            $itemsales=Purchase_Detail::join('purchases','purchase_details.purchase_id','=','purchases.id')
                    ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,purchase_details.product_id,purchases.invdate,purchase_details.cur'))
                    ->whereBetween(DB::raw('DATE(purchases.invdate)'), array($d1, $d2))
                    ->where('purchase_details.product_id',$pid->id)
                    ->groupBy('purchases.invdate')
                    ->groupBy('purchase_details.product_id')
                    ->groupBy('purchase_details.cur')
                    ->get();
                    return view('reports.productbuy_byitem',compact('itemsales','supid'));
        }
        

    }
    public function buyreportshowdetail($pid,$invdate,$supid)
    {
        $supname='ទាំងអស់';
        if($supid==0){
            $saledetails=Purchase_Detail::join('purchases','purchase_details.purchase_id','=','purchases.id')
                            ->where('purchase_details.product_id',$pid)
                            ->where('purchases.invdate',$invdate)
                            ->get();
        }else{
            $sname=Supplier::where('id',$supid)->first();
            $supname=$sname->name;
             $saledetails=Purchase_Detail::join('purchases','purchase_details.purchase_id','=','purchases.id')
                            ->where('purchase_details.product_id',$pid)
                            ->where('purchases.invdate',$invdate)
                            ->where('purchases.supplier_id',$supid)
                            ->get();
        }
        
        return view('reports.showbuydetail',compact('saledetails','supname'));
    }
}
