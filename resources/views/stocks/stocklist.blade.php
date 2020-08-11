
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
<div class="table-responsive">
	<table class="table table-hover table-bordered" style="table-layout:auto;width:100%;">
		<thead style="font-weight:bold;">
           <tr>
				<td class="text-center">N <sup>o</sup></td>
				<td class="text-center">ID</td>
				<td class="text-center">Product Code</td>
				<td class="text-center">Product Name</td>
				<td class="text-center">Group</td>
				<td class="text-center">Brand</td>
				<td class="text-center">Stock</td>
				
				<td class="text-center">Stock Unit</td>
				<td class="text-center">Cost Price</td>
				<td class="text-center">Stock Amount</td>
				<td class="text-center">Exchange Amount</td>
				<td class="text-center colaction">Action</td>
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

					<td style="text-align:center;" class="colaction">
						<a href="#" class="btn btn-warning btn-xs btnviewstockproccess" title="view detail" data-id="{{ $stock->id }}" data-code="{{ $stock->code }}" data-name="{{ $stock->name }}"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-info btn-xs btnclosestock" title="Close Stock" data-id="{{ $stock->id }}" data-code="{{ $stock->code }}" data-name="{{ $stock->name }}" data-unit="{{ $stock->itemunit }}" data-cost="{{ $stock->costprice }}" data-cur="{{ $stock->cur }}" data-stock="{{ $stock->stock }}"><i class="fa fa-square-o"></i></a>
					</td>
					
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
					<td colspan=3></td>
					<td style="text-align:center;" colspan=2><strong> Total USD: {{ phpformatnumber($t_usd) }} &nbsp; $ </strong></td>
					
					<td style="text-align:center;" colspan=2><strong> Total THB: {{ phpformatnumber($t_thb) }} &nbsp; B</strong></td>
					
					<td style="text-align:center;" colspan=2><strong> Total KHR: {{ phpformatnumber($t_khr) }} &nbsp; R</strong></td>
					
					<td style="text-align:center;" colspan=2><strong> Total all: {{ phpformatnumber($allinone) }} &nbsp; {{ $stockcur }}</strong></td>
					
					<td style="text-align:center;padding:3px;" class="colaction">
						<button class="btn btn-primary btn-sm" id="btnprintstock">Print Stock</button>
						
					</td>
					
				</tr>
		</tbody>
	</table>
	
	
</div>
		

