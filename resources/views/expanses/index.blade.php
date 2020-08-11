@extends('layouts.master')
@section('pagetitle')
	Expanse Record
@endsection
@section('css')
	<link href="{{ asset('css') }}/jquery.datetimepicker.min.css" rel="stylesheet">
	<link href="{{ asset('css') }}/toastr.min.css" rel="stylesheet">
	
	<style type="text/css">
		@page
		    {
		    	size:A4;
		        margin:20mm 5mm 5mm 5mm;
		       
		    }
		.student-photo{
			height:250px;
			padding-left:1px;
			padding-right:1px;
			border:1px solid #ccc;
			background:#eee;
			width:240px;
			margin:0 auto;
			
		}
		.photo > input[type='file']{
			display:none;
		}
		.photo{
			width:30px;
			height:30px;
			border-radius:100%;
		}
		.student-id{

			background-repeat:repeat-x;
			border-color:#ccc;
			padding:1px;
			text-align:center;
			background:#eee;
			border-bottom:1px solid #ccc;
		}
		.btn-browse{
			border-color:#ccc;
			padding:1px;
			text-align:center;
			background:#eee;
			border:none;
			border-top:1px solid #ccc;
			height:25px;
		}
		fieldset{
			margin-top:0px;
		}
		fieldset legend{
			display:block;
			width:100%;
			padding:0;
			font-size:15px;
			line-height:inherit;
			color:#797979;
			border:0;
			border-bottom:1px solid #e5e5e5;
		}
		label{
			/*font-weight:bold;
			font-size:16px;*/
			font-family:"Khmer OS System";
		}
		input,button,textarea,td{
			font-family:"Khmer OS System";
		}
		button.en{
			font-family:"Time New Romain";
		}
		.kh{
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
    top: 50%;
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

	/*.select-editable {position:relative; background-color:white; border:solid grey 1px;  width:150px; height:40px;}
	.select-editable select {position:absolute; top:10px; left:0px; font-size:16px; border:none; width:145px; margin:0;}
	.select-editable input {position:absolute; top:0px; left:0px; width:130px;height:35px;padding:1px; font-size:16px; border:none;}
	.select-editable select:focus, .select-editable input:focus {outline:none;}*/
</style>
@endsection
@section('content')
	
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa-file-text-o"></i>Expanse Record</h3>
			<div class="table-responsive" style="overflow:auto;">
				<table class="table table-hover">
					<tr>
						<td><button id="addnewexpanse" class="btn btn-info" style="margin-top:-5px;">កត់ត្រាចំណាយ</button></td>
						<td style="text-align:right;width:130px;">ប្រភេទចំណាយ</td>
						<td style="padding-top:3px;">
							<select name="searchtype" id="searchtype" class="form-control" style="height:40px;width:180px;">
								<option value="">All</option>
								@foreach ($types as $t)
									<option value="{{ $t->type }}">{{ $t->type }}</option>
								@endforeach
							</select>
						</td>
						<td style="text-align:right;width:60px;">គិតពី</td>
						<td style="padding:3px;">
							<div class="input-group" style="width:200px;">
	                        	<input type="text" name="d1" id="d1" class="form-control" style="height:40px;">
		                        <div class="input-group-addon">
		                          <span class="fa fa-calendar"></span>
		                        </div>
	                       </div>
						</td>
						<td style="text-align:right;width:60px;">ដល់</td>
						<td style="padding:3px;">
							<div class="input-group" style="width:200px;">
	                        	<input type="text" name="d2" id="d2" class="form-control" style="height:40px;">
		                        <div class="input-group-addon">
		                          <span class="fa fa-calendar"></span>
		                        </div>
	                       </div>

						</td>
						<td style="padding-top:4px;"><button class="btn btn-primary" id="btnsearch">Search</button></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<!-- Image loader -->
	<div id="fade"></div>
    <div id="modal">
        <img id="loader" src="/logo/ajaxloading4.gif" />

    </div>
	
	<div class="row">
		
		<div class="col-lg-12">
			<div class="panel panel-default" style="margin-top:-15px;" id="divheader">
				<div class="panel-heading" style="height:50px;">
					
					<h3 style="display:inline;float:left;padding-top:10px;font-family:khmer os system;font-size:18px;" id="pl">តារាងចំណាយ</h3>
							
					
					{{-- <div class="input-group input-group-sx" style="padding:5px;">
			          <input type="text" name="psearch" id="psearch" class="typeautosearch form-control" placeholder="Search" style="max-width: 400px;display:inline;float:right;">
			          <div class="input-group-btn" >
			            <button type="button" class="btn btn-default btnsearchproduct" style="display:inline;float:right;width:30px;"><i class="fa fa-search" style="margin-left:-12px;"></i></button>
			          </div>
			        </div> --}}
				</div>
	
				<div class="panel-body">
					@php

						function phpformatnumber($num){
							$dc=0;
							$p=strpos((float)$num,'.');
							if($p>0){
								$fp=substr($num,$p,strlen($num)-$p);
								$dc=strlen((float)$fp)-2;
								
							}
							if($dc>4){
								$dc=4;
							}
							return number_format($num,$dc,'.',',');
						}
					@endphp
					<div class="table-responsive">
						<table  class="table table-hover table-bordered" id="table_product_list">
							<thead style="font-family:khmer os system;">
								<tr​>
									<th style="text-align:center;">N<sup>o</sup></th>
									<th style="text-align:center;">ថ្ងៃទី</th>
									<th style="text-align:center;">អ្នកកត់ត្រា</th>
									<th style="text-align:center;">ប្រភេទចំណាយ</th>
									<th style="text-align:center;">បរិយាយ</th>
									<th style="text-align:center;">ចំនួន</th>
									<th style="text-align:center;">តំលៃ</th>
									<th style="text-align:center;">សរុប</th>
									<th style="text-align:center;">ផ្សេងៗ</th>
									<th style="text-align:center;" class="colaction">Action</th>
								</tr>
							</thead>
							<tbody id="expanse-list">
								@foreach ($expanses as $key => $ep)
									<tr> 
										<td>{{ ++$key }}</td>
										<td>{{ date('d-m-Y',strtotime($ep->dd)) }}</td>
										<td>{{ $ep->user->name }}</td>
										<td>{{ $ep->type }}</td>
										<td>{{ $ep->name }}</td>
										<td style="text-align:center;">{{ $ep->qty . $ep->unit }}</td>
										<td style="text-align:right;">{{ phpformatnumber($ep->price) . $ep->cur }}</td>
										<td style="text-align:right;">{{ phpformatnumber($ep->price * $ep->qty) . $ep->cur }}</td>
										<td>{{ $ep->note }}</td>
										<td>
											<a href="#" class="btn btn-warning btn-sm btn-edit" data-id="{{ $ep->id }}">Edit</a>
											<a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $ep->id }}">Del</a>
										</td>
									</tr>

								@endforeach
								@php
									$khr=0;
									$usd=0;
									$thb=0;
								@endphp
								@foreach ($total as $t)
									@php
										if($t->cur=="R"){
											$khr =phpformatnumber($t->tamount) . $t->cur; 
										}
										if($t->cur=="B"){
											$thb =phpformatnumber($t->tamount) . $t->cur; 
										}
										if($t->cur=="$"){
											$usd =phpformatnumber($t->tamount) . $t->cur; 
										}
									@endphp
									
								@endforeach
								<tr style="background-color:#ddd;">
									<td colspan=5></td>
									<td>សរុបទឹកប្រាក់:</td>
									
									<td style="font-weight:bold;">{{ $usd }}</td>
									<td style="font-weight:bold;">{{ $thb }}</td>
									<td colspan=2 style="font-weight:bold;">{{ $khr }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel-footer" style="height:40px;" id="divfooter">
					<button class="btn btn-primary btn-sm pull-right" style="margin-top:-8px;" id="btnprint">Print</button>
					
				</div>
			</div>

		</div>
	</div>
	@include('expanses.addexpanse_modal')
@endsection

@section('script')
	<script src="{{ asset('js') }}/toastr.min.js"></script>
	<script src="{{ asset('js') }}/jquery.datetimepicker.full.js"></script>
	<script src="{{ asset('js') }}/numberinput.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		

		var today=new Date();
			$('#expdate').datetimepicker({
					timepicker:false,
					//hours12:true,//false for 24 hour
					//step:5,//increase 5 minut
					//allowTimes:['01:00','01:15']
					datepicker:true,
					//value:'13-03-2020',
					value:today,
					//format:'H:i',
					format:'d-m-yy',
					autoclose:true,
					todayBtn:true,
					startDate:today,

				});
			$('#d1').datetimepicker({
					timepicker:false,
					//hours12:true,//false for 24 hour
					//step:5,//increase 5 minut
					//allowTimes:['01:00','01:15']
					datepicker:true,
					//value:'13-03-2020',
					value:today,
					//format:'H:i',
					format:'d-m-yy',
					autoclose:true,
					todayBtn:true,
					startDate:today,

				});
			$('#d2').datetimepicker({
					timepicker:false,
					//hours12:true,//false for 24 hour
					//step:5,//increase 5 minut
					//allowTimes:['01:00','01:15']
					datepicker:true,
					//value:'13-03-2020',
					value:today,
					//format:'H:i',
					format:'d-m-yy',
					autoclose:true,
					todayBtn:true,
					startDate:today,

				});
		$(document).on('click','#btnprint',function(e){
			e.preventDefault();
			var htp=window.location.protocol;
			var htn=window.location.hostname;

			var d1=$('#d1').val();
			var d2=$('#d2').val();
			var type=$('#searchtype').val();
			var redirectWindow = window.open(htp+'//'+htn+'/expanse/report/print?d1='+ d1 +'&d2='+d2+'&type='+type, '_blank');

    		redirectWindow.location;

		})
		$(document).on('click','#addnewexpanse',function(e){
			e.preventDefault();
			var dd=new Date();
			$('#frmexpanse').trigger('reset');
			$('#record_id').val("");
			$('#expdate').val(moment(dd).format('DD-MM-YYYY'));
			$('#btn_save_expanse').text("រក្សាទុក");
			$('#addexpanse_modal').modal('show');
			$('#mtitle').text('Add New Expanse');
		})
    	$(document).on('click','#btn_save_expanse',function(e){
    		var data=$('#frmexpanse').serialize();
    		var id=$('#record_id').val();
    		if(id==""){
    			var url="{{ route('saveexpanse') }}";
    		}else{
    			var url="{{ route('updateexpanse') }}";
    		}
    		
    		$.post(url,data,function(data){
    			console.log(data)
    			if($.isEmptyObject(data.error)){
    				if(id==''){
    					toastr.success('Save Expanse Completed');
    					var dd=new Date();
						$('#frmexpanse').trigger('reset');
						$('#record_id').val("");
						$('#expdate').val(moment(dd).format('DD-MM-YYYY'));
    				}else{
    					toastr.success('Update Expanse Completed');
    					$('#addexpanse_modal').modal('hide')
    				}
				   
				   getexpanse();
				}else{
					alert(data.error)
				}
    		})
    	})
    	$(document).on('click','.btn-edit',function(e){
    		e.preventDefault();
    		var id=$(this).data('id');
    		var url="{{ route('readexpanseid') }}";
    		$.get(url,{id:id},function(data){
    			//console.log(data)
    			$('#addexpanse_modal').modal('show');
    			$('#mtitle').text('Update Expanse');
    			$('#record_id').val(data.id);
    			$('#expdate').val(moment(data.dd).format('DD-MM-YYYY'));
    			$('#type').val(data.type);
    			$('#name').val(data.name);
    			$('#qty').val(data.qty);
    			$('#unit').val(data.unit);
    			$('#price').val(formatNumber(data.price));
    			$('#cur').val(data.cur);
    			$('#amount').val(formatNumber(data.qty * data.price) + data.cur);
    			$('#note').text(data.note);
    			$('#btn_save_expanse').text("កែប្រែ")
    		})
    	})
    	$(document).on('click','.btn-delete',function(e){
    		e.preventDefault();
    		var id=$(this).data('id');
    		var c=confirm("do you want to remove this record?");
    		if(c==true){
    			var url="{{ route('deleteexpanse') }}";
    			$.post(url,{id:id},function(data){
    				getexpanse();
    			})
    		}
    	})
    	function getexpanse() {
    		var d1=$('#d1').val();
    		var d2=$('#d2').val();
    		var type=$('#searchtype').val();
    		var url="{{ route('getexpanse') }}";
    		$.get(url,{d1:d1,d2:d2,type:type},function(data){
    			$('#expanse-list').empty().html(data);
    		})
    	}
    	$(document).on('click','#btnsearch',function(e){
    		e.preventDefault();
    		getexpanse();
    	})
    	$(document).on('blur','#price',function(){
    		$('#price').val(formatNumber($('#price').val()));
    	})
		$(document).on('keyup','#qty,#price',function(e){
			e.preventDefault();
			var amt=0;
			amt=$('#qty').val() * $('#price').val().replace(/,/g,'');
			$('#amount').val(formatNumber(amt) + $('#cur').val());
		})
		$(document).on('change','#cur',function(){
			var amt=0;
			amt=$('#qty').val() * $('#price').val();
			$('#amount').val(formatNumber(amt) + $('#cur').val());
		})
		function formatNumber(num)
            {
                num=parseFloat(num);
                var k=String(num).split('.');
                if(k.length==2){
                    var fnum=k[0].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                    var snum=k[1];
                    return fnum + '.' + snum;
                }else{
                    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                }
            }

	number('#qty',true);
	number('#price',true);
  //   $(document).ajaxStart(function(){
		//   openModal();
		// });
		// $(document).ajaxComplete(function(){
		//   setTimeout(function()
		//   		{
		// 			closeModal();
		// 		},500);
		  	
		// });
    function openModal() {
        document.getElementById('modal').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
	}

	function closeModal() {
	    document.getElementById('modal').style.display = 'none';
	    document.getElementById('fade').style.display = 'none';
	}
})
	</script>
@endsection