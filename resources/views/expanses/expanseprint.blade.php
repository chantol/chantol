@extends('layouts.master')
@section('pagetitle')
	Print multi Sold Invoice
@endsection
@section('css')
	<style type="text/css" media="print">
		  @page { size: a4;
		  margin: 15mm 5mm 10mm 5mm;
		   }
		   div.pagebreak, div.appendix {
    		page-break-after: always;}

		  .tblright{
		  	position:relative;
		  	left:0px;
		  }

		  .footer {
		   position: fixed;
		   left: 0;
		   bottom: 0;
		   width: 100%;
		   background-color: red;
		   color: white;
		   text-align: center;
		}
		
	</style>
@endsection
@section('content')
	

@php
	$ivdate='';
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
		if($dc>4){
			$dc=4;
		}
		return number_format($num,$dc,'.',',');
	}
@endphp
<div class="row">
	<div class="col-lg-12">
		
		<div id="printarea" class="table-responsive">
			
			<table class="table">
				<tr>
					<td style="font-family:khmer os system;color:blue;font-size:22px;">
						របាយការណ៌ចំណាយ គិតពី:{{ date('d-m-Y',strtotime($d1)) }} ដល់: {{ date('d-m-Y',strtotime($d2)) }}</td>
						
					</td>
				</tr>
			</table>
			<table  class="table table-hover table-bordered">
					<thead style="font-family:khmer os system;">
						<tr​>
							<th style="text-align:center;">N<sup>o</sup></th>
							<th style="text-align:center;">ថ្ងៃទី</th>
							<th style="text-align:center;">អ្នកកត់ត្រា</th>
							<th style="text-align:center;">ប្រភេទចំណាយ</th>
							<th style="text-align:center;">បរិយាយ</th>
							<th style="text-align:center;">ចំនួន</th>
							<th style="text-align:center;">តំលៃ</th>
							<th style="text-align:center;">សរុប</th>
							<th style="text-align:center;">ផ្សេងៗ</th>
							
						</tr>
					</thead>
					<tbody>
						@foreach ($expanses as $key => $ep)
						@if ($ivdate<>'')
							@if ($ivdate<>$ep->dd)
								
								<tr style="font-family:khmer os system;background-color:#ddd;">
									<td colspan=5 style="font-family:khmer os system;">សរុបថ្ងៃទី:{{ date('d-m-Y',strtotime($ivdate)) }}</td>
									<td colspan=6>
										<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_usd,'$') }}$</span> 
									
										<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_bat,'B') }}B</span> 
									
										<span class="label label-info" style="font-size:18px;font-family:Arial;width:100%;">{{ phpformatnumber($sub_khr,'R') }}R</span> 
									
								</tr>
								
							@endif
						@endif
						@if ($ivdate<>$ep->dd)
							<tr style="background-color:yellow;">
								<td colspan=10>{{ date('d-m-Y',strtotime($ep->dd)) }}</td>
							</tr>
							@php
								$ivdate=$ep->dd;
								$sub_khr=0;
								$sub_usd=0;
								$sub_bat=0;
							@endphp
						@endif
						@php
							if($ep->cur=='R'){
								//$tskhr += $ep->qty * $ep->price;
								$sub_khr +=$ep->qty * $ep->price;
							}elseif($ep->cur=='B'){
								//$tsbat +=$ep->qty * $ep->price;
								$sub_bat +=$ep->qty * $ep->price;
							}elseif($ep->cur=='$'){
								//$tsusd +=$ep->qty * $ep->price;
								$sub_usd +=$ep->qty * $ep->price;
							}
						@endphp		
						<tr> 
							<td>{{ ++$key }}</td>
							<td>{{ date('d-m-y',strtotime($ep->dd)) }}</td>
							<td style="font-family:khmer os system;">{{ $ep->user->name }}</td>
							<td style="font-family:khmer os system;">{{ $ep->type }}</td>
							<td style="font-family:khmer os system;">{{ $ep->name }}</td>
							<td style="text-align:center;font-family:khmer os system;">{{ $ep->qty . $ep->unit }}</td>
							<td style="text-align:right;">{{ phpformatnumber($ep->price) . $ep->cur }}</td>
							<td style="text-align:right;">{{ phpformatnumber($ep->price * $ep->qty) . $ep->cur }}</td>
							<td style="font-family:khmer os system;">{{ $ep->note }}</td>
							
						</tr>

					@endforeach
					<tr style="font-family:khmer os system;background-color:#ddd;">
						<td colspan=5 style="font-family:khmer os system;">សរុបថ្ងៃទី:{{ date('d-m-Y',strtotime($ivdate)) }}</td>
						<td colspan=6>
							<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_usd,'$') }}$</span> 
						
							<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_bat,'B') }}B</span>
						
							<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_khr,'R') }}R</span> 
						
					</tr>
					@php
						$khr=0;
						$usd=0;
						$thb=0;
					@endphp
					@foreach ($total as $t)
						@php
							if($t->cur=="R"){
								$khr =phpformatnumber($t->tamount) . $t->cur; 
							}
							if($t->cur=="B"){
								$thb =phpformatnumber($t->tamount) . $t->cur; 
							}
							if($t->cur=="$"){
								$usd =phpformatnumber($t->tamount) . $t->cur; 
							}
						@endphp
						
					@endforeach
					<tr style="background-color:yellow;">
						
						<td colspan=5 style="font-family:khmer os system;">សរុបចំណាយ គិតពី: {{ date('d-m-Y',strtotime($d1)) }} ដល់: {{ date('d-m-Y',strtotime($d2)) }}</td>
						
						<td colspan=2 style="font-weight:bold;">{{ $usd }}</td>
						<td style="font-weight:bold;">{{ $thb }}</td>
						<td colspan=2 style="font-weight:bold;">{{ $khr }}</td>
					</tr>
				</tbody>
			</table>

			
		</div>
	</div>
</div>

@endsection

@section('script')

	<script type="text/javascript">
		
			printContent('printarea');
			function printContent(el)
			{
			
			  //var restorpage=document.body.innerHTML;
			  var printloc=document.getElementById(el).innerHTML;
			  document.body.innerHTML=printloc;
			  window.print();
			  window.onafterprint = function(){ window.close()};
			  //history.back(); 
			  //document.body.innerTHML=restorpage;
			  
			}
		</script>
@endsection