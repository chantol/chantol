

<div class="table-responsive">
	<table class="table table-bordered table-hover" id="mytable" style="">
		<thead>
           <tr>
				<td class="text-center" style="font-family:'Khmer Os System'">លរ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃទី</td>
				<td class="text-center" style="font-family:'Khmer Os System'">លេខកូដទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ឈ្មោះទំនិញ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ចំនួនលក់(ឯកតារាយ)</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុបចំនួនលក់</td>
				<td class="text-center" style="font-family:'Khmer Os System'">គោលដៅលក់</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ពិន្ទុទទួលបាន</td>
				<td class="text-center" style="font-family:'Khmer Os System'">តំលៃពិន្ទុ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុបទឹកប្រាក់</td>
            </tr>
		</thead>
		<tbody id="saleproductlist">
			
			@php
			 	$cusid='';
			 	$cusname='';
				$tskhr=0;
				$tsusd=0;
				$tsbat=0;
				
				$sub_usd=0;
				$sub_khr=0;
				$sub_bat=0;
				
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
                  // if($cur=='$'){
                  // 	$dc=2;
                  // }
                  return number_format($num,$dc,'.',',');
                }
		      @endphp

			@foreach ($itemsales as $key => $p)
				@if ($cusid<>'')
					@if ($cusid<>$p->supplier_id)
						
						<tr style="font-family:khmer os system;background-color:#ddd;">
							<td colspan=5>សរុបទឹកប្រាក់ពិន្ទុសំរាប់អតិថិជន:{{ $p->cusname }}</td>
							
							<td colspan=5>
								
								<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_usd,'$') }}$</span> 
								<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_bat,'B') }}B</span> 
								<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_khr,'R') }}R</span> 
							
							</td>
						</tr>
						
					@endif
				@endif
				@if ($cusid<>$p->supplier_id)
					<tr>
						<td colspan=10>{{ $p->cusname }}</td>
					</tr>
					@php
						$cusid=$p->supplier_id;
						$cusname=$p->cusname;
						$sub_khr=0;
						$sub_usd=0;
						$sub_bat=0;
						
					@endphp
				@endif
				@php
					
					if($p->sumqty >= $p->product->qty_score){
							$score=$p->product->qty_target;
					}else{
						$score=0;
					}

					if($p->product->scorecur=='R'){
						$tskhr +=$score * $p->product->scoreprice;
						$sub_khr +=$score * $p->product->scoreprice;
					}elseif($p->product->scorecur=='B'){
						$tsbat +=$score * $p->product->scoreprice;
						$sub_bat +=$score * $p->product->scoreprice;
					}elseif($p->product->scorecur=='$'){
						$tsusd +=$score * $p->product->scoreprice;
						$sub_usd +=$score * $p->product->scoreprice;
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
					<td style="font-family:khmer os system;text-align:center;">{{ App\Sale_Detail::convertqtysale($p->product_id,$p->sumqty) }}</td>
					<td style="text-align:right;font-family:khmer os system;">{{ $p->product->qty_target . $p->product->target_unit }}</td>
					@php
						if($p->sumqty >= $p->product->qty_score){
							$score=$p->product->qty_target;
						}else{
							$score=0;
						}
					@endphp
					<td style="text-align:right;">{{ $score }}</td>
					<td style="text-align:right;">{{ phpformatnumber($p->product->scoreprice) . $p->product->scorecur }}</td>
					<td style="text-align:right;">{{ phpformatnumber($p->product->scoreprice * $score) . $p->product->scorecur }}</td>
				</tr>
					
			@endforeach
			<tr style="font-family:khmer os system;background-color:#ddd;">
				<td colspan=5>សរុបទឹកប្រាក់ពិន្ទុសំរាប់អតិថិជន:{{ $cusname }}</td>
				
				<td colspan=5>
					
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
		

