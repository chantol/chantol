@extends('layouts.master')
@section('pagetitle')
	all Debt Inv
@endsection
@section('css')
	<style type="text/css" media="print">
		  @page { size: a4 landscape;
		  margin: 10mm 5mm 10mm 5mm;
		   }
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
		table.a {
		  table-layout: fixed;
		  width: 100%;  
		}
		table.b{
			width:100%;
		}
	</style>
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-2">
			<button id="btnprint" class="btn btn-info btn-sm" onclick="printContent('printarea')" style="margin-bottom:5px;">Print</button>
		</div>
		<div class="col-lg-8">
			
		</div>
		<div class="col-lg-2">
			
		</div>
	</div>
	<div class="row" id="printarea">
		<div class="col-lg-12">
			<center>
				<p style="font-family:khmer os muol;display:inline;" class="center">វិក័យប័ត្រមិនទាន់ទូទាត់</p>
			</center>
			<div class="table-responsive" style="overflow:auto;">
				<table class="table table-hover table-bordered">
					<thead>
						<tr style="font-family:khmer os system;">
							<td>លរ</td>
							<td>ថ្ងៃទី</td>
							<td>លេខវិក័យប័ត្រ</td>
							<td>ឈ្មោះអតិថិជន</td>
							<td>អ្នកកត់ត្រា</td>
							<td>ចំនួនទឹកប្រាក់ជំពាក់</td>
							<td>សងរួច</td>
							<td>នៅខ្វះ</td>
						</tr>
					</thead>
					<tbody>
						@php
							$cid='';
							$cname='';
							$total_r=0;
							$total_u=0;
							$total_b=0;
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
						@foreach ($invs as $key => $inv)
							@if ($cid<>$inv->supplier_id)
								@if ($cid <> '')
									<tr style="font-family:khmer os system;color:blue;text-align:right;">
										<td colspan=5>សរុបបំណុលអតិថិជន:{{ $cname }}</td>
										<td>{{ phpformatnumber($total_u)}}$</td>
										<td>{{ phpformatnumber($total_b)}}B</td>
										<td>{{ phpformatnumber($total_r)}}R</td>
									</tr>
									@php
										$total_r=0;
										$total_u=0;
										$total_b=0;
									@endphp
								@endif
								<tr style="font-family:khmer os system;background-color:#ddd;">
									<td colspan=8>{{ $inv->supplier->name }}</td>
								</tr>
							@endif
							@php
								$cid=$inv->supplier_id;
								$cname=$inv->supplier->name;
								if($inv->cur=="R"){
									$total_r += $inv->total - $inv->deposit;
								}
								if($inv->cur=="B"){
									$total_b += $inv->total - $inv->deposit;
								}
								if($inv->cur=="$"){
									$total_u += $inv->total - $inv->deposit;
								}
							@endphp
							<tr>
								<td>{{ ++$key }}</td>
								<td>{{ date('d-m-Y',strtotime($inv->invdate)) }}</td>
								<td>{{ sprintf('%04d',$inv->id)  }}</td>
								<td style="font-family:khmer os system;">{{ $inv->supplier->name }}</td>
								<td>{{ $inv->user->name }}</td>
								<td style="text-align:right;">{{ phpformatnumber($inv->total) . $inv->cur }}</td>
								<td style="text-align:right;">{{ phpformatnumber($inv->deposit) . $inv->cur }}</td>
								<td style="text-align:right;">{{ phpformatnumber($inv->total - $inv->deposit) . $inv->cur }}</td>
							</tr>
						@endforeach
						<tr style="font-family:khmer os system;color:blue;text-align:right;">
							<td colspan=5>សរុបបំណុលអតិថិជន:{{ $cname }}</td>
							<td>{{ phpformatnumber($total_u)}}$</td>
							<td>{{ phpformatnumber($total_b)}}B</td>
							<td>{{ phpformatnumber($total_r)}}R</td>
						</tr>
						@php
							$t_r=0;
							$t_b=0;
							$t_u=0;
						@endphp
						@foreach ($totalall as $tall)
							@if ($tall->cur=='R')
								@php
									$t_r=$tall->tdebt;
								@endphp
							@endif
							@if ($tall->cur=='B')
								@php
									$t_b=$tall->tdebt;
								@endphp
							@endif
							@if ($tall->cur=='$')
								@php
									$t_u=$tall->tdebt;
								@endphp
							@endif
						@endforeach
						<tr style="font-family:khmer os system;text-align:right;background-color:yellow;">
							<td colspan=5>សរុបបំណុលទាំងអស់</td>
							<td>{{ phpformatnumber($t_u) }}$</td>
							<td>{{ phpformatnumber($t_b) }}B</td>
							<td>{{ phpformatnumber($t_r) }}R</td>
						</tr>
					</tbody>

				</table>
			</div>
		</div>
	</div>
@endsection
@section('script')

	<script type="text/javascript">
			// $(document).on('click','#btnprint',function(e){
			// 	e.preventDefault();
			// 	printContent('printarea');
			// })
			
			function printContent(el)
			{
			
			  var restorpage=document.body.innerHTML;
			  var printloc=document.getElementById(el).innerHTML;
			  document.body.innerHTML=printloc;
			  window.print();
			  //window.onafterprint = function(){ window.close()};
			  //history.back(); 
			  document.body.innerTHML=restorpage;
			  
			}
		</script>
@endsection
