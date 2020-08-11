 <div class="row">
	    	<div class="col-md-12">
	    		<div class="panel panel-default">
	    			<div class="panel-heading">
	    				<h3 class="panel-title"><strong>Invoice List</strong></h3>
	    			</div>
	    			<div class="panel-body">
	    				<div class="table-responsive" style="overflow:auto;">
	    					<table class="table table-bordered table-hover">
	    						<thead>
	                               <tr>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លេខវិក័យប័ត្រ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃវិក័យប័ត្រ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃរក្សាទុក</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អ្នកកត់ត្រា</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អតិថិជន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ក្រុមដឹកជញ្ជូន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ក្រុមរត់ច្បាប់</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ទិញពី</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លេខឡាន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អ្នកបើកបរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">សរុបថ្លៃឡាន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្លៃរត់ច្បាប់</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">សរុបទឹកប្រាក់</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្លៃដឹក</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">បញ្ចុះ(%)</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​>សរុប</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">សកម្មភាព</td>
	                                </tr>
	    						</thead>
	    						<tbody id="invoice_List">
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
	    							@foreach ($invoices as $key => $inv)
	    								<tr>
	    									

	    									<td>{{ ++ $key }}</td>
	    									<td>{{ sprintf("%04d",$inv->id) }}</td>
	    									<td>{{ date('d-m-Y',strtotime($inv->invdate)) }}</td>
	    									<td>{{ date('d-m-Y h:i:sa',strtotime($inv->created_at)) }}</td>
	    									<td>{{ $inv->user->name }}</td>
	    									<td>{{ $inv->supplier->name }}</td>
	    									<td>{{ $inv->delivery->name }}</td>
	    									<td>{{ $inv->law->name }}</td>
	    									<td>{{ $inv->buyfrom }}</td>
	    									
	    									<td>{{ $inv->carnum }}</td>
	    									<td>{{ $inv->driver }}</td>
	    									<td>{{ phpformatnumber($inv->totaldelivery) }}</td>
	    									<td>{{ phpformatnumber($inv->lawfee) }}</td>
	    									
	    									<td style="text-align:right;">{{ phpformatnumber($inv->subtotal) }} {{ $inv->cur }}</td>
	    									<td style="text-align:right;">{{ phpformatnumber($inv->shipcost) }} {{ $inv->cur }}</td>
	    									<td style="text-align:center;">{{ $inv->discount }} %</td>
	    									
	    									
	    									<td style="text-align:right;">{{ phpformatnumber($inv->total) }}  {{ $inv->cur }}</td>
	    									
	    									<td style="text-align:center;">
	    										<a href="#" class="btn btn-warning btn-xs btnedit" data-id="{{ $inv->id }}"><i class="fa fa-pencil"></i></a>
	    										<a href="{{ route('saleprint',$inv->id) }}" class="btn btn-default btn-xs btnprint" title="print" target="_blank()"><i class="fa fa-print"></i></a>
	    										
	    										 {{-- <a href="javascript:window.print();" class="btn btn-default btn-xs btnprint" title="print"><i class="fa fa-print"></i></a> --}}
	    										
	    										<a href="#" class="btn btn-danger btn-xs btndelinv" data-id="{{ $inv->id }}"><i class="fa fa-minus"></i></a>
	    										
	    									</td>
	    									
	    								</tr>
	    							@endforeach
	    							
	    							
	    						
	    						</tbody>
	    					</table>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>