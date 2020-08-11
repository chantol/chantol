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
		<h3 style="font-family:khmer os system;">របាយការណ៏បិទបញ្ជី</h3>
		<h4 style="font-family:khmer os system;">គិតពី: {{ date('d-m-Y',strtotime($closelists[0]->d1)) }} ដល់: {{ date('d-m-Y',strtotime($closelists[0]->d2)) }} </h4>
	</center>
</div>
<div class="table-responsive">
	<div style="overflow:auto;">
		<table class="table table-bordered" style="table-layout:fixed;">
			<thead style="font-family:khmer os system">
				<tr>
					<th class="text-center" style="width:50px;">N <sup>o</sup></th>
					<th class="text-center" style="width:100px;">ថ្ងៃបិទបញ្ជី</th>
					<th class="text-center" style="width:100px;">អ្នកកត់ត្រា</th>
					<th class="text-center" style="width:150px;">អតិថិជន</th>
					<th class="text-center" style="width:120px;">សរុបថ្មី</th>
					<th class="text-center" style="width:120px;">សងរួច</th>
					<th class="text-center" style="width:120px;">បំណុលថ្មី</th>
					<th class="text-center" style="width:120px;">បំណុលចាស់</th>
					<th class="text-center" style="width:120px;">សរុបចាស់ថ្មិ</th>
					<th class="text-center" style="width:120px;">បានទូទាត់</th>
					<th class="text-center" style="width:120px;">នៅជំពាក់</th>
					
				</tr>
			</thead>
			<tbody>
				@php
					$cur='';
					$total=0;
					$deposit=0;
					$balance=0;
				@endphp
				@foreach ($closelists as $key =>$cl)
					@if ($cur <> $cl->cur)
					 	@if ($cur <> '')
							<tr style="background-color:yellow;">
								<td colspan=7></td>
								<td>Total</td>
								<td>{{ phpformatnumber($total) . $cur }}</td>
								<td>{{ phpformatnumber($deposit) . $cur }}</td>
								<td>{{ phpformatnumber($balance) . $cur }}</td>
							</tr>
							@php
								$total=0;
								$deposit=0;
								$balance=0;
							@endphp
						@endif
					 	<tr style="background-color:#ddd;">
					 		<td colspan=11>{{ $cl->cur }}</td>
					 	</tr>

					@endif
					
					@php
						$cur=$cl->cur;
						$total +=$cl->total;
						$deposit +=$cl->deposit;
						$balance += $cl->total - $cl->deposit;
					@endphp
					<tr>
						<td>{{ ++$key }}</td>
						<td>{{ date('d-m-Y',strtotime($cl->dd)) }}</td>
						<td style="font-family:khmer os system;">{{ $cl->user->name }}</td>
						<td style="font-family:khmer os system;">{{ $cl->supplier->name }}</td>
						<td>{{ phpformatnumber($cl->ivamount) . $cl->cur }}</td>
						<td>{{ phpformatnumber($cl->ivdeposit) . $cl->cur }}</td>
						<td>{{ phpformatnumber($cl->ivbalance) . $cl->cur }}</td>
						<td>{{ phpformatnumber($cl->oldlist) . $cl->cur }}</td>
						<td>{{ phpformatnumber($cl->total) . $cl->cur }}</td>
						<td>{{ phpformatnumber($cl->deposit) . $cl->cur }}</td>
						<td>{{ phpformatnumber($cl->total - $cl->deposit) . $cl->cur }}</td>
					</tr>
				@endforeach
				<tr style="background-color:yellow;">
								<td colspan=7></td>
								<td>Total</td>
								<td>{{ phpformatnumber($total) . $cur }}</td>
								<td>{{ phpformatnumber($deposit) . $cur }}</td>
								<td>{{ phpformatnumber($balance) . $cur }}</td>
							</tr>
			</tbody>
		</table>
	</div>
	
</div>