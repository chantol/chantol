
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
						<th>លរ</th>
						<th>ថ្ងៃទី</th>
						<th>អ្នកត់ត្រា</th>
						<th>អតិថិជន</th>
						<th>គិតពី</th>
						<th>ដល់</th>
						<th>សរុបទឹកប្រាក់</th>
						<th>ទូទាត់រួច</th>
						<th>នៅខ្វះ</th>
						<th>បំណុលចាស់</th>
						<th>សរុបចាស់ថ្មី</th>
						<th>បានសង</th>
						<th>នៅជំពាក់</th>
					    <th>រូបិយ</th>
						<th>Act</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($closelist as $key => $cl)
						<tr>
							<td class="rowclick">{{ ++$key }}</td>
							<td class="rowclick">{{ date('d-m-Y',strtotime($cl->dd)) }}</td>
							<td class="rowclick">{{ $cl->user->name }}</td>
							<td class="rowclick" style="font-family:khmer os system">{{ $cl->supplier->name }}</td>
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
								<a href="#" class="btn btn-danger btndellist" data-id="{{ $cl->id }}"><i class="fa fa-trash"></i></a>
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
        			<h3 style="padding-top:5px;padding-bottom:5px;">Total List</h3>
        			<input type="hidden" id="icur" name='icur'>
        			<input type="hidden" name="userid" value="{{ Auth::id() }}">
        		</div>
        		<div class="panel-body">
        			<div class="col-lg-4">
			            <label for="tnew" class="kh">សរុបថ្មី</label>
			                <input type="text" class="form-control" name="inv_total" id="inv_total" value="{{ phpformatnumber($totalmoney[0]->t_total) }}" readonly style="font-size:22px;"> 
			            </div>
			            <div class="col-lg-4">
			                
			                    <label for="tnew" class="kh">បានសង</label>
			                    <input type="text" class="form-control" name="inv_deposit" id="inv_deposit" value="{{ phpformatnumber($totalmoney[0]->t_deposit) }}" readonly style="font-size:22px;">
			               
			            </div>
			            <div class="col-lg-4">
			                
			                    <label for="tnew" class="kh">នៅខ្វះ</label>
			                    <input type="text" class="form-control" name="inv_bal" id="inv_bal" value="{{ phpformatnumber($totalmoney[0]->t_total - $totalmoney[0]->t_deposit) }}" readonly style="font-size:22px;">
			                
			            </div>
			            <div class="col-lg-4">
			                
			                    <label for="tnew" class="kh">យោងបញ្ជីចាស់</label>
			                    <input type="text" class="form-control" name="old_debt" id="old_debt" value="{{ $listdebt->count()>0? phpformatnumber($listdebt[0]->balance):'0' }}" style="font-size:22px;">
			                
			            </div>
			            <div class="col-lg-4">
			                
			                    <label for="tnew" class="kh">សរុបចាស់ថ្មី</label>
			                    <input type="text" class="form-control" name="newbalance" id="newbalance" value="{{ phpformatnumber($totalmoney[0]->t_total - $totalmoney[0]->t_deposit + ($listdebt->count()>0? $listdebt[0]->balance:'0')) }}" readonly style="font-size:22px;">
			               
			            </div>
			            <div class="col-lg-4">
							<label for="dodate"​ class="kh">ថ្ងៃរក្សាទុក</label>
			            	<input type="text" name="dodate" id="dodate" class="form-control" style="font-size:22px;">
			                <a href="#" id="btnsavelist" class="btn btn-info pull-right" style="margin-top:15px;font-weight:bold;" disabled>Save List</a>
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
			{{-- @include('purchases.purchaselist') --}}
			@foreach ($invoices as $key => $inv)
				<tr>
					<td style="width:50px;text-align:center;">
		                  {{ ++ $key }}
					</td>
					<td style="text-decoration: underline;"><a href="#" data-id="{{ $inv->id }}" data-supname="{{ $inv->supplier->name }}" data-totalinv="{{ $inv->total }}" data-cur="{{ $inv->cur }}" name="invnum[]" class="showinvdetail">{{ sprintf("%04d",$inv->id) }}</a> </td>
					<td style="display:none;">
						<input type="text" name="invnum[]" value="{{ $inv->id }}">
					</td>
					<td>{{ date('d-m-Y',strtotime($inv->invdate)) }}</td>
					<td>{{ date('d-m-Y h:i:sa',strtotime($inv->created_at)) }}</td>
					<td>{{ $inv->user->name }}</td>
					<td>{{ $inv->supplier->name }}</td>
					
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
						<a href="{{ route('purchaseprint',$inv->id) }}" class="btn btn-default btn-xs btnprint" title="print"><i class="fa fa-print"></i></a>
					</td>
					
				</tr>
			@endforeach
			
			 
		</tbody>
		
	</table>
	
	 
</div>
		

