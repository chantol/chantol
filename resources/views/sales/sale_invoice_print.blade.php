
@extends('layouts.master')
@section('pagetitle')
	Print Sold Invoice
@endsection
@section('css')
	<style type="text/css" media="print">
		  @page { size: a4;
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

	    	<div class="col-md-12">
	    				{{-- <button id="btnprint" onclick="javascript:window.print();">Print</button> --}}
	    				<button id="btnprint" onclick="printContent('printarea');">Print</button>

	    				
	    				<div id="printarea" class="table-responsive">
	    					<div class="row">
								<div class="col-lg-12">
									<table class="a">
									    <tbody>
									    	<tr>
			    								<td style="width:20%">
			    									<img src="{{ asset('logo/'. $logo->logo) }}" alt="" style="width:80px;height:80px;">
			    								</td>
			    								<td style="width:60%;text-align:center;">
			    									<table style="width:100%">
			    										
			    											<tr><td style="font-family:khmer os muol;font-size:18px;">{{ $logo->name }}</td></tr>
			    											<tr><td style="font-family:khmer os muol;font-size:14px;">{{ $logo->subname}}</td></tr>
			    											<tr><td style="font-family:khmer os system;font-size:14px;">{{ $logo->address }}</td></tr>
			    										
			    										
			    									</table>
			    								</td>
			    								<td style="width:20%;">
			    									<table style="width:100%">
			    										<tr>
			    											<td style="width:10%;"><p>Tel:</p></td>
				    										<td style="width:90%">
				    											<pre style="border-style:none;">{{ $logo->tel }}</pre>
				    										</td>
			    										</tr>
			    										<tr>
			    											<td style="width:10%;">Email:</td>
			    											<td style="width:90%;">
			    												<pre style="border-style:none;">{{ $logo->email }}</pre>
			    											</td>
			    										</tr>
			    									</table>
			    								</td>
			    							</tr>
									    </tbody>
		    							
	    							</table>
								</div>
	    					</div>
	    					<hr>
							<div class="row">
								<div class="col-lg-12">
									<table class="a">
										<tr>
											<td style="width:20%;text-decoration:underline;">Customer</td>
											<td style="width:60%;text-align:center;font-family:khmer os muol;">
												វិក័យប័ត្រ <br> INVOICE
											</td>
											<td style="width:20%"></td>
										</tr>
									</table>
									<table class="a">
										<tr>
											<td style="width:80%">
												<table class="b">
													<tr>
														<td style="width:18%;">Name</td>
														<td style="width:2%;">:</td>
														<td style="width:80%;font-family:khmer os system;">{{ $pinv[0]->supname }}</td>
													</tr>
													<tr>
														<td style="width:18%;">Tel</td>
														<td style="width:2%;">:</td>
														<td style="width:80%">{{ $pinv[0]->supplier->tel }}</td>
													</tr>
													<tr>
														<td style="width:18%;">Addr</td>
														<td style="width:2%;">:</td>
														<td style="width:80%;font-family:khmer os system;">{{ $pinv[0]->supplier->address }}</td>
													</tr>
													<tr>
														<td style="width:18%;">Delivery</td>
														<td style="width:2%;">:</td>
														<td style="width:80%">{{ $pinv[0]->dename }}</td>
													</tr>
													<tr>
														<td style="width:18%;">CarNo</td>
														<td style="width:2%;">:</td>
														<td style="width:80%">{{ $pinv[0]->carnum }}</td>
													</tr>
													<tr>
														<td style="width:18%;">Driver</td>
														<td style="width:2%;">:</td>
														<td style="width:80%">{{ $pinv[0]->driver }}</td>
													</tr>
												</table>
											</td>
											<td style="width:20%;vertical-align:top;">
												<table style="width:100%;" class="tblright">
													<tr>
														<td style="width:18%;">INV#</td>
														<td style="width:2%;">:</td>
														
														<td style="width:80%">{{ sprintf('%04d',$pinv[0]->invnum) }}</td>
													</tr>
													<tr>
														<td style="width:18%;">Date</td>
														<td style="width:2%;">:</td>
														<td style="width:80%">{{ date('d-m-Y',strtotime($pinv[0]->invdate)) }}</td>
													</tr>
													<tr>
														<td style="width:18%;">Saveby</td>
														<td style="width:2%;">:</td>

														<td style="width:80%">{{ $pinv[0]->user->name }}</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</div>
							</div>
	    					
							<br><br>
	    					<table  class="table table-bordered table-hover" style="width:100%">
	    						<thead>
	                               <tr>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">បាកូដ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">បរិយាយ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ចំនួន</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ចំនួនកាត់</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">ចំនួនពិត</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">តំលៃ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">បញ្ចុះ(%)</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​>សរុប</td>
	                                </tr>
	    						</thead>
	    						<tbody id="invoice_items">
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
	    							@foreach ($pinv as $key => $pv)
	    								<tr>
	    									<td>{{ ++ $key }}</td>
	    									<td>{{ $pv->barcode }}</td>
	    									<td style="font-family:khmer os content">{{ $pv->name }}</td>
	    									<td style="font-family:khmer os content">{{ $pv->qty . $pv->unit }}</td>
	    									
	    									<td style="font-family:khmer os content">{{ $pv->qtycut . $pv->unit }}</td>
	    									
	    									<td style="font-family:khmer os content">{{ $pv->quantity . $pv->unit }}</td>
	    									
	    									<td style="text-align:right;">{{ phpformatnumber($pv->unitprice) . $pv->cur }}</td>
	    									
	    									<td style="text-align:right;">{{ $pv->discount . '%' }}</td>
	    									<td style="text-align:right;">{{ phpformatnumber($pv->amount) . $pv->cur }}</td>
	    								</tr>
	    							@endforeach
	    						</tbody>
	    					</table>
	    					<table class="footer">
								<tr>
									<td style="width:60%">
										{{ $pv->note }}
									</td>
									<td style="width:40%">
										<table style="width:100%;table-layout:none;">
											<tr>
    											<td style="text-align:right;font-size:22px;">Sub Total :</td>
    											<td style="font-size:22px;text-align:right;">{{ phpformatnumber($pv->subtotal) . $pv->cur }}</td>
    										</tr>
    										<tr>
    											<td style="text-align:right;font-size:22px;">Discount :</td>
    											<td style="font-size:22px;text-align:right;">{{ $pv->discount . '%' }}</td>
    										</tr>
    										<tr>
    											<td style="text-align:right;font-size:22px;">Total :</td>
    											<td style="font-size:22px;text-align:right;">{{ phpformatnumber($pv->total) . $pv->cur }}</td>
    										</tr>
    										<tr>
    											<td style="text-align:right;font-size:22px;">Deposit :</td>
    											<td style="font-size:22px;text-align:right;">{{ phpformatnumber($pv->deposit) . $pv->cur }}</td>
    										</tr>
    										<tr>
    											<td style="text-align:right;font-size:22px;">Balance :</td>
    											<td style="font-size:22px;text-align:right;">{{ phpformatnumber($pv->balance) . $pv->cur }}</td>
    										</tr>
										</table>
									</td>
								</tr>
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

	