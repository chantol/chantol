
@extends('layouts.master')
@section('pagetitle')
	Purchase Invoice
@endsection
@section('css')
	<style type="text/css">
		.invoice-title h2, .invoice-title h3 {
    		display: inline-block;
		}

		.table > tbody > tr > .no-line {
		    border-top: none;
		}

		.table > thead > tr > .no-line {
		    border-bottom: none;
		}

		.table > tbody > tr > .thick-line {
		    border-top: 2px solid;
		}
	 	table th{
	 		font-family:"Khmer OS System";
	 	}
		label.kh{
	 		font-family:"Khmer OS System";
	 	}
	 	#fade {
	    display: none;
	    position:absolute;
	    top: 0%;
	    left: 0%;
	    width: 100%;
	    height: 100%;
	    background-color: #ababab;
	    z-index: 1001;
	    -moz-opacity: 0.8;
	    opacity: .70;
	    filter: alpha(opacity=80);
		}

	#modal {
	    display: none;
	    position: absolute;
	    top: 10%;
	    left: 45%;
	    width: 80px;
	    height: 80px;
	    padding:5px 0px 0px;
	    border: 3px solid #ababab;
	    box-shadow:1px 1px 10px #ababab;
	    border-radius:20px;
	    background-color: transparent;
	    z-index: 1002;
	    text-align:center;
	    overflow: auto;
		}
	.modal-body
	{
	    background-color:#fff;
	}

	.modal-content
	{
		background-color: #fff;
	    border-radius: 6px;
	    -webkit-border-radius: 6px;
	    -moz-border-radius: 6px;
	   /* background-color: transparent;*/
	}

	.modal-footer
	{
	    border-bottom-left-radius: 6px;
	    border-bottom-right-radius: 6px;
	    -webkit-border-bottom-left-radius: 6px;
	    -webkit-border-bottom-right-radius: 6px;
	    -moz-border-radius-bottomleft: 6px;
	    -moz-border-radius-bottomright: 6px;
	}

	.modal-header
	{
	    border-top-left-radius: 6px;
	    border-top-right-radius: 6px;
	    -webkit-border-top-left-radius: 6px;
	    -webkit-border-top-right-radius: 6px;
	    -moz-border-radius-topleft: 6px;
	    -moz-border-radius-topright: 6px;
	}

	
		.table tr {
		    cursor: pointer;
		}
		.table{
			background-color: #fff !important;
		}
		.hedding h1{
			color:#fff;
			font-size:25px;
		}
		.main-section{
			margin-top: 120px;
		}
		.hiddenRow {
		    padding: 0 4px !important;
		    background-color: #eeeeee;
		    font-size: 13px;
		}
		.accordian-body span{
			color:#a2a2a2 !important;
		}
	</style>
@endsection

@section('content')
	@php
		date_default_timezone_set("Asia/Bangkok");
	@endphp
	<div class="container-fulid">
			<div class="alert alert-danger print-error-msg" style="display:none">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
		        <ul></ul>
		    </div>
    	<form action="#" method="POST" id="frmpurchase">
    		@csrf
				<div class="row">	
		    		<div class="invoice-title">
		    			<h2 id="frmtitle" style="color:blue; padding-left:12px;">Purchase Invoice</h2>
		    			<h3 class="pull-right" style="background:yellow;padding:5px;" id="orderid">OrderID: New Order </h3>
		    			
		    			<h3 class="pull-right" style="background:yellow;padding:5px;margin-right:10px;">Date: <span id="ddd">{{ date('d-m-Y',strtotime(now())) }}</span> </h3>
		    			
		    			<hr>
		    			<input type="hidden" name="purchase_id" id="purchase_id">
		    		</div>
    			</div>
				<div class="row">
	    			<div class="col-lg-4">
	    				<input type="hidden" name="userid" value="{{ Auth::id() }}">
							<label for="delivery" class="kh">ក្រុមដឹកជញ្ជូន</label>
							<div class="input-group">
								<select class="form-control" name="sel_delivery" id="sel_delivery"​>
									@foreach ($deliveries as $de)
										<option value="{{ $de->id }}">{{ $de->name }}</option>
									@endforeach
								</select>
								<div class="input-group-addon btn btn-default" id="add_delivery">
									<span class="fa fa-plus" ></span>
								</div>
							</div>
							<label for="customer" class="kh">អ្នកផ្គត់ផ្គង់</label>
							<div class="input-group">
								<select class="form-control" name="sel_supplier" id="sel_supplier"​>
									@foreach ($suppliers as $sup)
										<option value="{{ $sup->id }}">{{ $sup->name }}</option>
									@endforeach
								</select>
								<div class="input-group-addon btn btn-default" id="add_supplier">
									<span class="fa fa-plus" ></span>
								</div>
							</div>
	    			</div>

					<div class="col-lg-4">
	    				<label for="carnum" class="kh">លេខឡាន</label>
						<div>
							<input type="text" class="form-control" name="carnum" id="carnum" style="font-family:'khmer os system';height:40px;width:100%;">
						</div>	
						<label for="driver" class="kh">អ្នកបើកបរ</label>
						<div>
							<input type="text" class="form-control"  name="driver" id="driver" style="font-family:'khmer os system';height:40px;width:100%;">
						</div>
	    			</div>
	    			<div class="col-lg-4">
	    				<div class="row">
							<div class="col-lg-6">
								<label for="invdate" class="kh">ថ្ងៃទីវិក័យប័ត្រ</label>
								<input type="text" class="form-control" id="dd" style="height:40px;" value="{{ date('d-m-Y',strtotime(now())) }}" readonly>
							</div>
							<div class="col-lg-6">
								<label for="saveby"​ class="kh">អ្នកត់ត្រា</label>
								<input type="text" class="form-control"  id="usersave" style="height:40px;" value="{{ Auth::user()->name }}" readonly>
							</div>
						</div>
	    				<label for="date" class="kh">កាលបរិច្ឆេទ</label>
						<div class="input-group">
							<input type="text" name="invdate" id="invdate" class="form-control" style="height:40px;">
							<div class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</div>
						</div>
	    			</div>
    			</div>

	    		
	    		
			
   
    		<br>
		    <div class="row">
		    	<div class="col-md-12">
		    		<div class="panel panel-default">
		    			<div class="panel-heading">
		    				<h3 class="panel-title" style="color:red;"><strong>Order Lists</strong></h3>
		    			</div>
		    			<div class="panel-body" style="overflow:auto;>
		    				<div class="table-responsive">
		    					<table class="table table-bordered table-hover">
		    						<thead>
		                               <tr>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:50px;">លរ</td>
		        							
		        							<td class="text-center" style="font-family:'Khmer Os System';width:160px;">បាកូដ</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:250px;">បរិយាយ</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:120px;" colspan=2>ចំនួន</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:120px;" colspan=2>ចំនួនកាត់</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:120px;" colspan=2>ចំនួនពិត</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:160px;" colspan=2>តំលៃទិញ</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:70px;">បញ្ចុះ(%)</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:300px;"​ colspan=3>សរុប</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:80px;"​>ថែមរាយ</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:60px;"​>ឯកតា</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:60px;"​>មេគុណ</td>
		        							{{-- <td class="text-center" style="font-family:'Khmer Os System';width:80px;"​>ចំនួនរាយ</td> --}}
		        							<td class="text-center"​ style="font-family:'Khmer Os System';width:80px;"​>កាត់ស្តុក</td>
		        							
		        							<td class="text-center" style="font-family:'Khmer Os System';width:100px;">សកម្មភាព</td>
		        							<td class="text-center" style="font-family:'Khmer Os System';width:100px;display:none;">លេខកូដ</td>
		        							
		                                </tr>
		    						</thead>
		    						<tbody id="invoice_items">
		    							
		    							
		    							<tr>	
											<td colspan='12' style="border:none;">Note:</td>
		    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
		    								<td class="thick-line text-right" style="font-size:18px;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="subtotal" name="subtotal" value="0"></td>
		    								<td class="thick-line text-left subcur" style="font-size:18px;"><strong>R</strong></td>
		    							</tr>
		    							<tr>
		    								<td colspan="12" style="border:none;padding:0px;"><input type="text" class="form-control" name="invnote" style="​font-family:'Khmer Os System';width:99%;height:40px;padding:8px;margin-left:5px;"></td>
		    								<td class="no-line text-center"><strong>Shipping</strong></td>
		    								<td class="no-line" style="text-align:right;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="shipcost" name="shipcost" value="0"></td>
		    								<td class="no-line shipcur" style="font-size:18px;"><strong>R</strong></td>
		    							</tr>
		    							<tr>
		    								<td colspan="12" style="border:none;"></td>
		    								<td class="no-line text-center"><strong>Discount</strong></td>
		    								<td class="no-line" style="text-align:right;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="invdiscount" name="invdiscount" value="0"></td>
		    								<td class="no-line" style="font-size:18px;"><strong>%</strong></td>
		    								<td class="no-line" style="font-size:18px; text-align:center;" colspan=3>Deposit</td>
	    									<td class="no-line" style="font-size:18px; text-align:center;" colspan=3>Balance</td>
		    							</tr>
		    							<tr>
		    								<td colspan="12" style="border:none;">
		    									<div class="col-lg-6">
		    										<div class="row">
			    										<div class="input-group input-group-sm" style="width: 300px;">
										                  <input type="text" name="barcode_search" class="form-control pull-right barcode_search" placeholder="Search Barcode" autofocus autocomplete="off">

										                  <div class="input-group-btn">
										                    <button type="button" class="btn btn-default btnsearchproduct"><i class="fa fa-search"></i></button>
										                  </div>
										                  <div class="input-group-btn">
										                    <button type="button" class="btn btn-default btnsearchproduct1"><i class="fa fa-credit-card"></i></button>
										                  </div>
										                </div>
										             </div>
		    									</div>
		    										<div class="col-lg-6">
		    											<button class="btn btn-primary btn-sm pull-right btnsavepurchase" style="font-family:khmer os system;">រក្សាទុក</button>
		    											<button class="btn btn-info btn-sm pull-right btnnew" style="font-family:khmer os system;margin-right:20px;">សំអាត</button>
		    										</div>
									                
		    								</td>
		    								
		    								<td class="no-line text-center"><strong>Total</strong></td>
		    								<td class="no-line text-right" style="font-size:18px;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="lasttotal" name="lasttotal" value="0"></td>
		    								
		    								<td class="no-line" style="font-size:18px;padding:0px;"><input type="text" style="width:50px;height:40px;font-size:18px;border-style:none;text-align:left;padding:8px;" name="lastcur" id="lastcur" value="R"></td>
											{{-- deposit --}}
		    								<td class="no-line text-right" style="font-size:18px;padding:0px;" colspan=3><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="deposit" name="deposit" value="0"></td>
		    								
											<td class="no-line text-right" style="font-size:18px;padding:0px;" colspan=3><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="lastbal" name="lastbal" value="0" readonly></td>

		    							</tr>
		    						</tbody>
		    					</table>
		    				</div>
						</div>
		    	</div>
		    </div>
	    </form>
	</div>
		@include('purchases.purchase_invlist')
		@include('modal.searchproduct_modal') 
		@include('modal.supplier_modal')
		@include('modal.delivery_modal')
		@include('purchases.confirm_delete')
		@include('modal.additem_modal')
	@endsection
	@section('script')
		{{-- <script src="{{ asset('js') }}/jquery.printPage.js"></script> --}}
		<script src="{{ asset('js') }}/numberinput.js"></script>
		@include('script.script-purchase')
	@endsection