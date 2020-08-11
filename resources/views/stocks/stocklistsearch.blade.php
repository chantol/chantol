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
	<table class="table table-bordered table-hover">
		<thead style="font-weight:bold;">
           <tr style="font-family:khmer os system;">
				<td class="text-center">លរ</td>
				<td class="text-center">លេខអាយឌី</td>
				<td class="text-center">លេខកូដទំនិញ</td>
				<td class="text-center">ឈ្មោះទំនិញ</td>
				<td class="text-center">ក្រុមទំនិញ</td>
				<td class="text-center">ម៉ាកទំនិញ</td>
				<td class="text-center">ចំនួនស្តុក</td>
				<td class="text-center">ចំនួនរាយ</td>
				<td class="text-center">ថ្លៃដើម</td>
				<td class="text-center">សរុបទឹកប្រាក់</td>
				<td class="text-center">ប្តូរប្រាក់</td>
				
            </tr>
		</thead>
		<tbody id="stocklistsearch">
			
			@foreach ($stocks as $key => $stock)
				<tr>
					@php
						//$itotal=$inv->total + 0;//for convert 500.00 to 500
						
						$costprice=0;
						$stockleft=0;
						
						if($stock->stock1==0){
							$costprice=0;
							$stockleft=0;
						}else{
							$stockleft=$stock->stock1;
							$costprice=$stock->amount1/$stock->stock1;
						}
						
					@endphp

					<td style="width:60px;text-align:center;">{{ ++ $key }}</td>
					<td>{{ $stock->id }}</td>
					<td>{{ $stock->code }}</td>
					<td style="font-family:khmer os content;">{{ $stock->name }}</td>
					<td style="font-family:khmer os content;">{{ $stock->category->name }}</td>
					<td style="font-family:khmer os content;">{{ $stock->brand->name }}</td>
					<td style="font-family:khmer os system;">{{ App\Sale_Detail::convertqtysale($stock->id,$stockleft) }}</td>
					<td style="font-family:khmer os content;">{{ $stockleft .' ' . $stock->itemunit }}</td>
					<td style="text-align:right;">{{ phpformatnumber($costprice) }} {{ $stock->cur }}</td>
					<td style="text-align:right;" class="totalamount">{{ phpformatnumber($stock->amount1) }} {{ $stock->cur }}</td>
					
					<td style="text-align:right;">{{ phpformatnumber(App\Purchase_Detail::exchangecurrency($stock->cur,$stockcur,$stock->amount1)) . ' ' . $stockcur}}
					</td>
					
					
				</tr>
			@endforeach
				{{-- <tr>
					@php
						$tusd=0;
						$d=0;
					@endphp
					@foreach ($totalstock as $tt)
						@php
							$tusd=(float)$tt->tstock;
						@endphp
					@endforeach
					<td colspan=8></td>
					<td style="text-align:center;"><strong> Total stock</strong></td>
					<td style="text-align:right;" id="totalstockusd"><strong> {{ phpformatnumber($tusd) }} &nbsp; $ </strong></td>
					<td style="text-align:center;padding:3px;" class="colaction"><button class="btn btn-primary btn-sm" id="btnprintstock">Print Stock</button></td>
					
				</tr> --}}
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
					<td colspan=2></td>
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
		

