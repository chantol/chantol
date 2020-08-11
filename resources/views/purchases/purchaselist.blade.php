<div class="table-responsive" style="overflow:auto;">
	    					<table class="table table-bordered table-hover">
	    						<thead>
	                               <tr>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លេខវិក័យប័ត្រ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃវិក័យប័ត្រ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃរក្សាទុក</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អ្នកកត់ត្រា</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អ្នកផ្គត់ផ្គង់</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ក្រុមដឹកជញ្ជូន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លេខឡាន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អ្នកបើកបរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">សរុបទឹកប្រាក់</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្លៃដឹកជញ្ជូន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">បញ្ចុះ(%)</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​>សរុប</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">សកម្មភាព</td>
	                                </tr>
	    						</thead>
	    						<tbody id="invoice_List">
	    							{{-- @include('purchases.purchaselist') --}}
	    							@foreach ($invoices as $key => $inv)
	    								<tr>
	    									@php
	    										//$itotal=$inv->total + 0;//for convert 500.00 to 500

	    										if($inv->cur=="$"){
	    											$decimal=2;
	    										}else{
	    											$decimal=0;
	    										}
	    										
	    									@endphp

	    									<td>{{ ++ $key }}</td>
	    									<td style="text-decoration: underline;"><a href="#" data-id="{{ $inv->id }}" data-supname="{{ $inv->supplier->name }}" data-totalinv="{{ $inv->total }}" data-cur="{{ $inv->cur }}"  class="showinvdetail">{{ sprintf("%04d",$inv->id) }}</a> </td>
	    									
	    									<td>{{ date('d-m-Y',strtotime($inv->invdate)) }}</td>
	    									<td>{{ date('d-m-Y h:i:sa',strtotime($inv->created_at)) }}</td>
	    									<td>{{ $inv->user->name }}</td>
	    									<td>{{ $inv->supplier->name }}</td>
	    									<td>{{ $inv->delivery->name }}</td>
	    									<td>{{ $inv->carnum }}</td>
	    									<td>{{ $inv->driver }}</td>
	    									<td style="text-align:right;">{{ number_format($inv->subtotal,$decimal,'.',',') }} {{ $inv->cur }}</td>
	    									<td style="text-align:right;">{{ number_format($inv->shipcost,$decimal,'.',',') }} {{ $inv->cur }}</td>
	    									<td style="text-align:center;">{{ $inv->discount }} %</td>
	    									
	    									
	    									<td style="text-align:right;">{{ number_format($inv->total,$decimal,'.',',') }}  {{ $inv->cur }}</td>
	    									
	    									<td style="text-align:center;">
	    										<a href="{{ route('invoicelistedit',$inv->id) }}" class="btn btn-warning btn-xs btnedit" title="edit" target="_blank"><i class="fa fa-pencil"></i></a>
	    										<a href="{{ route('purchaseprint',$inv->id) }}" class="btn btn-default btn-xs btnprint" title="print" target="_blank"><i class="fa fa-print"></i></a>
	    										
	    										{{-- <a href="javascript:window.print();" class="btn btn-default btn-xs btnprint" title="print"><i class="fa fa-print"></i></a>  --}}
	    										
	    										<a href="#" class="btn btn-danger btn-xs btndelinv" id="btndelinv{{ $inv->id }}" data-id="{{ $inv->id }}"><i class="fa fa-minus"></i></a>
	    										
	    									</td>
	    									
	    								</tr>
	    							@endforeach
	    							
	    						</tbody>
	    					</table>
	    					
	    					 {!! $invoices->links() !!}
	    				</div>
		

