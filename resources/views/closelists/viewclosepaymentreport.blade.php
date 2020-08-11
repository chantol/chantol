@php
	function phpformatnumber($num){
		$dc=0;
		$p=strpos((float)$num,'.');
		if($p>0){
			$fp=substr($num,$p,strlen($num)-$p);
			$dc=strlen((float)$fp)-2;
			
		}
		return number_format($num,$dc,'.',',');
	}
@endphp
<div class="row">
	<center>
		<h3 style="font-family:khmer os system;">របាយការណ៏បង់ប្រាក់តាមលេខបញ្ជីសំរាប់ថ្ងៃទី: {{ $text['paydate'] }}</h3>
		<h4 style="font-family:khmer os system;">គិតពី: {{ date('d-m-Y',strtotime($paylists[0]->salecloselist->d1)) }} ដល់: {{ date('d-m-Y',strtotime($paylists[0]->salecloselist->d2)) }} </h4>
	</center>
</div>
<div class="row">
	<div class="col-lg-12">
		<table class="table table-bordered">
			@foreach ($totalpay as $tp)
				<tr>
					<td style="font-family:khmer os system;font-size:20px;">សរុបទឹកប្រាក់</td>
					<td style="font-size:20px;">{{ phpformatnumber($tp->tpay) . $tp->cur }}</td>
				</tr>
			@endforeach			
		</table>
	</div>
</div>
<div class="table-responsive">
	<div style="overflow:auto;">
		<table class="table table-bordered" style="table-layout:fixed;">
			<thead style="font-family:khmer os system">
				<tr>
					<th class="text-center" style="width:50px;">N <sup>o</sup></th>
					<th class="text-center" style="width:100px;">លេខបញ្ជី</th>
					<th class="text-center" style="width:150px;">អតិថិជន</th>
					<th class="text-center" style="width:100px;">អ្នកកត់ត្រា</th>
					<th class="text-center" style="width:100px;">ថ្ងៃបង់ប្រាក់</th>
					<th class="text-center" style="width:120px;">ចំនួនទឹកប្រាក់</th>
					<th class="text-center" style="width:120px;">នៅខ្វះ</th>
				</tr>
			</thead>
			<tbody>
				@php
					$cur='';
					$totalpay=0;
					$balance=0;
				@endphp
				@foreach ($paylists as $key =>$cl)
					@if ($cur <> $cl->cur)
					 	@if ($cur <> '')
							<tr style="background-color:yellow;">
								<td colspan=3></td>
								<td colspan=2>TotalPay:{{ phpformatnumber($totalpay) . $cur }}</td>
								
								<td colspan=2>Balance:{{ phpformatnumber($balance) . $cur }}</td>
							</tr>
							@php
								$totalpay=0;
								$balance=0;
							@endphp
						@endif
					 	<tr style="background-color:#ddd;">
					 		<td colspan=7>{{ $cl->cur }}</td>
					 	</tr>

					@endif
					
					@php
						$cur=$cl->cur;
						$totalpay +=$cl->payamt;
						$balance += $cl->balance;
					@endphp
					<tr>
						<td>{{ ++$key }}</td>
						<td>{{ $cl->salecloselist_id }}</td>
						<td style="font-family:khmer os system;">{{ $cl->salecloselist->supplier->name }}</td>
						<td style="font-family:khmer os system;">{{ $cl->user->name }}</td>
						<td>{{ date('d-m-Y',strtotime($cl->paydate)) }}</td>
						<td>{{ phpformatnumber($cl->payamt) . $cl->cur }}</td>
						<td>{{ phpformatnumber($cl->balance) . $cl->cur }}</td>
					</tr>
				@endforeach
				<tr style="background-color:yellow;">
					<td colspan=3></td>
					<td colspan=2>TotalPay:{{ phpformatnumber($totalpay) . $cur }}</td>
					<td colspan=2>Balance:{{ phpformatnumber($balance) . $cur }}</td>
				</tr>
			</tbody>
		</table>
	</div>
	
</div>