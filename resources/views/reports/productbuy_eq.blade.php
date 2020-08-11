

<div class="table-responsive" style="overflow:auto;">
	<table class="table table-bordered table-hover">
		<thead>
           <tr>
				<td class="text-center" style="font-family:'Khmer Os System'" rowspan=2>លរ</td>
				<td class="text-center" style="font-family:'Khmer Os System'" rowspan=2>លេខកូដទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'" rowspan=2>ឈ្មោះទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'" rowspan=2>ចំនួនទិញ(ឯកតារាយ)</td>
				<td class="text-center" style="font-family:'Khmer Os System'" colspan=3>សរុបចំនួនទិញ
				</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុប​ចំនួនថែម</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុបទឹកប្រាក់</td>
            </tr>
            <tr style="font-family:khmer os system;text-align:center;">
				<td>ឡូ</td>
				<td>យួរ</td>
				<td>ដប</td>
            </tr>
		</thead>
		<tbody id="saleproductlist">
			
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
                function phpformatnumber($num,$cur){
                  $dc=0;
                  // $p=strpos((float)$num,'.');
                  // if($p>0){
                  //   $fp=substr($num,$p,strlen($num)-$p);
                  //   $dc=strlen((float)$fp)-2;
                    
                  // }
                  // if($dc>2){
                  // 	$dc=2;
                  // }
                  if($cur=='$'){
                  	$dc=2;
                  }
                  return number_format($num,$dc,'.',',');
                }
		      @endphp

			@foreach ($itemsales as $key => $p)
				@php
					$allqty +=$p->sumqty;
					$arrqty=explode(";", App\Sale_Detail::convertqtysale1($p->product_id,$p->sumqty));
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
					$pid=$p->product_id;
				@endphp
				
				
				<tr>
					<td style="width:50px;text-align:center;">
		                  {{ ++ $key }}
					</td>
					
					<td>{{ $p->product_id }}</td>
					<td style="font-family:khmer os system">{{ $p->product->name }}</td>
					<td​ style="font-family:khmer os system;text-align:center;">{{ $p->sumqty . '' . $p->product->itemunit}}</td>
					<td style="font-family:khmer os system;text-align:center;">{{ $lo }}</td>
					<td style="font-family:khmer os system;text-align:center;">{{ $y }}</td>
					<td style="font-family:khmer os system;text-align:center;">{{ $d }}</td>
					
					<td style="text-align:center;font-family:khmer os system;">{{ App\Sale_Detail::convertqtysale($p->product_id,$p->focqty) }}</td>
					
					<td style="text-align:right;">{{ phpformatnumber($p->sumamount,$p->cur) . ' ' . $p->cur }}</td>
					
					
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
			<tr>

				<td colspan=4></td>
				<td style="font-family:khmer os system;text-align:center;">{{ $lo }}</td>
				<td style="font-family:khmer os system;text-align:center;">{{ $y }}</td>
				<td style="font-family:khmer os system;text-align:center;">{{ $d }}</td>
			</tr>
		</tbody>
	</table>
	
	
</div>
		

