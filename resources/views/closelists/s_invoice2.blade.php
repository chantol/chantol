
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
<div class="row">
	<div class="col-lg-12">
		<div style="overflow:auto;">
			<table class="table table-hover table-bordered">
				<thead style="font-family:khmer os system">
					<tr>
						<td>លរ</td>
						<td>ID</td>
						<td>ថ្ងៃទី</td>
						<td>អ្នកត់ត្រា</td>
						<td>អតិថិជន</td>
						<td>គិតពី</td>
						<td>ដល់</td>
						<td>សរុបទឹកប្រាក់</td>
						<td>ទូទាត់រួច</td>
						<td>នៅខ្វះ</td>
						<td>បំណុលចាស់</td>
						<td>សរុបចាស់ថ្មី</td>
						<td>បានសង</td>
						<td>នៅជំពាក់</td>
					    <td>រូបិយ</td>
					    <td>Action</td>
					</tr>
				</thead>
				<tbody id="tbl_closelist">
					@foreach ($closelist as $key => $cl)
						<tr>
							<td class="rowclick">{{ ++$key }}</td>
							<td class="rowclick">{{ $cl->id }}</td>
							<td class="rowclick">{{ date('d-m-Y',strtotime($cl->dd)) }}</td>
							<td class="rowclick">{{ $cl->user->name }}</td>
							<td class="rowclick" style="font-family:khmer os system;">{{ $cl->supplier->name }}</td>
							<td class="rowclick">{{ date('d-m-Y',strtotime($cl->d1)) }}</td>
							<td class="rowclick">{{ date('d-m-Y',strtotime($cl->d2)) }}</td>
							<td class="rowclick">{{ phpformatnumber($cl->ivamount) }}</td>
							<td class="rowclick">{{ phpformatnumber($cl->ivdeposit) }}</td>
							<td class="rowclick">{{ phpformatnumber($cl->ivbalance) }}</td>
							<td class="rowclick">{{ phpformatnumber($cl->oldlist) }}</td>
							<td class="rowclick">{{ phpformatnumber($cl->total) }}</td>
							<td class="rowclick">{{ phpformatnumber($cl->deposit) }}</td>
							<td class="rowclick">{{ phpformatnumber($cl->total - $cl->deposit) }}</td>
							<td class="rowclick">{{ $cl->cur }}</td>
							<td>
								<a href="" class="btn btn-danger btn-sm btndellist" data-id="{{ $cl->id }}" data-cusid="{{ $cl->supplier_id }}" data-cur="{{ $cl->cur }}">Del</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
        	<div class="panel panel-warning">
        		<div class="panel-heading">
        			<h3 style="padding-top:5px;padding-bottom:5px;">Payment Form</h3>
        			<input type="hidden" id="icur" name='icur'>
        			<input type="hidden" name="userid" value="{{ Auth::id() }}">
        		</div>
        		<div class="panel-body">
        			<div class="row">
        				<div class="col-lg-4">
				            <label for="tnew" class="kh">សរុបទឹកប្រាក់ជំពាក់</label>
				            <input type="text" class="form-control" name="t_debt" id="t_debt" value="" style="font-size:18px;font-weight:bold;" readonly> 
			            </div>
			            <div class="col-lg-4">
		                    <label for="tnew" class="kh">បានសង</label>
		                    <input type="text" class="form-control" name="t_deposit" id="t_deposit" value="" style="font-size:18px;font-weight:bold;" readonly>
			            </div>
			            <div class="col-lg-4">
		                    <label for="tnew" class="kh">នៅខ្វះ</label>
		                    <input type="text" class="form-control" name="t_bal" id="t_bal" value="" style="font-size:18px;font-weight:bold;" readonly>
			            </div>
			            <div class="col-lg-4">
		                    <label for="tnew" class="kh">ទឹកប្រាក់ទទួល</label>
		                    <input type="text" class="form-control" name="receive" id="receive" value="" style="border-color:red;font-size:18px;font-weight:bold;" required>
			            </div>
			            <div class="col-lg-4">
		                    <label for="tnew" class="kh">ទឹកប្រាក់ជំពាក់</label>
		                    <input type="text" class="form-control" name="balance" id="balance" value="" style="font-size:18px;font-weight:bold;" readonly>
			            </div>
						<div class="col-lg-4">
							<label for="dodate"​ class="kh">ថ្ងៃបង់ប្រាក់</label>
			            	<input type="text" name="dodate" id="dodate" class="form-control" style="font-size:18px;">
			                <input type="hidden" name="closelistid" id="closelistid">
		            	</div>
        			</div>
    				<div class="row">
    					<div class="col-lg-10">
    						<label for="note" class="kh">ផ្សេងៗ</label>
    						<input type="text" id="note" name="note" class="form-control" style="font-family:khmer os system;">
    					</div>
    					<div class="col-lg-2">
    						<a href="#" id="btnsavepaid" class="btn btn-info pull-right" style="margin-top:30px;width:100px;" disabled>Paid</a>
    					</div>
    				</div>
		            
        	</div>
        </div>
   </div>
  <div class="col-lg-12">
  		<div class="panel panel-info" >
  			<div class="panel-heading">
  				<h3 style="padding-top:5px;padding-bottom:5px;">Paid List</h3>
  			</div>
  			<div class="panel-body">
  				<div style="overflow:auto;">
  					<table class="table table-hover table-bordered" style="table-layout:fixed;">
  						<thead>
	  						<tr style="font-family:khmer os system;text-align:center;">
	  							<td style="width:60px;">លរ</td>
	  							<td style="width:80px;">ID</td>
	  							<td style="width:100px;">ថ្ងៃបង់ប្រាក់</td>
	  							<td style="width:120px;">អ្នកកត់ត្រា</td>
	  							<td style="width:150px;">ទឹកប្រាក់បង់</td>
	  							<td style="width:150px;">នៅខ្វះ</td>
	  							<td style="width:300px;">ផ្សេងៗ</td>
	  							<td style="width:60px;">Action</td>
	  						</tr>
	  					</thead>
	  					<tbody id="tbl_paiddetail">

	  					</tbody>
  					</table>
  				</div>
  					
  			
  				
  			</div>
  		</div>
  </div>
</div>


<div class="table-responsive" style="overflow:auto;">
	<table class="table table-bordered table-hover">
		<thead>
           <tr>
				<td class="text-center" style="font-family:'Khmer Os System'">លរ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">លេខវិ</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃទី</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ថ្ងៃរក្សាទុក</td>
				<td class="text-center" style="font-family:'Khmer Os System'">អ្នកកត់ត្រា</td>
				<td class="text-center" style="font-family:'Khmer Os System'">អតិថិជន</td>
				<td class="text-center" style="font-family:'Khmer Os System'">សរុបទឹកប្រាក់</td>
				<td class="text-center" style="font-family:'Khmer Os System'">ថ្លៃដឹកជញ្ជូន</td>
				<td class="text-center" style="font-family:'Khmer Os System'">បញ្ចុះ(%)</td>
				<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>សរុបទឹកប្រាក់</td>
				<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>បានសង</td>
				<td class="text-center"​ style="font-family:'Khmer Os System'" colspan=2​>ទឹកប្រាក់ជំពាក់</td>
				
				<td class="text-center" style="font-family:'Khmer Os System'">ទូទាត់(%)</td>
				<td class="text-center">Print</td>
            </tr>
		</thead>
		<tbody id="invoicelist">
			 
		</tbody>
	</table>
</div>
		

