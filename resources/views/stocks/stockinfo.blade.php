
@extends('layouts.master')
@section('pagetitle')
	Stock info
@endsection
@section('css')
	
	<style type="text/css" media="print">
		  @page
		    {
		        size:A4 landscape;
		       
		    }

	</style>
	
@endsection
@section('content')
	 <div class="panel panel-default">
      <div class="panel-heading" style="text-align:center;font-size:16px;"><b> Stock Information </b></div>
      <div class="panel-body">
      		<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-body">	
								<input type="hidden" value="-1" id="sby">
								<div class="col-lg-2">	
									<label for="date">Date</label>
									<input type="text" name="dateshow" id="dateshow" class="form-control" style="height:40px;" disabled>
								</div>
							
							<div class="col-lg-3">
								<button class="btn btn-info btnsearchbydate" style="margin-top:27px;size:40px;">Show</button>
								<button class="btn btn-info" id="btnsearchbydate2" style="margin-top:27px;size:40px;">Show2</button>
								
							</div>

							<div class="col-lg-3">
								<label for="select">Search Type:</label>
								<select name="typesearch" id="typesearch" class="form-control typesearch" style="height:40px;">
									<option value="-1"></option>
									<option value="0">Category</option>
									<option value="1">Brand</option>
									<option value="2">Items</option>
									<option value="3">Product Code</option>
									<option value="4">Barcode</option>
								</select>
							</div>
							<div class="col-lg-4" id="fillsearch">
								
								
							</div>
						</div>
					</div>
				</div>
	
				<div class="row">
			    	<div class="col-lg-12">
			    		<div class="panel panel-default">
			    			<div class="panel-heading">
			    				<h3 class="panel-title"><strong>Stock List</strong></h3>
			    			</div>
			    			
			    			<div class="panel-body" id="stockbody">
									<table style="margin-top:0px;">
										<tr>
											<td style="width:250px;font-size:16px;">Stock Information</td>
											<td style="width:220px;font-size:16px;">Date: &nbsp;<span id="printdate"></span></td>
											<td style="width:620px;font-size:16px;font-family:khmer os system;">បង្ហាញតាម : &nbsp;<span id="viewby">ថ្ងៃទី</span></td>
										</tr>
									</table>
								<br>
								<div id="table_data">
									@include('stocks.stocklist')
								</div>
			    			</div>
			    		</div>
			    	</div>
			    </div>
      </div>
    </div>
	@include('stocks.stockprocess_modal')
	@include('stocks.stockclose_modal')
@endsection
@section('script')
	<script src="{{ asset('js') }}/numberinput.js"></script>
	@include('script.script-stock')
@endsection
