@php
	$myfile = fopen("stockcurrency.txt", "r") or die("Unable to open file!");
	//$myfile = fopen("E:\PHPfile\best.txt", "r") or die("Unable to open file!");
	$stockcur= fgets($myfile);
	fclose($myfile);
@endphp
<div class="table-responsive" style="overflow:auto;">
	<table class="table table-bordered table-hover">
		<thead>
           <tr>
				<td class="text-center" style="font-family:'Khmer Os System'" rowspan=2>លរ</td>
				<td class="text-center" style="font-family:'Khmer Os System'" rowspan=2>លេខកូដទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'" rowspan=2>ឈ្មោះទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'" rowspan=2>ស្តុកនៅសល់(រាយ)</td>
				<td class="text-center" style="font-family:'Khmer Os System'" colspan=3>ស្តុកនៅសល់
				</td>
				<td class="text-center" style="font-family:'Khmer Os System'" rowspan=2>សរុបទឹកប្រាក់</td>
            </tr>
            <tr style="font-family:khmer os system;text-align:center;">
				<td>ឡូ</td>
				<td>យួរ</td>
				<td>ដប</td>
            </tr>
		</thead>
		<tbody id="stockproductlist">
			
			@php
				$ivdate='';
				$tskhr=0;
				$tsusd=0;
				$tsbat=0;
				$tpkhr=0;
				$tpusd=0;
				$tpbat=0;
				$lo=0;
				$y=0;
				$d=0;
				$allqty=0;
				$pid=0;
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

			@foreach ($stocks as $key => $s)
				@php
					$allqty +=$s->stock;
					$arrqty=explode(";", App\Sale_Detail::convertqtysale1($s->id,$s->stock));
					if(count($arrqty)==3){
						$lo=$arrqty[0];
						$y=$arrqty[1];
						$d=$arrqty[2];
					}else if(count($arrqty)==2){
						$y=$arrqty[0];
						$d=$arrqty[1];
					}else if(count($arrqty)==1){
						$d=$arrqty[0];
					}
					$pid=$s->id;
				@endphp
				
				
				<tr>
					<td style="width:50px;text-align:center;">
		                  {{ ++ $key }}
					</td>
					
					<td>{{ $s->id }}</td>
					<td style="font-family:khmer os system">{{ $s->name }}</td>
					
					<td style="font-family:khmer os system;text-align:center;">
						{{ $s->stock . '' . $s->itemunit}}
					</td>
					<td style="font-family:khmer os system;text-align:center;">{{ $lo }}</td>
					<td style="font-family:khmer os system;text-align:center;">{{ $y }}</td>
					<td style="font-family:khmer os system;text-align:center;">{{ $d }}</td>
					<td style="text-align:right;">{{ phpformatnumber($s->stock * $s->costprice) . ' ' . $s->cur }}</td>
				</tr>
				@php
					$lo=0;
					$y=0;
					$d=0;
					unset($arrqty);
				@endphp

			@endforeach
			@php
				unset($arrqty);
				$arrqty=explode(";", App\Sale_Detail::convertqtysale1($pid,$allqty));
					if(count($arrqty)==3){
						$lo=$arrqty[0];
						$y=$arrqty[1];
						$d=$arrqty[2];
					}else if(count($arrqty)==2){
						$y=$arrqty[0];
						$d=$arrqty[1];
					}else if(count($arrqty)==1){
						$d=$arrqty[0];
					}
			@endphp
			<tr style="background-color:#ddd;">

				<td colspan=4 style="font-family:khmer os system;color:blue;">សរុបចំនួនស្តុកទាំងអស់</td>
				<td style="font-family:khmer os system;text-align:center;color:blue;">{{ $lo }}</td>
				<td style="font-family:khmer os system;text-align:center;color:blue;">{{ $y }}</td>
				<td style="font-family:khmer os system;text-align:center;color:blue;">{{ $d }}</td>
				
				<td style="text-align:center;padding:3px;" class="colaction" colspan=2>
					
				</td>
			</tr>

			<tr style="background-color:yellow;">
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
					<td colspan=2 style="font-family:khmer os system">សរុបទឹកប្រាក់</td>
					<td style="text-align:center;" ><strong> All In One: {{ phpformatnumber($allinone) }} {{ $stockcur }}</strong></td>
					<td style="text-align:right;" colspan=2><strong>  {{ phpformatnumber($t_usd) }}  $ </strong></td>
					
					<td style="text-align:right;" colspan=2><strong>  {{ phpformatnumber($t_thb) }}  B</strong></td>
					
					<td style="text-align:right;" colspan=2><strong>  {{ phpformatnumber($t_khr) }}  R</strong></td>
				</tr>
		</tbody>
	</table>
	<button class="btn btn-primary btn-sm" id="btnprintstock2" style="font-size:16px;font-family:arial;">Print Stock</button>
	
</div>
		

