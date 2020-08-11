{{-- @php
	$myfile = fopen("stockcurrency.txt", "r") or die("Unable to open file!");
	//$myfile = fopen("E:\PHPfile\best.txt", "r") or die("Unable to open file!");
	$stockcur= fgets($myfile);
	fclose($myfile);
@endphp --}}
<div class="table-responsive" style="overflow-x:auto;">
	    					<table class="table table-bordered table-hover">
	    						<thead>
	                               <tr style="font-family:khmer os system;">
	        							<td class="text-center">លរ</td>
	        							<td class="text-center">ថ្ងៃទី</td>
	        							<td class="text-center">លេខអាយឌី</td>
	        							<td class="text-center">លេខកូដទំនិញ</td>
	        							<td class="text-center">ឈ្មោះទំនិញ</td>
	        							<td class="text-center">ក្រុមទំនិញ</td>
	        							<td class="text-center">ម៉ាកទំនិញ</td>
	        							<td class="text-center">សរុបចំនួន</td>
	        							
	        							<td class="text-center" colspan=2>ចំនួនរាយ</td>
	        							<td class="text-center" colspan=2>ថែមរាយ</td>
	        							<td class="text-center" colspan=2>សរុបទឹកប្រាក់ទិញ</td>
	        							<td class="text-center" colspan=2>ប្តូរប្រាក់</td>
	        							
	      								<td class="text-center">Submit</td>
	        							<td class="text-center">Action</td>
	                                </tr>
	    						</thead>

	    						<tbody id="summary_buylist" style="font-family:khmer os system">
	    							{{-- @include('purchases.purchaselist') --}}
									@php
										function phpformatnumber($num){
											$dc=0;
											$p=strpos((float)$num,'.');
											if($p>0){
												$fp=substr($num,$p,strlen($num)-$p);
												$dc=strlen((float)$fp)-2;
												
											}
											if($dc>6){
												$dc=6;
											}
											return number_format($num,$dc,'.',',');
										}
									@endphp
	    							@foreach ($item_buy as $key => $item)
	    								
	    								<tr>
	    									<td style="padding:0px;font-size:12px;width:60px;">
												<input type="text" name="no[]" value="{{ ++ $key }}" style="border-style:none;height:40px;width:60px;padding:5px;text-align:center;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:12px;width:100px;">
												<input type="text" name="itemdate[]" value="{{ date('d-m-Y',strtotime($item->buydate)) }}" style="border-style:none;height:40px;width:100px;padding:5px;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:12px;width:100px;">
	    										<input type="text" name="productid[]" value="{{ $item->product_id }}" style="border-style:none;height:40px;padding:5px;width:100px;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:12px;width:100px;">
	    										<input type="text" name="productcode[]" value="{{ $item->product->code }}" style="border-style:none;height:40px;padding:5px;width:100px;" readonly>
	    									</td>
	    									<td style="padding:0px;width:250px;">
	    										<input type="text" value="{{ $item->product->name }}" style="border-style:none;height:40px;width:250px;padding:5px;" readonly>
	    										
	    									</td>
	    									<td style="padding:0px;">
												<input type="text" name="category[]" value="{{ $item->product->category->name }}" style="border-style:none;height:40px;padding:5px;width:120px;" readonly>
	    									</td>
	    									<td style="padding:0px;">
												<input type="text" name="brand[]" value="{{ $item->product->brand->name }}" style="border-style:none;height:40px;padding:5px;width:120px;" readonly>
	    									</td>

	    									<td style="padding:0px;font-size:16px;width:100px;">
	    										<input type="text" name="qty1[]" value="{{ App\Sale_Detail::convertqtysale($item->product_id,$item->tqty) }}" style="border-style:none;text-align:right;height:40px;padding:5px;width:100px;" readonly>
	    									</td>

	    									<td style="padding:0px;font-size:16px;width:100px;">
	    										<input type="text" name="qty[]" value="{{ $item->tqty }}" style="border-style:none;text-align:right;height:40px;padding:5px;width:100px;" readonly>
	    									</td>

	    									<td style="padding:0px;font-size:12px;width:50px;">
	    										<input type="text" value="{{ $item->product->itemunit }}" name="unit[]" style="border-style:none;height:40px;padding:5px;width:50px;" readonly>
	    									</td>

	    									<td style="padding:0px;font-size:16px;width:80px;">
	    										<input type="text" name="foc[]" value="{{ $item->tfoc }}" style="border-style:none;text-align:right;height:40px;padding:5px;width:80px;" readonly>
	    									</td>

	    									<td style="padding:0px;font-size:12px;width:50px;">
	    										<input type="text" value="{{ $item->product->itemunit }}" name="unitfoc[]" style="border-style:none;height:40px;padding:5px;width:50px;" readonly>
	    									</td>

	    									<td style="padding:0px;font-size:16px;width:150px;">
	    										<input type="text" name="amount[]" value="{{ phpformatnumber($item->tamount) }}" style="border-style:none;text-align:right;width:150px;height:40px;padding:5px;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:16px;width:40px;">
	    										<input type="text" value="{{ $item->dcur }}" name="cur[]" style="border-style:none;width:40px;height:40px;padding:5px;" readonly>
	    									</td>

											<td style="padding:0px;font-size:16px;width:150px;">
	    										<input type="text" name="amountusd[]" value="{{ phpformatnumber(App\Purchase_Detail::exchangecurrency($item->dcur,$item->product->cur,$item->tamount))}}" style="border-style:none;text-align:right;width:150px;height:40px;padding:5px;" readonly>
	    									</td>
	    									<td style="padding:0px;font-size:16px;width:40px;">
	    										<input type="text" value="{{ $item->product->cur }}" name="pcur[]" style="border-style:none;width:40px;height:40px;padding:5px;" readonly>
	    									</td>

											<td style="padding:0px;font-size:16px;width:40px;">
	    										<input type="text" value="{{ $item->submit }}" name="submit[]" style="border-style:none;width:70px;height:40px;padding:5px;text-align:center;" readonly>
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
		

