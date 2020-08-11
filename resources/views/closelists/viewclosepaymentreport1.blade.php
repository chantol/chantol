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
	<div class="col-lg-12">
		<button class="btn btn-info" id="btnprint">Print</button>
	</div>
	
</div>
<div id="printarea">
	<div class="chapter">
	<div class="row">
		<div class="col-lg-12">
		<center>
			<h3 style="font-family:khmer os system;">របាយការណ៏បិទបញ្ជី</h3>
			<h4 style="font-family:khmer os system;">គិតពី: {{ date('d-m-Y',strtotime($paylists[0]->salecloselist->d1)) }} ដល់: {{ date('d-m-Y',strtotime($paylists[0]->salecloselist->d2)) }} </h4>
			<h4 style="font-family:khmer os system;">សរុបទឹកប្រាក់អតិថិជនបង់សំរាប់ថ្ងៃទី:{{ $text['paydate'] }}</h4>
			<table class="table table-bordered">
				@foreach ($totalpay as $tp)
					<tr>
						<td style="font-family:khmer os system;font-size:18px;text-align:center;">ទឹកប្រាក់បង់សរុប:{{ phpformatnumber($tp->tpay) . $tp->cur }}</td>
						
					</tr>
				@endforeach
				
			</table>
		</center>
		</div>
	</div>
	</div>
<div class="table-responsive">
	
		@foreach ($paylists as $cl)
			<div class="chapter">
				<table class="table" style="width:100%;table-layout:fixed;">
			<tr style="background-color:yellow;">
				<td style="font-family:khmer os system;width:50%;">លេខបញ្ជី: {{ $cl->salecloselist->id }}</td>
				
				<td style="font-family:khmer os system;width:50%;">អតិថិជន: {{ $cl->salecloselist->supplier->name }}</td>
				
			</tr>
			<tr>
				<td style="font-family:khmer os system;font-size:18px;">គិតពី:{{ date('d-m-Y',strtotime($cl->salecloselist->d1)) }} ដល់: {{ date('d-m-Y',strtotime($cl->salecloselist->d2)) }}</td>
				<td style="font-family:khmer os system;font-size:22px;">ជំពាក់សរុប:{{ phpformatnumber($cl->salecloselist->total) . $cl->cur }}</td>
			</tr>
			<tr>
				<td colspan=4>
					<table class="table">
						<thead style="font-family:khmer os system;">
							<tr>
								<td>N <sup>o</sup></td>
								<td >ថ្ងៃបង់ប្រាក់</td>
								<td>អ្នកត់ត្រា</td>
								<td>បានទូទាត់</td>
								<td>នៅខ្វះ</td>
							</tr>
						</thead>
						@php
							$totalpaid=0;
						@endphp
					@foreach (App\Salecloselist::getpaid1($cl->salecloselist_id,$text['paydate']) as $key => $cp)
							@php
								$totalpaid +=$cp->payamt;
							@endphp
							
							<tr>
								<td >{{ ++$key }}</td>
								<td >{{ date('d-m-Y',strtotime($cp->paydate)) }}</td>
								<td style="font-family:khmer os system;">{{ $cp->user->name }}</td>
								<td >{{ phpformatnumber($cp->payamt) . $cp->cur }}</td>
								<td >{{ phpformatnumber($cp->balance) . $cp->cur }}</td>
							</tr>
						
					@endforeach
						<tr>
							<td colspan=2></td>
							<td style="font-family:khmer os system;font-size:20px;">សរុបសង:</td>
							<td style="font-size:20px;" colspan=2>{{ phpformatnumber($totalpaid) . $cl->cur }}</td>
						</tr>
					</table>
				</td>
			</tr>
				</table>
			</div>
		@endforeach
	
</div>
</div>
