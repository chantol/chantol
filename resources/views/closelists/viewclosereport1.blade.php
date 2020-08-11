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
			<h4 style="font-family:khmer os system;">គិតពី: {{ date('d-m-Y',strtotime($closelists[0]->d1)) }} ដល់: {{ date('d-m-Y',strtotime($closelists[0]->d2)) }} </h4>
			<table class="table table-bordered">
				@foreach ($tcls as $tcl)
					<tr>
						<td style="font-family:khmer os system;font-size:18px;">សរុបបំណុល:{{ phpformatnumber($tcl->t_total) . $tcl->cur }}</td>
						<td style="font-family:khmer os system;font-size:18px;">ទូទាត់រួច:{{ phpformatnumber($tcl->t_deposit) . $tcl->cur }}</td>
						<td style="font-family:khmer os system;font-size:18px;">នៅខ្វះ:{{ phpformatnumber($tcl->t_total - $tcl->t_deposit) . $tcl->cur }}</td>
					</tr>
				@endforeach
				
			</table>
		</center>
		</div>
	</div>
	</div>
<div class="table-responsive">
	
		@foreach ($closelists as $cl)
			<div class="chapter">
				<table class="table" style="width:100%;table-layout:fixed;">
			<tr style="background-color:yellow;">
				<td style="font-family:khmer os system;width:50%;">លេខបញ្ជី: {{ $cl->id }}</td>
				
				<td style="font-family:khmer os system;width:50%;">អតិថិជន: {{ $cl->supplier->name }}</td>
				
			</tr>
			<tr>
				<td style="font-family:khmer os system;font-size:18px;">គិតពី:{{ date('d-m-Y',strtotime($cl->d1)) }} ដល់: {{ date('d-m-Y',strtotime($cl->d2)) }}</td>
				<td style="font-family:khmer os system;font-size:22px;">ជំពាក់សរុប:{{ phpformatnumber($cl->total) . $cl->cur }}</td>
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
					@foreach (App\Salecloselist::getpaid($cl->id) as $key => $cp)
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
