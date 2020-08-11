@extends('layouts.master')
@section('pagetitle')
	report/saledetail
@endsection
@section('css')
	<style>
		th{
			font-family:khmer os system;
			text-align:center;
			background:#eee;
			
		}
		#tablesearch {
		  background-image: url('{{ asset("photo") }}/search.png');
		  background-position: 10px 8px;
		  background-repeat: no-repeat;
		  width: 100%;
		  font-family:khmer os system;
		  /*font-size: 12px;*/
		  height:34px;
		  padding: 5px 5px 5px 40px;
		  border: 1px solid #ddd;
		  border-radius: 25px;
		}
	</style>
@endsection
@section('content')
	<div class="col-lg-12">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading" style="font-family:khmer os system;font-size:18px;">
					<div class="col-lg-8">
						របាយការណ៌លក់ផលិផល:  {{ $saledetails[0]->product->name }}  សំរាប់ថ្ងៃទី: {{ date('d-m-Y',strtotime($saledetails[0]->sale->invdate)) }}
						<p style="color:blue;">*អតិថិជន៖ {{ $supname }}</p>
					</div>
					<div class="col-lg-4">
						<input type="text" id="tablesearch" onkeyup="autosearch()" placeholder="Search by Customer Name..." title="Type in a name">
					</div>
					

				</div>
				<div class="panel-body">
					<table class="table table-hover table-bordered" id="mytable">
						<thead>
							<tr​>
								<th>លរ</th>
								<th>ថ្ងៃទី</th>
								<th>លេខវិក័យប័ត្រ</th>
								<th>ឈ្មោះអតិថិជន</th>
								<th>ចំនួនលក់</th>
								<th>តំលៃ</th>
								<th>ចុះ%</th>
								<th>សរុបទឹកប្រាក់</th>
								<th>ចំនួនថែម</th>
								<th>សរុបថ្លៃដើម</th>
								<th>សរុបប្រាក់ចំណេញ</th>
							</tr>
						</thead>
						@php
							$tcost=0;
							function phpformatnumber($num,$cur){
			                  $dc=0;
			                  $p=strpos((float)$num,'.');
			                  if($p>0){
			                    $fp=substr($num,$p,strlen($num)-$p);
			                    $dc=strlen((float)$fp)-2;
			                    
			                  }
			                  if($dc>2){
			                  	$dc=2;
			                  }
			                  if($cur=='$'){
			                  	$dc=2;
			                  }
			                  return number_format($num,$dc,'.',',');
			                }
						@endphp
						<tbody>
							@foreach ($saledetails as $key => $sd)
								<tr>
									@php
										$tcost=$sd->costex * ($sd->qtyunit + $sd->focunit);
									@endphp
									<td class="text-center">{{ ++$key }}</td>
									<td class="text-center">{{ date('d-m-Y',strtotime($sd->sale->invdate)) }}</td>
									<td class="text-center">{{ sprintf("%04d",$sd->sale_id) }}</td>
									<td class="text-center">{{ $sd->sale->supplier->name }}</td>
									<td class="text-center">{{ $sd->quantity . ' ' . $sd->unit }}</td>
									<td class="text-right">{{ phpformatnumber($sd->unitprice,$sd->cur) . ' ' . $sd->cur}}</td>
									<td class="text-right">{{ $sd->discount . '%' }}</td>
									<td class="text-right">{{ phpformatnumber($sd->amount,$sd->cur) . ' ' . $sd->cur }}</td>
									<td class="text-center">{{ $sd->focunit . ' ' . $sd->sunit }}</td>
									<td class="text-right">{{ phpformatnumber($tcost,$sd->cur)  . ' ' . $sd->cur }}</td>
									<td class="text-right">{{ phpformatnumber($sd->amount - $tcost,$sd->cur) . ' ' . $sd->cur }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
	<script>
		function autosearch() {
				 foundkeysearch='true';
				  var input, filter, table, tr, td, i, txtValue;
				  input = document.getElementById("tablesearch");
				  filter = input.value.toUpperCase();
				  table = document.getElementById("mytable");
				  tr = table.getElementsByTagName("tr");
				  for (i = 0; i < tr.length; i++) {
				    td = tr[i].getElementsByTagName("td")[3];
				    if (td) {
				      txtValue = td.textContent || td.innerText;
				      if (txtValue.toUpperCase().indexOf(filter) > -1) {
				        tr[i].style.display = "";
				      } else {
				        tr[i].style.display = "none";
				      }
				    }       
				  }
				}

	</script>
@endsection