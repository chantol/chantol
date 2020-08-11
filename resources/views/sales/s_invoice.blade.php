
<div class="table-responsive" style="overflow:auto;">
	    					<table class="table table-bordered table-hover">
	    						<thead>
	                               <tr>
	                               		
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>លរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លេខវិ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃទី</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃរក្សាទុក</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អ្នកកត់ត្រា</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អតិថិជន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ក្រុមដឹកជញ្ជូន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">សរុបថ្លៃឡាន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លេខឡាន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">អ្នកបើកបរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ក្រុមច្បាប់</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្លៃរត់ច្បាប់</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">សរុបទឹកប្រាក់</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ថ្លៃដឹកជញ្ជូន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">បញ្ចុះ(%)</td>
	        							<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>សរុបទឹកប្រាក់</td>
	        							<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>បានសង</td>
	        							<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>នៅជំពាក់</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">ទូទាត់(%)</td>
	        							<td class="text-center">Print</td>
	                                </tr>
	    						</thead>
	    						<tbody id="invoicelist">
	    							{{-- @include('purchases.purchaselist') --}}
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
								                  <input type="checkbox" class="custom-control-input customCheck" style="height:20px;width:20px;margin-top:0px;" {{ $inv->p_paid==100?'disabled':'' }}>
								              	</div>
								              {{-- <div class="custom-control custom-checkbox">
								                  <input type="radio" class="custom-control-input" name="customrad" style="height:20px;width:20px;margin-top:0px;" {{ $inv->p_paid==100?'disabled':'' }}>
								              </div> --}}
											</td>
	    									<td style="width:50px;text-align:center;">
								                  {{ ++ $key }}
	    									</td>
	    									<td style="text-decoration: underline;"><a href="#" data-id="{{ $inv->id }}" data-supname="{{ $inv->supplier->name }}" data-totalinv="{{ $inv->total }}" data-cur="{{ $inv->cur }}"  class="showinvdetail">{{ sprintf("%04d",$inv->id) }}</a> </td>
	    									<td>{{ date('d-m-Y',strtotime($inv->invdate)) }}</td>
	    									<td>{{ date('d-m-Y h:i:sa',strtotime($inv->created_at)) }}</td>
	    									<td style="font-family:khmer os system;">{{ $inv->user->name }}</td>
	    									<td style="font-family:khmer os system;">{{ $inv->supplier->name }}</td>
	    									<td style="font-family:khmer os system;">{{ $inv->delivery->name }}</td>
	    									<td>{{ phpformatnumber($inv->totaldelivery) }}</td>
	    									
	    									<td>{{ $inv->carnum }}</td>
	    									<td style="font-family:khmer os system;">{{ $inv->driver }}</td>
											<td style="font-family:khmer os system;">{{ $inv->law->name }}</td>
	    									<td>{{ phpformatnumber($inv->lawfee) }}</td>
	    									<td style="text-align:right;">{{ phpformatnumber($inv->subtotal) }} {{ $inv->cur }}</td>
	    									<td style="text-align:right;">{{ phpformatnumber($inv->shipcost) }} {{ $inv->cur }}</td>
	    									<td style="text-align:center;">{{ $inv->discount }} %</td>
	    									
	    									<td style="text-align:center;">{{ phpformatnumber($inv->total) }}</td>
	    									<td style="text-align:center;">{{ $inv->cur }}</td>
	    									<td style="text-align:center;text-decoration: underline;">
	    										<a href="#" data-id="{{ $inv->id }}" data-deposit="{{ $inv->deposit }}" data-cur="{{ $inv->cur }}" data-supname="{{ $inv->supplier->name }}" data-totalinv="{{ $inv->total }}" class="showpaiddetail">{{ phpformatnumber($inv->deposit) }}</a>
	    									</td>
	    									<td style="text-align:center;">{{ $inv->cur }}</td>
	    									<td style="text-align:center;">{{ phpformatnumber($inv->total-$inv->deposit) }}</td>
	    									<td style="text-align:center;">{{ $inv->cur }}</td>
	    									
	    									<td style="font-family:'Khmer Os System'">
	    											{{ $inv->p_paid }} %
	    									</td>
	    									<td style="text-align:center;">
	    										<a href="{{ route('saleprint',$inv->id) }}" class="btn btn-default btn-xs btnprint" title="print" target="_blank()"><i class="fa fa-print"></i></a>
	    									</td>
	    									
	    								</tr>
	    							@endforeach
	    							
	    						</tbody>
	    					</table>
	    					
	    					 
	    				</div>
		

