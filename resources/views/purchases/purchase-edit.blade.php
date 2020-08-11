
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
	label{
		font-family:"Khmer OS System";
	}
	</style>
@endsection

@section('content')
	
	<div class="container-fulid">
	<div class="alert alert-danger print-error-msg" style="display:none">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul></ul>
    </div>
    <form action="#" method="POST" id="frmeditpurchase">
    	@csrf
    	
        <div class="col-lg-12">
        	<div class="row">	
	    		<div class="invoice-title">
	    			<h2 id="frmtitle" style="color:red;">Purchase Edit</h2><h3 class="pull-right" style="background:yellow;padding:5px;" id="orderid">INV#: {{ sprintf('%04d',$invoices[0]->invid) }} </h3>
	    			<input type="hidden" name="purchase_id" id="purchase_id" value="{{ $invoices[0]->invid }}">
	    		</div>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-lg-4">
    				<label for="delivery">ក្រុមដឹកជញ្ជូន</label>
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
    			<div class="col-lg-4">
    				<input type="hidden" name="userid" value="{{ Auth::id() }}">
						
						<label for="supplier">អ្នកផ្គត់ផ្គង់</label>
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
    			</div>
				<div class="col-lg-4">
					<div class="row">
						<div class="col-lg-6">
							<label for="invdate">កាលបរិច្ឆេត</label>
							<input type="text" class="form-control" id="dd" style="height:40px;" value="{{ date('d-m-Y',strtotime($invoices[0]->invdate)) }}" readonly>
						</div>
						<div class="col-lg-6">
							<label for="saveby">អ្នកត់ត្រា</label>
							<input type="text" class="form-control" style="height:40px;" value="{{ $invoices[0]->username }}" readonly>
						</div>
					</div>
				</div>
    		</div>


    		<div class="row">
				<div class="col-lg-4">
					<label for="carnum">លេខឡាន</label>
						<input type="text"​ class="form-control" name="carnum" id="carnum" style="font-family:'khmer os system';height:40px;width:100%;" value="{{ $invoices[0]->carnum }}">
    			</div>
    			<div class="col-lg-4">
    				<label for="driver">អ្នកបើកបរ</label>
					<input type="text"  name="driver" id="driver" style="font-family:'khmer os system';height:40px;width:100%;" value="{{ $invoices[0]->driver }}">
    			</div>


    			<div class="col-lg-4">
    				<label for="date">Date</label>
    				<div class="input-group">
						<input type="text" name="invdate1" id="invdate1" class="form-control" style="height:40px;" value="{{ date('d-m-Y',strtotime($invoices[0]->invdate)) }}">
						<div class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</div>
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
	    			<div class="panel-body" style="overflow:auto;">
	    				<div class="table-responsive">
	    					<table class="table table-bordered table-hover">
	    						<thead>
	                               <tr>
	        							<td class="text-center" style="font-family:'Khmer Os System'">លរ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System';">លេខកូដ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">បាកូដ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">បរិយាយ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>ចំនួន</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>ចំនួនកាត់</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>ចំនួនពិត</td>
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'" colspan=2>តំលៃទិញ</td>
	        							
	        							
	        							<td class="text-center" style="font-family:'Khmer Os System'">បញ្ចុះ(%)</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​ colspan=3>សរុប</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​>ថែមរាយ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​>ឯកតា</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​>មេគុណ</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'"​>ចំនួនរាយ</td>
	        							<td class="text-center"​ style="font-family:'Khmer Os System';width:80px;"​>កាត់ស្តុក</td>
	        							<td class="text-center" style="font-family:'Khmer Os System'">សកម្មភាព</td>
	        							
	                                </tr>
	    						</thead>
	    						<tbody id="invoice_items">
	    							@foreach ($invoices as $key => $inv)
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
											<input type="text" class="form-control qty1 canenter" name="qty1[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="{{ $inv->qty }}" {{ $inv->submit==1?'readonly':'' }}>
											</td>
											<td style="padding:0px;width:50px;">
											<input type="text" class="form-control unit1" name="unit1[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="{{ $inv->unit }}">
											</td>

											<td style="padding:0px;width:70px;">
											<input type="text" class="form-control qty2 canenter" name="qty2[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="{{ $inv->qtycut }}" {{ $inv->submit==1?'readonly':'' }}>
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
											<input type="text" class="form-control text-right unitprice canenter" name="unitprice[]" required style="border-style:none;width:120px;" value="{{ $inv->dcur=='$'? number_format($inv->unitprice,2,'.',','):number_format($inv->unitprice) }}" {{ $inv->submit==1?'readonly':'' }}>
											</td>
											<td style="padding:0px;width:40px;">
												<select name="cur[]" class="form-control cur canenter" style="border-style:none;margin-top:0px;padding:0px;width:40px;">
													<option value="R" {{ $inv->cur=="R" ? 'selected' : '' }}>R</option>
													<option value="B" {{ $inv->cur=="B" ? 'selected' : '' }}>B</option>
													<option value="$" {{ $inv->cur=="$" ? 'selected' : '' }}>$</option>
												</select>
											</td>
											<td style="padding:0px;width:80px;">
											<input type="text" class="form-control discount canenter" name="discount[]" required style="border-style:none;text-align:center;width:80px;" value="{{ $inv->discount }}">
											</td>
											<td style="padding:0px;text-align:right; width:270px;" colspan=2>
											<input type="text" class="form-control text-right amount" name="amount[]" required style="border-style:none;width:270px;" value="{{ $inv->dcur=='$'? number_format($inv->amount,2,'.',','):number_format($inv->amount) }}">
											</td>
											<td style="padding:0px;width:50px">
											<input type="text" class="form-control cur1" name="cur1[]" required style="border-style:none;width:50px;" value="{{ $inv->cur }}">
											</td>
											<td style="padding:0px;width:100px">
											<input type="text" class="form-control focunit" name="focunit[]" required style="border-style:none;width:100px;" value="{{ $inv->focunit }}" {{ $inv->submit==1?'readonly':'' }}>
											</td>
											<td style="padding:0px;width:50px">
											<input type="text" class="form-control sunit" name="sunit[]" required style="border-style:none;width:50px;" readonly value="{{ $inv->sunit }}">
											</td>
											<td style="padding:0px;width:50px">
											<input type="text" class="form-control multi" name="multi[]" required style="border-style:none;width:50px;"​ readonly value="{{ $inv->multiunit }}">
											</td>
											<td style="padding:0px;width:100px">
											<input type="text" class="form-control qtyunit" name="qtyunit[]" required style="border-style:none;width:100px;" readonly value="{{ $inv->qtyunit }}">
											</td>
											<td style="padding:0px;width:70px">
											<input type="text" class="form-control submit" name="submit[]" required style="border-style:none;width:70px;" readonly value="{{ $inv->submit }}">
											</td>
											<td style="text-align:center;padding:0px;">
												<a href="#" class="btn btn-warning btn-xs rowedit" style="color:blue;margin-top:5px;margin-right:5px;" data-pid="{{ $inv->product_id }}"
												data-submit="{{ $inv->submit }}"><i class="fa fa-pencil"></i></a>
												<a href="#" class="btn btn-danger btn-xs rowremove" data-submit="{{ $inv->submit }}" style="margin-top:5px;"><i class="fa fa-minus"></i></a>
											</td>
	    								</tr>
	    							@endforeach
	    							
	    							<tr>	
										<td colspan='13' style="border:none;">Note:</td>
	    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
	    								<td class="thick-line text-right" style="font-size:18px;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="subtotal" name="subtotal" value="{{ $inv->cur=='$'? number_format($inv->subtotal,2,'.',','):number_format($inv->subtotal) }}"></td>
	    								<td class="thick-line text-left subcur" style="font-size:18px;"><strong>{{ $inv->cur }}</strong></td>
	    							</tr>
	    							<tr>
	    								<td colspan="13" style="border:none;padding:0px;"><input type="text" name="invnote" style="font-family:'Khmer Os System';width:100%;height:40px;padding:8px;"></td>
	    								<td class="no-line text-center"><strong>Shipping</strong></td>
	    								<td class="no-line" style="text-align:right;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="shipcost" name="shipcost" value="{{ $inv->cur=='$'? number_format($inv->shipcost,2,'.',','):number_format($inv->shipcost) }}"></td>
	    								<td class="no-line shipcur" style="font-size:18px;"><strong>{{ $inv->cur }}</strong></td>
	    							</tr>
	    							<tr>
	    								<td colspan="13" style="border:none;"></td>
	    								<td class="no-line text-center"><strong>Discount</strong></td>
	    								<td class="no-line" style="text-align:right;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="invdiscount" name="invdiscount" value="{{ $inv->invdiscount }}"></td>
	    								<td class="no-line" style="font-size:18px;"><strong>%</strong></td>
	    							</tr>
	    							<tr>
	    								<td colspan="13" style="border:none;">
	    									<div class="col-lg-4">
	    										<div class="row">
	    											<div class="input-group input-group-sm" style="width:100%">
								                  <input type="text" name="table_search" id="barcode_search" class="form-control pull-right" placeholder="Search Barcode">

								                  <div class="input-group-btn">
								                    <button type="button" class="btn btn-default btnsearchproduct"><i class="fa fa-search"></i></button>
								                  </div>
								                </div>
	    										</div>
	    										
	    									</div>
	    										<div class="col-lg-8">
	    											<div class="row">
	    													<a href="#" class="btn btn-warning pull-right btnupdate-purchase" style="font-family:khmer os system;color:red;">កែប្រែទិន្ន័យ</a>
	    											
	    											<a href="#" class="btn btn-danger pull-right btndel-purchase" data-id="{{ $inv->invid }}" style="font-family:khmer os system;margin-right:5px;">លុបវិក័យប័ត្រ</a>
	    											
	    											<a href="javascript:window.close()" class="btn btn-default pull-right" style="font-family:khmer os system;color:blue;margin-right:5px;">ចាកចេញ</a>

	    											<a href="javascript:location.reload();" class="btn btn-primary pull-right" style="margin-right:5px;">Refresh</a>
	    											
	    											</div>
	    										
	    										</div>
								                
	    								</td>
	    								
	    								<td class="no-line text-center"><strong>Total</strong></td>
	    								<td class="no-line text-right" style="font-size:18px;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="lasttotal" name="lasttotal" value="{{ $inv->cur=='$' ? number_format($inv->total,2) : number_format($inv->total) }}"></td>
	    								
	    								<td class="no-line" style="font-size:18px;padding:0px;"><input type="text" style="width:50px;height:40px;font-size:18px;border-style:none;text-align:left;padding:8px;" name="lastcur" id="lastcur" value="{{ $inv->cur }}"></td>
	    							</tr>
	    						</tbody>
	    					</table>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
    </form>
</div>

@include('modal.searchproduct_modal') 
@include('modal.supplier_modal')
@include('modal.delivery_modal')
@include('purchases.confirm_delete')

@endsection
@section('script')
	@include('script.script-purchase')
@endsection