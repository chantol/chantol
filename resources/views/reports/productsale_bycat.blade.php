

<div class="table-responsive" style="overflow:auto;">
	<table class="table table-bordered table-hover">
		<thead>
           <tr>
				<td class="text-center" style="font-family:'Khmer Os System'">លរ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃទី</td>
				<td class="text-center" style="font-family:'Khmer Os System'">លេខកូដទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ឈ្មោះទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ចំនួនលក់(ឯកតារាយ)</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុបចំនួនលក់</td>
				<td class="text-center" style="font-family:'Khmer Os System'">មធ្យមតំលៃ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុបទឹកប្រាក់</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុប​ចំនួនថែម</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុបថ្លៃដើម</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ប្រាក់ចំណេញ</td>
				
            </tr>
		</thead>
		<tbody id="saleproductlist">
			
			@php
				$catid='';
				$catname='';
				$pid='';
				$pname='';
				$tskhr=0;
				$tsusd=0;
				$tsbat=0;
				$tpkhr=0;
				$tpusd=0;
				$tpbat=0;
				$sub_usd=0;
				$sub_khr=0;
				$sub_bat=0;
				$sub_pusd=0;
				$sub_pkhr=0;
				$sub_pbat=0;
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
				@if ($catid<>'')
					@if ($catid<>$p->product->category_id)
						
						<tr style="font-family:khmer os system;background-color:#ddd;">
							<td colspan=4>សរុបទឹកប្រាក់លក់សំរាប់ក្រុមទំនិញ:{{ $catname }}</td>
							
							<td colspan=7>
								
								<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_usd,'$') }}$</span> 
								<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_bat,'B') }}B</span> 
								<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_khr,'R') }}R</span> 
								
								<span class="label label-primary" style="font-size:18px;font-family:Arial;float:right;">{{ phpformatnumber($sub_pusd,'$') }}$</span> 
								<span class="label label-primary" style="font-size:18px;font-family:Arial;float:right;">{{ phpformatnumber($sub_pbat,'B') }}B</span> 
								<span class="label label-primary" style="font-size:18px;font-family:Arial;float:right;">{{ phpformatnumber($sub_pkhr,'R') }}R</span> 
							</td>
						</tr>
						
					@endif
				@endif
				@if ($catid<>$p->product->category_id)
					<tr style="font-family:khmer os system;">
						<td colspan=11>{{ $p->product->category->name }}</td>
					</tr>
					@php
						$catid=$p->product->category_id;
						$catname=$p->product->category->name;
						$sub_khr=0;
						$sub_usd=0;
						$sub_bat=0;
						$sub_pkhr=0;
						$sub_pusd=0;
						$sub_pbat=0;
					@endphp
					
				@endif
				
				@php
					$pid=$p->product_id;
					$pname=$p->product->name;
					if($p->cur=='R'){
						$tskhr +=$p->sumamount;
						$tpkhr +=$p->sumamount-$p->tcost;
						$sub_khr +=$p->sumamount;
						$sub_pkhr +=$p->sumamount-$p->tcost;
					}elseif($p->cur=='B'){
						$tsbat +=$p->sumamount;
						$tpbat +=$p->sumamount-$p->tcost;
						$sub_bat +=$p->sumamount;
						$sub_pbat +=$p->sumamount-$p->tcost;
					}elseif($p->cur=='$'){
						$tsusd +=$p->sumamount;
						$tpusd +=$p->sumamount-$p->tcost;
						$sub_usd +=$p->sumamount;
						$sub_pusd +=$p->sumamount-$p->tcost;
					}
					
				@endphp
				
				<tr>
					<td style="width:50px;text-align:center;">
		                  {{ ++ $key }}
					</td>
					<td>{{ date('d-m-Y',strtotime($p->invdate)) }}</td>
					<td>{{ $p->product_id }}</td>
					<td style="font-family:khmer os system;">{{ $p->product->name }}</td>
					<td style="font-family:khmer os system;text-align:center;">{{ $p->sumqty . '' . $p->product->itemunit}}</td>
					{{-- <td style="font-family:khmer os system;text-align:center;">{{ App\Sale_Detail::convertqtysale($p->product_id,$p->sumqty) }}</td> --}}
					<td style="font-family:khmer os system;text-align:center;"><a href="{{ route('salereport.showdetail',[$p->product_id,$p->invdate,$supid]) }}" target="_blank()"> ​{{ App\Sale_Detail::convertqtysale($p->product_id,$p->sumqty) }}</a></td>
					<td style="text-align:right;">{{ phpformatnumber($p->avgprice,$p->cur) . ' ' . $p->cur }}</td>
					<td style="text-align:right;">{{ phpformatnumber($p->sumamount,$p->cur) . ' ' . $p->cur }}</td>
					<td style="text-align:center;font-family:khmer os system;">{{ App\Sale_Detail::convertqtysale($p->product_id,$p->focqty) }}</td>
					<td style="text-align:right;">{{ phpformatnumber($p->tcost,$p->cur) . ' ' . $p->cur }}</td>
					<td style="text-align:right;font-size:16px;" class="
							@if($p->sumamount-$p->tcost>0)
								colorblue
							@elseif($p->sumamount-$p->tcost<0)
								colorred
							@else
								colorblack
							@endif
						">
						{{ phpformatnumber($p->sumamount-$p->tcost,$p->cur) . ' ' . $p->cur }}
					</td>
					
				</tr>
				
			@endforeach
			<tr style="font-family:khmer os system;background-color:#ddd;">
				<td colspan=4>សរុបទឹកប្រាក់លក់សំរាប់ក្រុមទំនិញ:{{ $catname }}</td>
				
				<td colspan=7>
					
					<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_usd,'$') }}$</span> 
					<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_bat,'B') }}B</span> 
					<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_khr,'R') }}R</span> 
					
					<span class="label label-primary" style="font-size:18px;font-family:Arial;float:right;">{{ phpformatnumber($sub_pusd,'$') }}$</span> 
					<span class="label label-primary" style="font-size:18px;font-family:Arial;float:right;">{{ phpformatnumber($sub_pbat,'B') }}B</span> 
					<span class="label label-primary" style="font-size:18px;font-family:Arial;float:right;">{{ phpformatnumber($sub_pkhr,'R') }}R</span> 
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" id="tskhr" value="{{ $tskhr }}">
	<input type="hidden" id="tsbat" value="{{ $tsbat }}">
	<input type="hidden" id="tsusd" value="{{ $tsusd }}">
	<input type="hidden" id="tpkhr" value="{{ $tpkhr }}">
	<input type="hidden" id="tpbat" value="{{ $tpbat }}">
	<input type="hidden" id="tpusd" value="{{ $tpusd }}">
	
</div>
		

