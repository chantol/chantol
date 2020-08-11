
<div class="table-responsive" style="overflow:auto;">
	    					<table class="table table-bordered table-hover">
	    						<thead>
	                               <tr>
	                               		
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>លរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លេខវិក័យប័ត្រ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃវិក័យប័ត្រ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃរក្សាទុក</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អ្នកកត់ត្រា</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អតិថិជន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ក្រុមដឹកជញ្ជូន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លេខឡាន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អ្នកបើកបរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ក្រុមច្បាប់</td>
	        							
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=>ទម្ងន់សរុប</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​ colspan=>ថ្លៃដឹក</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>សរុបទឹកប្រាក់</td>
	        							<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>បានសង</td>
	        							<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>ទឹកប្រាក់ជំពាក់</td>
	                                </tr>
	    						</thead>
	    						<tbody id="invoicelist">
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
	    									
											<td style="text-align:center;">
												<div class="custom-control custom-checkbox">
								                  <input type="checkbox" class="custom-control-input customCheck" style="height:20px;width:20px;margin-top:0px;" {{ $inv->deposit_carfee>=$inv->totaldelivery ?'disabled':'' }}>
								              	</div>
								              
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
											<td>{{ $inv->law->name }}</td>
	    									
	    									<td style="text-align:right;">{{ $inv->totalweight . ' ' . 'Kg' }}</td>
	    									<td style="text-align:right;">{{ phpformatnumber($inv->carfee) }} {{ $inv->cur }}</td>
	    									<td style="text-align:center;">{{ phpformatnumber($inv->totaldelivery) }}</td>
	    									<td style="text-align:center;">{{ $inv->cur }}</td>
	    									<td style="text-align:center;text-decoration: underline;">
	    										<a href="#" data-id="{{ $inv->id }}" data-deposit="{{ $inv->deposit_carfee }}" data-cur="{{ $inv->cur }}" data-supname="{{ $inv->delivery->name }}" data-totalinv="{{ $inv->totaldelivery }}" class="showpaiddetail">{{ phpformatnumber($inv->deposit_carfee) }}</a>
	    									</td>
	    									<td style="text-align:center;">{{ $inv->cur }}</td>
	    									<td style="text-align:center;">{{ phpformatnumber((float)$inv->totaldelivery)-(float)$inv->deposit_carfee }}</td>
	    									<td style="text-align:center;">{{ $inv->cur }}</td>
	    									
	    									
	    									
	    								</tr>
	    							@endforeach
	    							
	    						</tbody>
	    					</table>
	    					
	    					 
	    				</div>
		

