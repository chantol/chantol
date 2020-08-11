
@extends('layouts.master')
@section('pagetitle')
	Sale Edit
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
	
	<div class="container-fulid">
	<div class="alert alert-danger print-error-msg" style="display:none">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul></ul>
    </div>
    <form action="#" method="POST" id="frmeditsale">
    	@csrf
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
       
   	{{-- ---------------------------- --}}
   		<div class="col-lg-12">
   			
        	<div class="row">	
	    		<div class="invoice-title">
	    			<h2 id="frmtitle" style="color:blue; padding-left:12px;">Sale Edit</h2>
	    			<h3 class="pull-right" style="background:yellow;padding:5px;" id="orderid">INV#: 
	    				{{ sprintf('%04d',$invoices[0]->invid) }} </h3>
	    			
	    			<h3 class="pull-right" style="background:yellow;padding:5px;margin-right:10px;" >Date: <span id="dd"> {{ date('d-m-Y',strtotime($invoices[0]->invdate)) }} </span> </h3>
	    			
	    			<hr style="border-color:#ccc;">
	    			<input type="hidden" name="sale_id" id="sale_id" value="{{ $invoices[0]->invid }}">
	    		</div>
    		</div>
    		<div class="row">
    			<div class="col-lg-3">
    				<input type="hidden" name="userid" value="{{ Auth::id() }}">
						<label for="buyfrom" class="kh">ទិញពី</label>
						<select class="form-control" class="form-control" name="buyfrom" id="buyfrom"​>
							@foreach ($buyfrom as $b)
								<option value="{{ $b->name }}" {{ $invoices[0]->buyfrom==$b->name ? 'selected' : '' }}>{{ $b->name }}</option>
							@endforeach
						</select>
						<label for="customer" class="kh">ក្រុមបំពេញច្បាប់</label>
						<div class="input-group">
							<select class="form-control" name="sel_law" id="sel_law"​>
								@foreach ($co as $c)
									<option value="{{ $c->id }}" {{ $invoices[0]->law_id==$c->id ? 'selected' : '' }}>{{ $c->name }}</option>
								@endforeach
							</select>
							<div class="input-group-addon btn btn-default" id="add_co">
								<span class="fa fa-plus" ></span>
							</div>
						</div>
						<label for="delivery" class="kh">ក្រុមដឹកជញ្ជូន</label>
						<div class="input-group">
							<select class="form-control" name="sel_delivery" id="sel_delivery"​>
								@foreach ($deliveries as $de)
									<option value="{{ $de->id }}" {{ $invoices[0]->delivery_id==$de->id ? 'selected' : '' }}>{{ $de->name }}</option>
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
						<input type="text"  name="buyinv" id="buyinv" style="font-family:'khmer os system';height:40px;width:100%;padding:5px;border-radius:5px;border-width:1px;" value="{{ sprintf('%04d',$invoices[0]->buyinv) }}">
					</div>
					<label for="cofee" class="kh">ថ្លៃរត់ច្បាប់</label>
					<div>
						<input type="text" class="number-separator" name="lawfee" id="lawfee" style="height:40px;width:100%;padding:5px;border-radius:5px;border-width:1px;" value="{{ phpformatnumber($invoices[0]->lawfee) }}">
					</div>
					<label for="transportfee" class="kh">ថ្លៃដឹកជញ្ជូន/Kg</label>
					<div>
						<input type="text" class="number-separator carfee" name="carfee" id="carfee" style="height:40px;width:100%;padding:5px;border-radius:5px;border-width:1px;" value="{{ phpformatnumber($invoices[0]->carfee) }}">
					</div>	
					
    			</div>
    			<div class="col-lg-3">
    				<label for="carnum" class="kh">លេខឡាន</label>
					<div>
						<input type="text" name="carnum" id="carnum" style="font-family:'khmer os system';height:40px;width:100%;padding:5px;border-radius:5px;border-width:1px;" value="{{ $invoices[0]->carnum }}">
					</div>	
					<label for="driver" class="kh">អ្នកបើកបរ</label>
					<div>
						<input type="text"  name="driver" id="driver" style="font-family:'khmer os system';height:40px;width:100%;padding:5px;border-radius:5px;border-width:1px;" value="{{ $invoices[0]->driver }}">
					</div>
					<label for="driver" class="kh">បរិមាណសរុប</label>
					<div>
						<input type="text" class="number-separator totalweight" name="totalweight" id="totalweight" style="height:40px;width:100%;padding:5px;border-radius:5px;border-width:1px;" value="{{ $invoices[0]->totalweight }}">
					</div>
    			</div>
    			<div class="col-lg-3">
    				<input type="hidden" id="customervalue" value="{{ $invoices[0]->supplier->customerprice }}" readonly>
    				<label for="customer" class="kh">លក់ជូនអតិថិជន</label>
						<div class="input-group">
							<select class="form-control" name="sel_supplier" id="sel_supplier"​>
								
								@foreach ($suppliers as $sup)
									<option value="{{ $sup->id }}" {{ $invoices[0]->supplier_id==$sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
								@endforeach
							</select>
							<div class="input-group-addon btn btn-default" id="add_supplier">
								<span class="fa fa-plus" ></span>
							</div>
						</div>
						<label for="saledate" class="kh">កាលបរិច្ឆេទ</label>
						<div class="input-group">
							<input type="text" name="invdate" id="invdate" class="form-control" style="height:40px;" value="{{ date('d-m-Y',strtotime($invoices[0]->invdate)) }}">
							<div class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</div>
						</div>
						<label for="driver" class="kh">សរុបថ្លៃដឹកជញ្ជូន</label>
						<div>
							<input type="text"  name="totaldelivery" id="totaldelivery" style="height:40px;width:100%;padding:5px;border-radius:5px;border-width:1px;" value="{{ phpformatnumber($invoices[0]->totaldelivery) }}">
						</div>
    			</div>
    		</div>
    	</div>
    {{-- ---------------- --}}
    <br>
	    <div class="row">
	    	<div class="col-md-12">
	    		<div class="panel panel-default">
	    			<div class="panel-heading">
	    				<h3 class="panel-title" style="color:red;"><strong>Invoice Detail</strong></h3>
	    			</div>
	    			<div class="panel-body" style="overflow:auto;">
	    				<div class="table-responsive">
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
	    							@foreach ($invoices as $key => $inv)
	    								@php
	    									$dp=0;
	    									if($inv->cur=='$'){
	    										$dp=2;
	    									}
	    								@endphp
	    								<tr>

	    									<td class="no" style="text-align:center;padding:7px 0px 0px 0px;">{{ ++ $key }}</td>
											<td style="padding:0px;width:100px;">
											<input type="text" class="form-control " name="productid[]" required style="border-style:none;width:100px;" value="{{ $inv->product_id }}">
											</td>
											<td style="padding:0px;width:160px;">
											<input type="text" class="form-control barcode" name="barcode[]" required style="border-style:none;width:160px;" value="{{ $inv->barcode }}">
											</td>
											<td style="padding:0px;width:250px;">
											<input type="text" class="form-control name" name="name[]" required style="border-style:none;font-family:khmer os system;width:250px;" value="{{ $inv->productname }}">
											</td>

											<td style="padding:0px;width:70px;">
											<input type="text" class="form-control qty1 canenter" name="qty1[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="{{ $inv->qty }}">
											</td>
											<td style="padding:0px;width:50px;">
											<input type="text" class="form-control unit1" name="unit1[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="{{ $inv->unit }}">
											</td>

											<td style="padding:0px;width:70px;">
											<input type="text" class="form-control qty2 canenter" name="qty2[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="{{ $inv->qtycut }}">
											</td>
											<td style="padding:0px;width:50px;">
											<input type="text" class="form-control unit2" name="unit2[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="{{ $inv->unit }}">
											</td>

											<td style="padding:0px;width:70px;">
											<input type="text" class="form-control qty3" name="qty3[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="{{ $inv->quantity }}">
											</td>
											<td style="padding:0px;width:50px;">
											<input type="text" class="form-control unit3" name="unit3[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="{{ $inv->unit }}">
											</td>
											<td style="padding:0px;width:120px;">
											<input type="text" class="form-control text-right unitprice canenter" name="unitprice[]" required style="border-style:none;width:120px;" value="{{ phpformatnumber($inv->unitprice) }}">
											</td>
											<td style="padding:0px;width:40px;">
												<select name="cur[]" class="form-control cur canenter" style="border-style:none;margin-top:0px;padding:0px;width:40px;">
													<option value="0" {{ $inv->cur=="R" ? 'selected' : '' }}>R</option>
													<option value="1" {{ $inv->cur=="B" ? 'selected' : '' }}>B</option>
													<option value="2" {{ $inv->cur=="$" ? 'selected' : '' }}>$</option>
												</select>
											</td>
											<td style="padding:0px;width:80px;">
											<input type="text" class="form-control discount canenter" name="discount[]" required style="border-style:none;text-align:center;width:80px;" value="{{ $inv->discount }}">
											</td>
											<td style="padding:0px;text-align:right; width:270px;" colspan=2>
											<input type="text" class="form-control text-right amount" name="amount[]" required style="border-style:none;width:270px;" value="{{ phpformatnumber($inv->amount) }}">
											</td>
											<td style="padding:0px;width:50px">
											<input type="text" class="form-control cur1" name="cur1[]" required style="border-style:none;width:50px;" value="{{ $inv->cur }}">
											</td>
											<td style="padding:0px;width:80px">
											<input type="text" class="form-control focunit" name="focunit[]" required style="border-style:none;width:80px;text-align:right;"​ value="{{ $inv->focunit }}">
											</td>
											<td style="padding:0px;width:50px">
											<input type="text" class="form-control sunit" name="sunit[]" required style="border-style:none;width:50px;"​ readonly value="{{ $inv->sunit }}">
											</td>
											<td style="padding:0px;width:70px">
											<input type="text" class="form-control multi" name="multi[]" required style="border-style:none;width:70px;"​ readonly value="{{ $inv->multiunit }}">
											</td>
											{{-- <td style="padding:0px;width:100px">
											<input type="text" class="form-control qtyunit" name="qtyunit[]" required style="border-style:none;width:100px;" readonly value="{{ $inv->qtyunit }}">
											</td> --}}
											<td style="padding:0px;width:80px">
											<input type="text" class="form-control submit" name="submit[]" required style="border-style:none;width:80px;" readonly value="{{ $inv->submit }}">
											</td>
											<td style="padding:0px;width:80px;">
											<input type="text" class="form-control costprice" name="costprice[]" required style="border-style:none;width:80px;" readonly value="{{ phpformatnumber($inv->cost) }}">
											</td>
											<td style="padding:0px;width:80px;">
											<input type="text" class="form-control costcur" name="costcur[]" required style="border-style:none;width:80px;" readonly value="{{ $inv->costcur }}">
											</td>
											<td style="text-align:center;padding:0px;">
												<a href="#" class="btn btn-warning btn-xs rowedit" style="color:blue;margin-top:5px;margin-right:5px;" data-pid="{{ $inv->product_id }}"
												data-submit="{{ $inv->submit }}" data-ind="{{ $key++ }}"><i class="fa fa-pencil"></i></a>
												<a href="#" class="btn btn-danger btn-xs rowremove" style="margin-top:5px;"><i class="fa fa-minus"></i></a>
											</td>
	    								</tr>
	    							@endforeach
	    							
	    							<tr>	
										<td colspan='13' style="border:none;">Note:</td>
	    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
	    								<td class="thick-line text-right" style="font-size:18px;padding:0px;"><input type="text" class="tfont" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="subtotal" name="subtotal" value="{{ phpformatnumber($inv->subtotal) }}"></td>
	    								<td class="thick-line text-left subcur" style="font-size:18px;"><strong>{{ $inv->cur }}</strong></td>
	    							</tr>
	    							<tr>
	    								<td colspan="13" style="border:none;padding:0px;"><input type="text" name="invnote" style="font-family:'Khmer Os System';width:100%;height:40px;padding:8px;border-width:1px;"></td>
	    								<td class="no-line text-center"><strong>Shipping</strong></td>
	    								<td class="no-line" style="text-align:right;padding:0px;"><input type="text" class="tfont" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="shipcost" name="shipcost" value="{{ phpformatnumber($inv->shipcost) }}"></td>
	    								<td class="no-line shipcur" style="font-size:18px;"><strong>{{ $inv->cur }}</strong></td>
	    							</tr>
	    							<tr>
	    								<td colspan="13" style="border:none;"></td>
	    								<td class="no-line text-center"><strong>Discount</strong></td>
	    								<td class="no-line" style="text-align:right;padding:0px;"><input type="text" class="tfont" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="invdiscount" name="invdiscount" value="{{ $inv->invdiscount }}"></td>
	    								<td class="no-line" style="font-size:18px;"><strong>%</strong></td>
	    							</tr>
	    							<tr>
	    								<td colspan="13" style="border:none;">
								                
	    								</td>
	    								
	    								<td class="no-line text-center"><strong>Total</strong></td>
	    								<td class="no-line text-right" style="font-size:18px;padding:0px;"><input type="text" class="tfont" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="lasttotal" name="lasttotal" value="{{ phpformatnumber($inv->total) }}"></td>
	    								
	    								<td class="no-line" style="font-size:18px;padding:0px;"><input type="text" style="width:50px;height:40px;font-size:18px;border-style:none;text-align:left;padding:8px;" name="lastcur" id="lastcur" value="{{ $inv->cur }}"></td>
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
										<a href="#" class="btn btn-warning pull-right btnupdate-sale" style="font-family:khmer os system;color:red;">កែប្រែទិន្ន័យ</a>

										<a href="#" class="btn btn-danger pull-right btndel-purchase" data-id="{{ $invoices[0]->invid }}" style="font-family:khmer os system;margin-right:5px;">លុបវិក័យប័ត្រ</a>
										
										<a href="javascript:window.close()" class="btn btn-default pull-right" style="font-family:khmer os system;color:blue;margin-right:5px;">ចាកចេញ</a>

										<a href="javascript:location.reload();" class="btn btn-primary pull-right" style="margin-right:5px;">Refresh</a>
									
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
@include('modal.additem_modal')
@include('modal.searchproduct_modal') 
@include('modal.supplier_modal')
@include('modal.delivery_modal')
@include('modal.tax_modal')
@include('sales.confirm_delete')
@endsection
@section('script')
<script src="{{ asset('js') }}/numberinput.js"></script>
	@include('script.script-sale')
@endsection