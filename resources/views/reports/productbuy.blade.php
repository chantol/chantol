

<div class="table-responsive" style="overflow:auto;">
	<table class="table table-bordered table-hover" id="mytable">
		<thead>
           <tr>
				<td class="text-center" style="font-family:'Khmer Os System'">លរ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃទី</td>
				<td class="text-center" style="font-family:'Khmer Os System'">លេខកូដទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ឈ្មោះទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ចំនួនទិញ(ឯកតារាយ)</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុបចំនួនទិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">មធ្យមតំលៃ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុបទឹកប្រាក់</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុប​ចំនួនថែម</td>
				
				
            </tr>
		</thead>
		<tbody id="saleproductlist">
			
			@php
				$ivdate='';
				$tskhr=0;
				$tsusd=0;
				$tsbat=0;
				
				$sub_usd=0;
				$sub_khr=0;
				$sub_bat=0;
				
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
				@if ($ivdate<>'')
					@if ($ivdate<>$p->invdate)
						
						<tr style="font-family:khmer os system;background-color:#ddd;">
							<td colspan=5>សរុបទឹកប្រាក់ទិញសំរាប់ថ្ងៃទី:{{ date('d-m-Y',strtotime($ivdate)) }}</td>
							<td colspan=6>
								<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_usd,'$') }}$</span> 
								<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_bat,'B') }}B</span> 
								<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_khr,'R') }}R</span> 
							</td>
						</tr>
						
					@endif
				@endif
				@if ($ivdate<>$p->invdate)
					<tr>
						<td colspan=9>{{ date('d-m-Y',strtotime($p->invdate)) }}</td>
					</tr>
					@php
						$ivdate=$p->invdate;
						$sub_khr=0;
						$sub_usd=0;
						$sub_bat=0;
					@endphp
				@endif
				@php
					if($p->cur=='R'){
						$tskhr +=$p->sumamount;
						$sub_khr +=$p->sumamount;
					}elseif($p->cur=='B'){
						$tsbat +=$p->sumamount;
						$sub_bat +=$p->sumamount;
					}elseif($p->cur=='$'){
						$tsusd +=$p->sumamount;
						$sub_usd +=$p->sumamount;
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
					<td style="font-family:khmer os system;text-align:center;"><a href="{{ route('buyreport.showdetail',[$p->product_id,$p->invdate,$supid]) }}" target="_blank()"> ​{{ App\Sale_Detail::convertqtysale($p->product_id,$p->sumqty) }}</a></td>
					<td style="text-align:right;">{{ phpformatnumber($p->avgprice,$p->cur) . ' ' . $p->cur }}</td>
					<td style="text-align:right;">{{ phpformatnumber($p->sumamount,$p->cur) . ' ' . $p->cur }}</td>
					<td style="text-align:center;font-family:khmer os system;">{{ App\Sale_Detail::convertqtysale($p->product_id,$p->focqty) }}</td>
				</tr>
			@endforeach
			<tr style="font-family:khmer os system;background-color:#ddd;">
				<td colspan=5>សរុបទឹកប្រាក់ទិញសំរាប់ថ្ងៃទី:{{ date('d-m-Y',strtotime($ivdate)) }}</td>
				
				<td colspan=4>
					
					<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_usd,'$') }}$</span> 
					<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_bat,'B') }}B</span> 
					<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_khr,'R') }}R</span> 
					
					
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" id="tskhr" value="{{ $tskhr }}">
	<input type="hidden" id="tsbat" value="{{ $tsbat }}">
	<input type="hidden" id="tsusd" value="{{ $tsusd }}">
	
	
</div>
		

