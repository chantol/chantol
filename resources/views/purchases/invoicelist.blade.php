@extends('layouts.master')
@section('pagetitle')
	Purchase List
@endsection
@section('css')
	<style>
		
	</style>	

@endsection
@section('content')
	<form action="{{ route('printallinv') }}" method="GET" target="_blank()">
	 <div class="panel panel-default">
      <div class="panel-heading"><b>***invoice Controller</b></div>
      <div class="panel-body">
      		<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-body">
							<div class="col-sm-2" id="startdate">
								<div class="row">
									<label for="startdate">Start Date</label>
									<div class="input-group">
										<input type="text" name="start_date" id="start_date" class="form-control" style="height:40px;">
										<div class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</div>
									</div>
								</div>
							</div>
										
							<div class="col-sm-4" id="enddate">
								
									<div class="col-sm-7">	
										<div class="row">
											<label for="enddate">End Date</label>
											<div class="input-group">
												<input type="text" name="end_date" id="end_date" class="form-control" style="height:40px;">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-2">	
										<button class="btn btn-info btnsearchbydate" style="margin-top:26px;height:38px;">Search by Date</button>
									</div>
									<input type="hidden" id="search_by">
									<input type="hidden" id="search_val">
								
							</div>
										
							<div class="col-sm-3">
								<label for="select">Search Type:</label>
								<select name="typesearch" id="typesearch" class="form-control typesearch" style="height:40px;">
									<option value=""></option>
									<option value="0">Supplier</option>
									<option value="1">Delivery</option>
									<option value="2">Items</option>
									<option value="3">Product Code</option>
									<option value="4">Barcode</option>
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
			    				<h3 class="panel-title"><strong>Invoice List</strong></h3>
			    			</div>
			    			<div class="panel-body" id="table_data">
			    				 @include('purchases.purchaselist')
			    			</div>
			    			<div class="panel-footer">
			    				<input type="submit" class="btn btn-primary" value="Print all">
			    			</div>
			    			<div class="panel-body" id="purchasedetail">
			    				<div class="row">
			    					<div class="col-lg-3">
			    						 <label for="inv">Inv#: <span id="inv1" style="font-weight:bold;">0000</span></label> 
			    					</div>
			    					<div class="col-lg-6">
			    						<label for="sup">Supplier: <span id="sup1" style="font-weight:bold;">..........</span></label>
			    					</div>
			    					<div class="col-lg-3">
			    						<label for="tt">Total: <span id="total1" style="font-weight:bold;">0</span></label>
			    					</div>
			    				</div>
			    				
			    				@include('purchases.p_invoice_detail')
			    			</div>
			    		</div>
			    	</div>
			    </div>
      </div>

    </div>
	</form>			
	@include('purchases.confirm_delete1')
	
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

			//delete invoice
      var _invid;
      $(document).on('click','.btndelinv',function(e){
        e.preventDefault();
        _invid=$(this).data('id');//or =$(this).attr('id');
        $("#modalConfirmDelete1").modal('show');
      });
      $("#btn_delete").click(function(){
         $.ajax({
            type:"POST",
            url:"{{ route('destroypurchase') }}",
            data:{id:_invid},
            // beforeSend:function(){
            //   $("#btn_delete").text('Delete...');
            // },
            
            success:function(data){
              // setTimeout(function(){
              //    $("#modalConfirmDelete").modal('show');
              // },2000);
              $('#btndelinv'+ _invid).parent().parent().remove();
              $("#btn_closeconfirm").click();
              
              //$("#btn_delete").text('Delete');
              // console.log(data);
              //location.reload();
            },
             error: function (xhr, ajaxOptions, thrownError) {
		        //alert(xhr.status);
		        alert(thrownError);
		      }
          });
      });

      $(document).on('click','.showinvdetail',function(e){
				e.preventDefault();
				var invid_str='';
				var invid=$(this).data('id');
				var supname=$(this).data('supname');
				var cur=$(this).data('cur');
				var totalinv=$(this).data('totalinv');

				if(invid<1000){
					var con_str='0000'.concat(invid);
					invid_str=con_str.slice(con_str.length-4,con_str.length);
				}else{
					 invid_str=invid;
				}
				$('#inv1').text(invid_str);
				$('#sup1').text(supname);
				$('#total1').text(formatNumber(totalinv) + ' ' + cur);
				var url="{{ route('showpurchasedetail') }}";
				$.get(url,{id:invid},function(data){
					//console.log(data)
					$('#invoicelistdetail').empty().html(data);
					
				});
			});

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
//-------------------------------------------
			$(document).on('change','#typesearch',function(e){
				e.preventDefault();
				var el='<label for="select">Search Type:</label>';
				$('#fillsearch').empty();
				var sel_val=$(this).val();
				if(sel_val==0){
				 el='<label for="select">Search By Supplier:</label>'+
					'<div class="input-group">'+
					'<select name="supplier" id="supplier" class="form-control">'+
					'<option value=""></option>'+
					'@foreach ($suppliers as $sup)'+
						'<option value="{{ $sup->id }}">{{ $sup->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_supplier">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';


					$('#fillsearch').html(el);
					$('#supplier').select2();
					
				}
				if(sel_val==1){
					 el='<label for="select">Search By Delivery:</label>'+
					'<div class="input-group">'+
					'<select name="delivery" id="delivery" class="form-control">'+
					'<option value=""></option>'+
					'@foreach ($deliveries as $de)'+
						'<option value="{{ $de->id }}">{{ $de->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_delivery">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					
					$('#fillsearch').html(el);
					$('#delivery').select2();
				}

				if(sel_val==2){
					 el='<label for="select">Search By Items:</label>'+
					'<div class="input-group">'+
					'<select name="items" id="items" class="form-control">'+
					'<option value=""></option>'+
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
					 el='<label for="select">Search By Product Code:</label>'+
					'<div class="input-group">'+
					'<input type="text" name="productcode" id="productcode" class="form-control" style="height:40px;">'+
					'<div class="input-group-addon btn btn-default" id="search_productcode">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					
					$('#fillsearch').html(el);
					
				}
				if(sel_val==4){
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
				var end_date=$('#end_date').val();
				$('#search_by').val('barcode');
				$('#search_val').val(barcode);
				var url="{{ route('invoicelistsearch') }}";
				$.get(url,{barcode:barcode,start_date:start_date,end_date:end_date},function(data){
					console.log(data)
					$("#table_data").empty().html(data);
				})
			})
			$(document).on('click','#search_productcode',function(e){
				var productcode=$('#productcode').val();
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				$('#search_by').val('productcode');
				$('#search_val').val(productcode);
				var url="{{ route('invoicelistsearch') }}";
				$.get(url,{productcode:productcode,start_date:start_date,end_date:end_date},function(data){
					
					$("#table_data").empty().html(data);
					 //console.log(data)
				})
			})
			$(document).on('click','#search_item',function(e){
				var productcode=$('#items').val();
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				$('#search_by').val('productcode');
				$('#search_val').val(productcode);
				var url="{{ route('invoicelistsearch') }}";
				$.get(url,{productcode:productcode,start_date:start_date,end_date:end_date},function(data){
					
					$("#table_data").empty().html(data);
					 //console.log(data)
				})
			})

			$(document).on('click','#search_delivery',function(e){
				var delivery=$('#delivery').val();
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				$('#search_by').val('delivery');
				$('#search_val').val(delivery);
				var url="{{ route('invoicelistsearch') }}";
				$.get(url,{delivery:delivery,start_date:start_date,end_date:end_date},function(data){
					
					 $("#table_data").empty().html(data);
					 //console.log(data)
				})
			})

			$(document).on('click','#search_supplier',function(e){
				var supplier=$('#supplier').val();
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				$('#search_by').val('supplier');
				$('#search_val').val(supplier);
				var url="{{ route('invoicelistsearch') }}";
				$.get(url,{supplier:supplier,start_date:start_date,end_date:end_date},function(data){
					
					$("#table_data").empty().html(data);
					 //console.log(data)
				})
			})

			$(document).on('click','.btnsearchbydate',function(e){
				e.preventDefault();
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				$('#search_by').val('date');
				$('#search_val').val('date');
				var url="{{ route('invoicelistsearch') }}";

				$.get(url,{start_date:start_date,end_date:end_date},function(data){
					
					 // $('#invoice_List').empty();
					 // $('#invoice_List').html(data);
					$("#table_data").empty().html(data);
					})

					
					
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

		});
	</script>
@endsection