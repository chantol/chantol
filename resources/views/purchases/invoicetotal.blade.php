<div class="table-responsive" style="overflow-x:auto;">
	    					<table class="table table-bordered table-hover">
	    						<thead>
	                               <tr>
	        							<td class="text-center">No</td>
	        							<td class="text-center">Date</td>
	        							<td class="text-center">Product ID</td>
	        							<td class="text-center">Product Code</td>
	        							<td class="text-center">Product Name</td>
	        							<td class="text-center">Category</td>
	        							<td class="text-center">Brand</td>
	        							<td class="text-center" colspan=2>Qty Bought</td>
	        							
	        							<td class="text-center" colspan=2>Total Amount</td>
	      								<td class="text-center">Submit</td>
	        							<td class="text-center">Action</td>
	                                </tr>
	    						</thead>

	    						<tbody id="summary_buylist" style="font-family:khmer os system">
	    							{{-- @include('purchases.purchaselist') --}}

	    							@foreach ($item_buy as $key => $item)
	    								<tr>
	    									@php
	    										//$itotal=$inv->total + 0;//for convert 500.00 to 500

	    										if($item->cur=="R"){
	    											$decimal=0;
	    										}else{
	    											$decimal=0;
	    										}
	    										
	    									@endphp

	    									<td style="padding:0px;font-size:12px;width:60px;">
												<input type="text" name="no[]" value="{{ ++ $key }}" style="border-style:none;height:40px;width:60px;padding:5px;text-align:center;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:12px;width:100px;">
												<input type="text" name="itemdate[]" value="{{ date('d-m-Y',strtotime($item->buydate)) }}" style="border-style:none;height:40px;width:100px;padding:5px;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:12px;width:160px;">
	    										<input type="text" name="productid[]" value="{{ $item->product_id }}" style="border-style:none;height:40px;padding:5px;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:12px;width:160px;">
	    										<input type="text" name="productcode[]" value="{{ $item->product->code }}" style="border-style:none;height:40px;padding:5px;" readonly>
	    									</td>
	    									<td style="padding:0px;width:250px;">
	    										<input type="text" value="{{ $item->product->name }}" style="border-style:none;height:40px;width:250px;padding:5px;" readonly>
	    										
	    									</td>
	    									<td style="padding:0px;">
												<input type="text" name="category[]" value="{{ $item->product->category->name }}" style="border-style:none;height:40px;padding:5px;width:150px;" readonly>
	    									</td>
	    									<td style="padding:0px;">
												<input type="text" name="brand[]" value="{{ $item->product->brand->name }}" style="border-style:none;height:40px;padding:5px;width:120px;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:22px;width:160px;">
	    										<input type="text" name="qty[]" value="{{ $item->tqty }}" style="border-style:none;text-align:right;height:40px;padding:5px;" readonly>
	    									</td>

	    									<td style="padding:0px;font-size:16px;width:50px;">
	    										<input type="text" value="{{ $item->product->itemunit }}" name="unit[]" style="border-style:none;height:40px;padding:5px;width:50px;" readonly>
	    									</td>

	    									<td style="padding:0px;font-size:22px;width:250px;">
	    										<input type="text" name="amount[]" value="{{ $item->dcur=='$' ? number_format($item->tamount,2,'.',','):number_format($item->tamount)  }}" style="border-style:none;text-align:right;width:250px;height:40px;padding:5px;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:16px;width:40px;">
	    										<input type="text" value="{{ $item->dcur }}" name="cur[]" style="border-style:none;width:40px;height:40px;padding:5px;" readonly>
	    									</td>
											<td style="padding:0px;font-size:12px;width:40px;">
	    										<input type="text" value="{{ $item->submit }}" name="submit[]" style="border-style:none;width:40px;height:40px;padding:5px;" readonly>
	    									</td>
	    									<td style="text-align:center;">
	    										<a href="#" class="btn btn-warning btn-xs btnsubmitbyitem" id="btnsubmitbyitem{{ $item->product_id }}" title="Submit" style="color:blue;" data-submit="{{ $item->submit }}">{{ $item->submit==0?'Submit':'Cancel' }}</a>
	    									
	    									</td>
	    									
	    								</tr>
	    							@endforeach
	    							
	    						</tbody>
	    					
	    					</table>
	    					
	    					 {{-- {!! $invoices->links() !!} --}}
	    				</div>
		

