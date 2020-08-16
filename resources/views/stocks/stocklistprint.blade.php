@extends('layouts.master')
@section('pagetitle')
	Print Stock
@endsection
@section('css')
	<style type="text/css" media="print">
		  @page { size: a4 landscape;
		  margin: 10mm 5mm 10mm 5mm;
		   }
		   div.pagebreak, div.appendix {
    		page-break-after: always;}

		  .tblright{
		  	position:relative;
		  	left:0px;
		  }
		  .footer {
		   position: fixed;
		   left: 0;
		   bottom: 0;
		   width: 100%;
		   background-color: red;
		   color: white;
		   text-align: center;
		}
		table.a {
		  table-layout: fixed;
		  width: 100%;  
		}
		table.b{
			width:100%;
		}
	</style>
@endsection
	@section('content')
@php
	$myfile = fopen("stockcurrency.txt", "r") or die("Unable to open file!");
	//$myfile = fopen("E:\PHPfile\best.txt", "r") or die("Unable to open file!");
	$stockcur= fgets($myfile);
	fclose($myfile);
	function phpformatnumber($num){
		$dc=0;
		$p=strpos((float)$num,'.');
		if($p>0){
			$fp=substr($num,$p,strlen($num)-$p);
			$dc=strlen((float)$fp)-2;
			
		}
		if($dc>2){
			$dc=2;
		}
		return number_format($num,$dc,'.',',');
	}
@endphp
<div class="table-responsive" style="overflow:auto;" id="printarea">
	<p style="font-family:khmer os system;">របាយការណ៌ស្តុក សំរាប់ថ្ងៃទី: {{ date('d-m-Y',strtotime($stockdate)) }}</p>
	<table class="table table-hover table-bordered" style="table-layout:auto;width:100%;">
		<thead style="font-weight:bold;">
           <tr style="font-family:khmer os system">
				<td class="text-center">លរ</td>
				<td class="text-center">អាយឌី</td>
				<td class="text-center">លេខកូដទំនិញ</td>
				<td class="text-center">ឈ្មោះទំនិញ</td>
				<td class="text-center">ក្រុមទំនិញ</td>
				<td class="text-center">ប្រភេទទំនិញ</td>
				<td class="text-center">ស្តុក</td>
				
				<td class="text-center">ស្តុករាយ</td>
				<td class="text-center">ថ្លៃដើមស្តុក</td>
				<td class="text-center">សរុបទឹកប្រាក់</td>
				<td class="text-center">ប្តូរប្រាក់</td>
				
            </tr>
		</thead>
		<tbody id="stocklist">

			@foreach ($stocks as $key => $stock)
				<tr>
					<td style="width:60px;text-align:center;">{{ ++ $key }}</td>
					<td>{{ $stock->id }}</td>
					<td>{{ $stock->code }}</td>
					<td style="font-family:khmer os system;">{{ $stock->name }}</td>
					<td style="font-family:khmer os system;">{{ $stock->category->name }}</td>
					<td style="font-family:khmer os system;">{{ $stock->brand->name }}</td>
					<td style="font-family:khmer os system;text-align:center;">{{ App\Sale_Detail::convertqtysale($stock->id,$stock->stock) }}</td>
					<td style="font-family:khmer os system;text-align:center;">{{ $stock->stock }} &nbsp; {{ $stock->itemunit }}</td>
					<td style="text-align:right;">{{ phpformatnumber($stock->costprice) }} {{ $stock->cur }}</td>
					<td style="text-align:right;" class="totalamount">{{ phpformatnumber($stock->costprice * $stock->stock) }} {{ $stock->cur }}</td>
					<td style="text-align:right;">{{ phpformatnumber(App\Purchase_Detail::exchangecurrency($stock->cur,$stockcur,$stock->costprice * $stock->stock)) . ' ' . $stockcur}}</td>

					
					
				</tr>
			@endforeach
				<tr>
					@php
						$t_usd=0;
						$t_khr=0;
						$t_thb=0;
						$allinone=0;
						
					@endphp
					@foreach ($totalstock as $tt)
						@php
							if ($tt->cur=="R"){
								$t_khr=$tt->tstock;
								$allinone += App\Purchase_Detail::exchangecurrency($tt->cur,$stockcur,$t_khr);
							}
							if ($tt->cur=="B"){
								$t_thb=$tt->tstock;
								$allinone += App\Purchase_Detail::exchangecurrency($tt->cur,$stockcur,$t_thb);
							}
							if ($tt->cur=="$"){
								$t_usd=$tt->tstock;
								$allinone += App\Purchase_Detail::exchangecurrency($tt->cur,$stockcur,$t_usd);
							}
							
						@endphp
					@endforeach
					<td colspan=3 style="font-family:khmer os system">សរុបទឹកប្រាក់</td>
					<td style="text-align:center;" colspan=2><strong>  {{ phpformatnumber($t_usd) }}  $ </strong></td>
					
					<td style="text-align:center;" colspan=2><strong>  {{ phpformatnumber($t_thb) }}  B</strong></td>
					
					<td style="text-align:center;" colspan=2><strong>  {{ phpformatnumber($t_khr) }}  R</strong></td>
					
					<td style="text-align:center;" colspan=2><strong> All In One: {{ phpformatnumber($allinone) }} {{ $stockcur }}</strong></td>
					
					
					
				</tr>
		</tbody>
	</table>
	
	
</div>
		
@endsection
@section('script')

	<script type="text/javascript">
		
			printContent('printarea');
			function printContent(el)
			{
			
			  //var restorpage=document.body.innerHTML;
			  var printloc=document.getElementById(el).innerHTML;
			  document.body.innerHTML=printloc;
			  window.print();
			  window.onafterprint = function(){ window.close()};
			  //history.back(); 
			  //document.body.innerTHML=restorpage;
			  
			}
		</script>
@endsection