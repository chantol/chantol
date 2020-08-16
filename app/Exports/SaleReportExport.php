<?php

namespace App\Exports;
use DB;
use App\Sale_Detail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class SaleReportExport implements FromCollection,WithHeadings
{
   protected $request;
	public function __construct($request)
	{
	   $this->request = $request;
	} 
    public function collection()
    {
       // $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
       //              ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur'))
       //              ->whereBetween(DB::raw('DATE(sales.invdate)'), array($this->request->d1, $this->request->d2))
       //              ->groupBy($this->request->g1)
       //              ->groupBy($this->request->g2)
       //              ->groupBy('sale_details.cur')
       //              ->get();
    	$d1=date('Y-m-d',strtotime($this->request->start_date));
    	$d2=date('Y-m-d',strtotime($this->request->end_date));
    	
	     $itemsales=Sale_Detail::join('sales','sale_details.sale_id','=','sales.id')
	                ->select(DB::raw('sum(qtyunit) as sumqty,sum(amount-(amount*invdiscount)/100) as sumamount,avg(unitprice) as avgprice,sum(focunit) as focqty,sum(costex * (qtyunit+focunit)) as tcost,sale_details.product_id,sales.invdate,sale_details.cur'))
	                ->whereBetween(DB::raw('DATE(sales.invdate)'), array($d1, $d2))
	                ->groupBy('sales.invdate')
	                ->groupBy('sale_details.product_id')
	                ->groupBy('sale_details.cur')
	                ->get();

    	$output = [];

	    foreach ($itemsales as $is)
	    {
	      $output[] = [
	      	date('d-m-Y',strtotime($is->invdate)),
	      	$is->product_id,
	      	$is->product->name,

	        $is->sumqty . $is->product->itemunit,
	        Sale_Detail::convertqtysale($is->product_id,$is->sumqty),
	        Sale_Detail::phpformatnumber($is->avgprice) . $is->cur,
	        Sale_Detail::phpformatnumber($is->sumamount) . $is->cur,
	        $is->focqty . $is->product->itemunit,
	        Sale_Detail::phpformatnumber($is->tcost) . $is->cur,
	        Sale_Detail::phpformatnumber($is->sumamount-$is->tcost) . $is->cur,
	      ];
	    }

    	return collect($output);
    }

     public function headings(): array
    {
        return [
        	'ថ្ងៃទី',
        	'លេខកូដ',
            'ឈ្មោះទំនិញ',
            'ចំនួនរាយ',
            'ចំនួនលក់',
            'មធ្យមតំលៃ',
            'សរុបទឹកប្រាក់',
            'ថែមរាយ',
            'ថ្លៃដើម',
           	'ប្រាក់ចំណេញ',
        ];
    }

     
}
