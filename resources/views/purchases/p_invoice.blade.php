
<div class="table-responsive">
	    					<table class="table table-bordered table-hover">
	    						<thead>
	                               <tr>
	                               		
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>លរ</td>
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
	        							<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>សរុបទឹកប្រាក់</td>
	        							<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>បានសង</td>
	        							<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>ទឹកប្រាក់ជំពាក់</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">ទូទាត់(%)</td>
	        							<td class="text-center">Print</td>
	                                </tr>
	    						</thead>
	    						<tbody id="invoicelist">
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
											<td style="text-align:center;">
												
								              <div class="custom-control custom-checkbox">
								                  <input type="checkbox" class="custom-control-input customCheck" style="height:20px;width:20px;margin-top:0px;" {{ $inv->p_paid==100?'disabled':'' }}>
								              	</div>
								             {{--  <div class="custom-control custom-checkbox">
								                  <input type="radio" class="custom-control-input" name="customrad" style="height:20px;width:20px;margin-top:0px;" {{ $inv->p_paid==100?'disabled':'' }}>
								              </div> --}}
											</td>
	    									<td style="width:50px;text-align:center;">
												
								                  {{ ++ $key }}
								              
	    									</td>
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
	    									
	    									<td style="text-align:center;">{{ number_format($inv->total,$decimal,'.',',') }}</td>
	    									<td style="text-align:center;">{{ $inv->cur }}</td>
	    									<td style="text-align:center;text-decoration: underline;">
	    										<a href="#" data-id="{{ $inv->id }}" data-deposit="{{ $inv->deposit }}" data-cur="{{ $inv->cur }}" data-supname="{{ $inv->supplier->name }}" data-totalinv="{{ $inv->total }}" class="showpaiddetail" title="{{ $inv->id }}">{{ number_format($inv->deposit,$decimal,'.',',') }}</a>
	    									</td>
	    									<td style="text-align:center;">{{ $inv->cur }}</td>
	    									<td style="text-align:center;">{{ number_format($inv->total-$inv->deposit,$decimal,'.',',') }}</td>
	    									<td style="text-align:center;">{{ $inv->cur }}</td>
	    									
	    									<td style="font-family:'Khmer Os System'">
	    											{{ $inv->p_paid }} %
	    									</td>
	    									<td style="text-align:center;">
	    										<a href="{{ route('purchaseprint',$inv->id) }}" class="btn btn-default btn-xs btnprint" title="print" target="_blank"><i class="fa fa-print"></i></a>
	    									</td>
	    									
	    								</tr>
	    							@endforeach
	    							
	    						</tbody>
	    					</table>
	    					
	    					 
	    				</div>
		

