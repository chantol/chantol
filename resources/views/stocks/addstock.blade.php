@extends('layouts.master')
@section('pagetitle')
	Stock In
@endsection
@section('css')
<style type="text/css">
	
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
</style>	

@endsection
@section('content')
	<span id="success_message"></span>
	 <div class="panel panel-default">
      <div class="panel-heading"><b>*** Stock In ***</b></div>
      <form method="POST" id="frmpurchasesubmit" action="#">
	   {{-- {{ csrf_field() }} --}}
      <div class="panel-body">
      		<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-body">
						<input type="hidden" name="userid" id="userid" value="{{ Auth::id() }}">
						<input type="hidden" id="searchby" value="date">
						<div class="col-lg-2" style="margin-left:10px;">
							<div class="row">
								<label for="enddate">Select Date</label>
								<select name="choosedate" id="choosedate" class="form-control" style="height:40px;background:yellow;">
									<option value="">Select Date</option>
									@foreach ($buydate as $sdate)
										<option value="{{ date('d-m-Y',strtotime($sdate->submitdate)) }}">{{ date('d-m-Y',strtotime($sdate->submitdate)) }}</option>
									@endforeach	
								</select>
							</div>
						</div>
						
						<div class="col-lg-2" id="startdate" style="margin-left:10px;">
							<div class="row">
								<label for="startdate">Date</label>
								<div class="input-group">
									<input type="text" name="start_date" id="start_date" class="form-control" style="height:40px;width:100%;">
									<div class="input-group-addon">
										<span class="fa fa-calendar" style="text-align:center;"></span>
									</div>
								</div>
							</div>
						</div>
						
								
							<div class="col-lg-2">
								<button class="btn btn-info btnsearchbydate" style="margin-top:25px;height:40px;width:100%">Search by Date</button>
							</div>
										
										
							<div class="col-sm-2">
								<label for="select">Search Type:</label>
								<select name="typesearch" id="typesearch" class="form-control typesearch" style="height:40px;">
									<option value=""></option>
									<option value="0">Category</option>
									<option value="1">Brand</option>
									<option value="2">Items</option>
									<option value="3">Barcode</option>
								</select>
							</div>
							<div class="col-sm-3" id="fillsearch">
								
								
							</div>
						</div>
					</div>
				</div>
	
				<div class="row">
			    	<div class="col-md-12">
			    		<div class="panel panel-default">
			    			<div class="panel-heading">
			    				<h3 class="panel-title" style="display:inline;"><strong>Total Items Bought</strong></h3>
			    				<button class="btn btn-primary btn-sm pull-right" style="margin-top:5px; margin-right:5px;font-weight:bold;" id="btnsubmit">Submit all</button>
			    			</div>

			    			<!-- Image loader -->
							<div id="fade"></div>
					        <div id="modal">
					            <img id="loader" src="/logo/ajaxloading4.gif" />

					        </div>

							
			    			<div class="panel-body" id="table_data">
			    				 @include('stocks.itembuylist')
			    			</div>
			    			<div class="panel-footer">	
			    				<table class="table table-hover table-bordered">
				    				<tr>	
										@foreach ($exchanges as $exch)
											<td>{{ $exch->exchange_cur }} &nbsp;&nbsp;&nbsp; <span style="color:red;"> {{ (float)$exch->buy }}	</span>  &nbsp;&nbsp;&nbsp; <span style="color:blue;"> {{ (float)$exch->sale }}	</span> </td>
										@endforeach
				    				</tr>	
			    				</table>
								
			    			</div>
			    		</div>
			    	</div>
	    	</div>
      </div>
	</form>
    </div>
				
	{{-- @include('sales.confirm_delstock') --}}
	@include('stocks.confirm_submitbyitem')
@endsection
@section('script')
	<script type="text/javascript">
			
		$(document).ready(function(){

			var today=new Date();
			$('#start_date').datetimepicker({
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
				$('#end_date').datetimepicker({
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

			
//-------------------------------------------
			$(document).on('change','#typesearch',function(e){
				e.preventDefault();
				var el='<label for="select">Search Type:</label>';
				$('#fillsearch').empty();
				var sel_val=$(this).val();
				if(sel_val==0){
				 el='<label for="select">Search By Category:</label>'+
					'<div class="input-group">'+
					'<select name="category" id="category" class="form-control">'+
					'<option value="">all Category</option>'+
					'@foreach ($categories as $cat)'+
						'<option value="{{ $cat->id }}">{{ $cat->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_category">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';


					$('#fillsearch').html(el);
					$('#category').select2();
					
				}
				if(sel_val==1){
					 el='<label for="select">Search By Brand:</label>'+
					'<div class="input-group">'+
					'<select name="brand" id="brand" class="form-control">'+
					'<option value="">all Brand</option>'+
					'@foreach ($brands as $de)'+
						'<option value="{{ $de->id }}">{{ $de->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_brand">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					
					$('#fillsearch').html(el);
					$('#brand').select2();
				}

				if(sel_val==2){
					 el='<label for="select">Search By Items:</label>'+
					'<div class="input-group">'+
					'<select name="items" id="items" class="form-control">'+
					'<option value="">all Items</option>'+
					'@foreach ($items as $itm)'+
						'<option value="{{ $itm->id }}">{{ $itm->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_item">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					
					$('#fillsearch').html(el);
					$('#items').select2();
				}
				
				if(sel_val==3){
					 el='<label for="select">Search By BarCode:</label>'+
					'<div class="input-group">'+
					'<input type="text" name="barcode" id="barcode" class="form-control" style="height:40px;">'+
					'<div class="input-group-addon btn btn-default" id="search_barcode">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					
					$('#fillsearch').html(el);
					
				}
			})
			$(document).on('keydown','#barcode',function(e){
				 if (e.keyCode == 13) {
			        $('#search_barcode').click();
			        e.preventDefault();
			    }
			})
			$(document).on('keydown','#productcode',function(e){
				 if (e.keyCode == 13) {
			        $('#search_productcode').click();
			        e.preventDefault();
			    }
			})

			$(document).on('click','#search_barcode',function(e){
				var barcode=$('#barcode').val();
				var start_date=$('#start_date').val();
				$('#searchby').val('barcode');
				
				var url="{{ route('summaryitembuy') }}";
				$.get(url,{barcode:barcode,start_date:start_date},function(data){
					$("#table_data").empty().html(data);
					$('#btnsubmit').attr('disabled',false);
					
				})
			})
			
			$(document).on('click','#search_item',function(e){
				var productcode=$('#items').val();
				var start_date=$('#start_date').val();
				$('#searchby').val('item');
				var url="{{ route('summaryitembuy') }}";
				$.get(url,{productcode:productcode,start_date:start_date},function(data){
					$("#table_data").empty().html(data);
					$('#btnsubmit').attr('disabled',false);
				})
			})

			$(document).on('click','#search_brand',function(e){
				var brand=$('#brand').val();
				var start_date=$('#start_date').val();
				$('#searchby').val('brand');
				var url="{{ route('summaryitembuy') }}";
				$.get(url,{brand:brand,start_date:start_date},function(data){
					$("#table_data").empty().html(data);
					$('#btnsubmit').attr('disabled',false);
				})
			})

			$(document).on('click','#search_category',function(e){
				var category=$('#category').val();
				var start_date=$('#start_date').val();
				$('#searchby').val('category');
				var url="{{ route('summaryitembuy') }}";
				$.get(url,{category:category,start_date:start_date},function(data){
					$("#table_data").empty().html(data);
					$('#btnsubmit').attr('disabled',false);
				})
			})

			$(document).on('click','.btnsearchbydate',function(e){
				e.preventDefault();
				var start_date=$('#start_date').val();
				$('#searchby').val('date');
				var url="{{ route('summaryitembuy') }}";
				$.get(url,{start_date:start_date},function(data){
					$("#table_data").empty().html(data);
					$('#btnsubmit').attr('disabled',false);
					
				})	
			})

			$(document).on('change','#start_date',function(e){
				e.preventDefault();
				$('#btnsubmit').attr('disabled',true);
			})

			//ajax pagination
			function fetch_data(page,start_date,end_date,search_by,search_val) {
				$.ajax({
						
						url:"/purchase/pagination/fetch_data?page="+ page +"&start_date="+ start_date +"&end_date="+ end_date +"&search_by="+ search_by +"&search_val="+search_val,
						success:function(data)
						{
							$('#table_data').empty().html(data);
						}
					});
			}
			$(document).on('click','.pagination a',function(event){
				event.preventDefault();
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				var page=$(this).attr('href').split('page=')[1];
				var search_by=$('#search_by').val();
				var search_val=$('#search_val').val();
				fetch_data(page,start_date,end_date,search_by,search_val);
			});
			$(document).on('change','#choosedate',function(e){
				var seldate=$(this).val();
				$('#start_date').val(seldate);
				$('#btnsubmit').attr('disabled','disabled');
			})
			var currentRow='';
			$(document).on('click','.btnsubmitbyitem',function(e){

				currentRow=$(this).closest("tr"); 
				var dd=currentRow.find("td:eq(1) input").val();
         		var pid=currentRow.find("td:eq(2) input").val(); 
         		var qty=currentRow.find("td:eq(8) input").val(); 
         		var unit=currentRow.find("td:eq(9) input").val(); 
         		var foc=currentRow.find("td:eq(10) input").val(); 
         		var amount=currentRow.find("td:eq(12) input").val(); 
         		var cur=currentRow.find("td:eq(13) input").val(); 
         		var amountusd=currentRow.find("td:eq(14) input").val(); 
         		var pcur=currentRow.find("td:eq(15) input").val(); 
         		var submit=currentRow.find("td:eq(16) input").val(); 
         		var userid=$('#userid').val();
					var url="{{ route('submitbyitembuy') }}";
					$.post(url,{userid:userid,dd:dd,pid:pid,qty:qty,foc:foc,unit:unit,amount:amount,cur:cur,amountusd:amountusd,submit:submit,pcur:pcur},function(data){
						console.log(data)
	     				if(data.savesuccess){
	     					//alert('save success')
	     					document.getElementById('btnsubmitbyitem'+pid).innerHTML="Cancel"
	     					currentRow.find("td:eq(16) input").val(1);
	     				}
	     				if(data.delsuccess){
	     					//alert('Remove Completed')
	     					document.getElementById('btnsubmitbyitem'+pid).innerHTML="Submit"
	     					currentRow.find("td:eq(16) input").val(0);
	     				}
						
					});

			})
			$(document).on('click','#btn_yes1',function(e){
				e.preventDefault();
				var dd=currentRow.find("td:eq(1)").text();
         		var pid=currentRow.find("td:eq(2) input").val(); 
         		var qty=currentRow.find("td:eq(7) input").val(); 
         		var unit=currentRow.find("td:eq(8) input").val(); 
         		var foc=currentRow.find("td:eq(9) input").val(); 
         		var amount=currentRow.find("td:eq(11) input").val(); 
         		var cur=currentRow.find("td:eq(12) input").val(); 
         		var userid=$('#userid').val();
				var url="{{ route('delandsubmitbyitembuy') }}";

				$.post(url,{userid:userid,dd:dd,pid:pid,qty:qty,unit:unit,amount:amount,cur:cur},function(data){
					if($.isEmptyObject(data.error)){
                        alert(data.success);
                        $('#btn_no1').click();
                    }else{
                        alert(data.error);
                    }
					
				});
				
			})

			function openModal() {
			        document.getElementById('modal').style.display = 'block';
			        document.getElementById('fade').style.display = 'block';
			}

			function closeModal() {
			    document.getElementById('modal').style.display = 'none';
			    document.getElementById('fade').style.display = 'none';
			}

			$(document).on('click','#btnsubmit',function(e){
				e.preventDefault();
				var c=confirm('Do you want to submit all item to stock now?');
				if(c==true){
					var tbrow = document.getElementById("summary_buylist").rows.length;
				if(tbrow>0){
					$.ajax({
						method:"POST",
						url:"{{ route('submititembuy') }}",
						data:$('#frmpurchasesubmit').serialize(),
						
						beforeSend:function(){
						
						$('#btnsubmitall').attr('disabled','disabled');
						$('#btnsubmitall').text('wait...');
						},
						success:function(data){
							$('#btnsubmitall').attr('disabled',false);
							$('#btnsubmitall').text('Submit all');
							var refresh=$('#searchby').val();
							if(refresh=='date'){
								$('.btnsearchbydate').click();
							}else if(refresh=='category'){
								$('#search_category').click();
							}else if(refresh=='brand'){
								$('#search_brand').click();
							}else if(refresh=='item'){
								$('#search_item').click();
							}else if(refresh=='barcode'){
								$('#search_barcode').click();
							}
							
						}
					});

				}else{
					alert('no item submit')
				}
			}
		})

			function progress_bar_process(percentage,timer) {
				$('.progress-bar').css('width',percentage +'%');
				if(percentage>100){
					clearInterval(timer);
					//$('#frmsalesubmit')[0].reset();
					$('#process').css('display','none');
					$('.progress-bar').css('width','0%');
					$('#btnsubmitall').attr('disabled',false);
					$('#btnsubmitall').text('submit all');
					$('#bl').removeClass('fa fa-circle-o-notch fa-spin');
					$('#success_message').html("<div class='alert alert-success' style='color:red;'>Data has been submit</div>");
					setTimeout(function(){
						$('#success_message').html('');
						location.reload();
					},3000);
				}
			}

		$(document).ajaxStart(function(){
		  openModal();
		});
		$(document).ajaxComplete(function(){
		  setTimeout(function()
		  		{
					closeModal();
				},1000);
		});

	});
</script>
@endsection