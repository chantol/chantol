
@extends('layouts.master')
@section('pagetitle')
	Sale Invoice
@endsection
@section('css')
	<style type="text/css">
		#btnrereshcusprice:hover {
		  background-color: yellow;
		  text-decoration:underline;
		}
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
	
	<div class="container-fulid">
	<div class="alert alert-danger print-error-msg" style="display:none">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul></ul>
    </div>
    <form action="#" method="POST" id="frmsale">
    	@csrf
    	
        <div class="col-lg-12">
        	<div class="row" >	
	    		<div class="table-responsive">
	    			<table class="table table-bordered" >
	    				<tr style="background-color:#ccc;">
	    					<td><p id="frmtitle" style="color:blue;font-size:22px;">New Sale</p></td>
	    					<td><p class="pull-right" style="font-size:22px;" id="orderid">OrderID: New Order </p></td>
	    					<td>
	    						<p class="pull-right" style="font-size:22px;" >Date: <span id="dd"> {{ date('d-m-Y',strtotime(now())) }} </span> </p>
	    					</td>
	    					<td class="text-center">
	    						<button style="color:green;border-width:1px;padding:5px;border-style:none;margin-top:5px;background-color:#ccc;" id="btnrereshcusprice">Refresh Customer Price</button>
	    					</td>
	    				</tr>
	    			</table>
	    		</div>
	    			
	    			<input type="hidden" name="sale_id" id="sale_id" value="">
	    		
    		</div>
    		<div class="row" style="background-color:#fff;padding-bottom:10px;padding-top:10px;margin-top:-20px;">
    			<div class="col-lg-3">
    				<input type="hidden" name="userid" value="{{ Auth::id() }}">
    					<label for="buyfrom" class="kh">ទិញពី</label>
						<select class="form-control" class="form-control" name="buyfrom" id="buyfrom"​>
							<option value=""></option>
							@foreach ($buyfrom as $b)
								<option value="{{ $b->name }}">{{ $b->name }}</option>
							@endforeach
						</select>
						
						<label for="customer" class="kh">ក្រុមបំពេញច្បាប់</label>
						<div class="input-group">
							<select class="form-control" name="sel_law" id="sel_law"​>
								<option value=""></option>
								@foreach ($co as $c)
									<option value="{{ $c->id }}">{{ $c->name }}</option>
								@endforeach
							</select>
							<div class="input-group-addon btn btn-default" id="add_co">
								<span class="fa fa-plus" ></span>
							</div>
						</div>
						<label for="delivery" class="kh">ក្រុមហ៊ុនដឹកជញ្ជូន</label>
						<div class="input-group">
							<select class="form-control" name="sel_delivery" id="sel_delivery"​>
								<option value=""></option>
								@foreach ($deliveries as $de)
									<option value="{{ $de->id }}">{{ $de->name }}</option>
								@endforeach
							</select>
							<div class="input-group-addon btn btn-default" id="add_delivery">
								<span class="fa fa-plus" ></span>
							</div>
						</div>
							
						
    			</div>

				<div class="col-lg-3">
    				<label for="invno" class="kh">លេខវិក័យប័ត្រទិញ</label>
					<div>
						<input type="text" class="form-control"  name="buyinv" id="buyinv" style="font-family:'khmer os system';height:40px;width:100%;padding:5px;border-radius:5px;">
					</div>
					<label for="cofee" class="kh">ថ្លៃរត់ច្បាប់</label>
					<div>
						<input type="text" class="number-separator form-control" name="lawfee" id="lawfee" style="height:40px;width:100%;padding:5px;border-radius:5px;" value="0">
					</div>
					
					<label for="transportfee" class="kh">ថ្លៃដឹកជញ្ជូន/Kg</label>
					<div>
						<input type="text" class="form-control carfee" name="carfee" id="carfee" style="height:40px;width:100%;padding:5px;border-radius:5px;" value="0">
					</div>
    			</div>
    			<div class="col-lg-3">
    				<label for="carnum" class="kh">លេខឡាន</label>
					<div>
						<input type="text" class="form-control" name="carnum" id="carnum" style="font-family:'khmer os system';height:40px;width:100%;padding:5px;border-radius:5px;">
					</div>	
					<label for="driver" class="kh">អ្នកបើកបរ</label>
					<div>
						<input type="text" class="form-control"  name="driver" id="driver" style="font-family:'khmer os system';height:40px;width:100%;padding:5px;border-radius:5px;">
					</div>
					<label for="driver" class="kh">បរិមាណសរុប</label>
					<div>
						<input type="text" class="form-control totalweight" name="totalweight" id="totalweight" style="height:40px;width:100%;padding:5px;border-radius:5px;">
					</div>
    			</div>
    			<div class="col-lg-3">
    				<label for="customer" class="kh" id="lblcusname">អតិថិជន</label>
						<div class="input-group">
							<select class="form-control" name="sel_supplier" id="sel_supplier"​>
								<option value=""></option>
								@foreach ($suppliers as $sup)
									<option value="{{ $sup->id }}">{{ $sup->name }}</option>
								@endforeach
							</select>
							<div class="input-group-addon btn btn-default" id="add_supplier">
								<span class="fa fa-plus" ></span>
							</div>
						</div>
						<label for="saledate" class="kh">កាលបរិច្ឆេទ</label>
						<div class="input-group">
							<input type="text" name="invdate" id="invdate" class="form-control" style="height:40px;">
							<div class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</div>
						</div>
						<label for="driver" class="kh">សរុបថ្លៃដឹកជញ្ជូន</label>
						<div>
							<input type="text" class="form-control totaldelivery"  name="totaldelivery" id="totaldelivery" style="height:40px;width:100%;padding:5px;border-radius:5px;">
						</div>
						<input type="hidden" id="customervalue" readonly>
    			</div>
    		</div>

    	</div>
   	<br>
   {{-- part table list --}}
	    <div class="row">
	    	<div class="col-md-12">
	    		<div class="panel panel-default">
	    			<div class="panel-heading">
	    				<h3 class="panel-title" style="color:red;"><strong>Order Lists</strong></h3>
	    			</div>
	    			<div class="panel-body">
	    				<div class="table-responsive" style="overflow:auto;">
	    					<table class="table table-bordered table-hover">
	    						<thead>
	                               <tr>
	        							<td class="text-center" style="font-family:Khmer Os System;width:50px;">លរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:100px;">លេខកូដ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:160px;">បាកូដ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:250px;">បរិយាយ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:120px;" colspan=2>ចំនួន</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System';width:120px;" colspan=2>ចំនួនកាត់</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System';width:120px;" colspan=2>ចំនួនពិត</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System';width:160px;" colspan=2>តំលៃលក់</td>
	        							
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System';width:70px;">បញ្ចុះ(%)</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:300px;"​ colspan=3>សរុប</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:80px;"​>ថែមរាយ</td>
		        						<td class="text-center" style="font-family:'Khmer Os System';width:60px;"​>ឯកតា</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:80px;"​>មេគុណ</td>
	        							{{-- <td class="text-center" style="font-family:'Khmer Os System';width:80px;"​>ចំនួនរាយ</td> --}}
	        							<td class="text-center" style="font-family:'Khmer Os System';width:80px;"​>កាត់ស្តុក</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:80px;"​>ថ្លៃដើម</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:80px;"​>រូបិយ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';width:100px;">សកម្មភាព</td>
	        							
	                                </tr>
	    						</thead>
	    						<tbody id="invoice_items">
	    							<tr>	
										<td colspan='13' style="border:none;">Note:</td>
	    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
	    								<td class="thick-line text-right" style="font-size:18px;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="subtotal" name="subtotal" value="0"></td>
	    								<td class="thick-line text-left subcur" style="font-size:18px;"><strong>R</strong></td>
	    							</tr>
	    							<tr>
	    								<td colspan="13" style="border:none;padding:0px;"><input type="text" class="form-control" name="invnote" style="font-family:'Khmer Os System';width:99%;height:40px;padding:8px;margin-left:5px;"></td>
	    								<td class="no-line text-center"><strong>Shipping</strong></td>
	    								<td class="no-line" style="text-align:right;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="shipcost" name="shipcost" value="0"></td>
	    								<td class="no-line shipcur" style="font-size:18px;"><strong>R</strong></td>
	    							</tr>
	    							<tr>
	    								<td colspan="13" style="border:none;"></td>
	    								<td class="no-line text-center"><strong>Discount</strong></td>
	    								<td class="no-line" style="text-align:right;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="invdiscount" name="invdiscount" value="0"></td>
	    								<td class="no-line" style="font-size:18px;"><strong>%</strong></td>
	    								<td class="no-line" style="font-size:18px; text-align:center;" colspan=3>Deposit</td>
	    								<td class="no-line" style="font-size:18px; text-align:center;" colspan=3>Balance</td>
	    							</tr>
	    							<tr>
	    								<td colspan="13" style="border:none;">
								                
	    								</td>
	    								
	    								<td class="no-line text-center"><strong>Total</strong></td>
	    								<td class="no-line text-right" style="font-size:18px;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="lasttotal" name="lasttotal" value="0"></td>
	    								
	    								<td class="no-line" style="font-size:18px;padding:0px;"><input type="text" style="width:50px;height:40px;font-size:18px;font-weight:bold;border-style:none;text-align:left;padding:8px;" name="lastcur" id="lastcur" value="R" readonly></td>

										{{-- deposit --}}
	    								<td class="no-line text-right" style="font-size:18px;padding:0px;" colspan=3><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="deposit" name="deposit" value="0"></td>
	    								
										<td class="no-line text-right" style="font-size:18px;padding:0px;" colspan=3><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="lastbal" name="lastbal" value="0" readonly></td>

	    							</tr>
	    						</tbody>
	    					</table>
	    				</div>
	    			</div>
	    			<div class="panel-footer" style="height:60px;">
	    				<div class="row">
	    					<div class="col-sm-12">
	    						<div class="col-sm-6">
									<div class="row">
										<table class="table" style="table-layout:fixed;width:100%;">
											<tr>
												<td style="padding:0px;border-style:none;width:auto;"> 
													<input type="text" name="table_search" class="form-control barcode_search" placeholder="Search Barcode" autofocus autocomplete="off">
												</td>
												<td style="padding:0px;border-style:none;width:40px;">
													<button type="button" class="btn btn-default btnsearchproduct"><i class="fa fa-search"></i></button>
												</td>
												<td style="padding:0px;border-style:none;width:40px;">
													<button type="button" class="btn btn-default btnsearchproduct1"><i class="fa fa-credit-card"></i></button>
												</td>
											</tr>
										</table>
									</div>
								</div>
	    						<div class="col-sm-6">
									<div class="row">
										<button id="btnsavepurchase" class="btn btn-primary btn-sm pull-right btnsavepurchase" style="font-family:khmer os system;">រក្សាទុក</button>

										<button id="btnupdatesale" class="btn btn-warning btn-sm pull-right btnupdatesale" style="color:blue;font-family:khmer os system;display:none">កែប្រែ</button>

										<button id="btnclear" class="btn btn-info btn-sm pull-right btnnew" style="font-family:khmer os system;margin-right:5px;">សំអាត</button>

										
    									<button id="btnnewsale" class="btn btn-default btn-sm pull-right btnnew" style="color:blue;font-family:khmer os system;margin-right:5px;display:none;">វិក័យប័ត្រថ្មី</button>
									</div>
									
								</div>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
    </form>
</div>
	@include('sales.sale_invlist')
	@include('modal.searchproduct_modal') 
	@include('modal.supplier_modal')
	@include('modal.delivery_modal')
	@include('modal.tax_modal')
	@include('modal.additem_modal')
	@include('sales.confirm_delete')
@endsection
@section('script')
	<script src="{{ asset('js') }}/numberinput.js"></script>
	@include('script.script-sale')
@endsection