
@extends('layouts.master')
@section('css')
	<style type="text/css" media="print">
		  @page { size: landscape; }
	</style>
@endsection
	@section('content')
		<div class="row">
	    	<div class="col-md-12">
	    				{{-- <button id="btnprint" onclick="javascript:window.print();">Print</button> --}}
	    				<button id="btnprint" onclick="printContent('printarea');">Print</button>
	    				<div id="printarea" class="table-responsive">
	    					
							<table>
								<tr>
									<td><strong>Delivery:</strong></td>
									<td>{{ $pinv[0]->dename }}</td>
									<td>{{ $pinv[0]->carnum }}</td>
									<td>{{ $pinv[0]->driver }}</td>
									
								</tr>
								<tr>
									<td><strong>Supplier:</strong></td>
									<td>{{ $pinv[0]->supname }}</td>
								</tr>
							</table>
	    					
							<br><br>	<br>	
	    					<table  class="table table-bordered table-hover" style="width:130%">
	    						<thead>
	                               <tr>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លរ</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">បាកូដ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">បរិយាយ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>ចំនួន</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>ចំនួនកាត់</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>ចំនួនពិត</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">តំលៃទិញ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"></td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">បញ្ចុះ(%)</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​ colspan=3>សរុប</td>
	        							
	                                </tr>
	    						</thead>
	    						<tbody id="invoice_items">
	    							@foreach ($pinv as $key => $pv)
	    								@php
											$dc1=0;
											$dc2=0;
											$dc=0;
											$p=strpos((float)$pv->unitprice,'.');
											if($p>0){
												$fp=substr($pv->unitprice,$p,strlen($pv->unitprice)-$p);
												$dc1=strlen((float)$fp)-2;
												
											}

											$p=strpos((float)$pv->discount,'.');
											if($p>0){
												$fp=substr($pv->discount,$p,strlen($pv->discount)-$p);
												$dc=strlen((float)$fp)-2;
											}

											$p=strpos((float)$pv->amount,'.');
											if($p>0){
												$fp=substr($pv->amount,$p,strlen($pv->amount)-$p);
												$dc2=strlen((float)$fp)-2;
											}
										@endphp
	    								<tr>
	    									<td>{{ ++ $key }}</td>
	    									<td>{{ $pv->barcode }}</td>
	    									<td style="font-family:khmer os content">{{ $pv->name }}</td>
	    									<td>{{ $pv->qty }}</td>
	    									<td>{{ $pv->unit }}</td>
	    									<td>{{ $pv->qtycut }}</td>
	    									<td>{{ $pv->unit }}</td>
	    									<td>{{ $pv->quantity }}</td>
	    									<td>{{ $pv->unit }}</td>
	    									<td style="text-align:right;">{{ number_format($pv->unitprice,$dc1,'.',',') }}</td>
	    									<td>{{ $pv->cur }}</td>
	    									<td style="text-align:center;">{{ number_format($pv->discount,$dc,'.',',') }}%</td>
	    									<td style="text-align:right;">{{ number_format($pv->amount,$dc2,'.',',') }}</td>
	    									<td>{{ $pv->cur }}</td>
	    								</tr>


	    							@endforeach
	    							
	    						</tbody>
	    					</table>
	    				</div>
	    	</div>
	    </div>

	@endsection

@section('script')
	<script>
		
			//printContent('printarea');
			$('#btnprint').click();
			
				function printContent(el)
			{
			
			  //var restorpage=document.body.innerHTML;
			  var printloc=document.getElementById(el).innerHTML;
			  document.body.innerHTML=printloc;
			  window.print();
			  window.onafterprint = function(){ window.close()};
			  //setTimeout(window.close, 1000);
			  //window.close();
			  //history.back(); 
			  //document.body.innerTHML=restorpage;
			  
			}
			
			
		
			
		</script>
@endsection

	