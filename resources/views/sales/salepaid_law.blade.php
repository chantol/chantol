@extends('layouts.master')
@section('pagetitle')
	Sale Payment(Law)
@endsection
@section('css')
	<style>
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
</style>	

@endsection
@section('content')

	 <div class="panel panel-default">
      <div class="panel-heading" style="background:blue;color:white;"><b>*** CO Payment</b></div>
      <div class="panel-body">
      		<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-body">
							<div class="col-sm-2" id="startdate">
											<label for="startdate">Start Date</label>
											<div class="input-group">
												<input type="text" name="start_date" id="start_date" class="form-control" style="height:40px;">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
											</div>
										</div>
										
										<div class="col-sm-4" id="enddate">
											<div class="row">
											<div class="col-sm-6">	
												<label for="enddate">End Date</label>
												<div class="input-group">
													<input type="text" name="end_date" id="end_date" class="form-control" style="height:40px;">
													<div class="input-group-addon">
														<span class="fa fa-calendar"></span>
													</div>
												</div>
											</div>

											<div class="col-sm-2">	
												
												<button class="btn btn-info btnsearchbydate" style="margin-top:27px;size:40px;">Search by Date</button>
											</div>
											</div>
											<input type="hidden" id="search_by" value="date">
											
										</div>
										
							<div class="col-sm-3">
								<label for="select">Search Type:</label>
								<select name="typesearch" id="typesearch" class="form-control typesearch" style="font-family:khmer os system;height:40px;">
									<option value=""></option>
									<option value="0">អតិថិជន</option>
									<option value="1">ក្រុមហ៊ុនដឹកជញ្ជូន</option>
									<option value="2">អ្នករត់ច្បាប់</option>
									<option value="3">លេខវិក័យប័ត្រ</option>
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
			    				<h3 class="panel-title" style="display:inline;"><strong>CO Invoice List</strong></h3>
			    				<div class="custom-control custom-radio" style="float:right;display:inline;margin:5px;">
								  <input type="radio" class="custom-control-input rad" id="radboth" name="grouprad" value="2">
								  <label class="custom-control-label" for="radboth" id="forradboth" ><strong>Both</strong></label>
								</div>
								
								<!-- Group of default radios - option 2 -->
								<div class="custom-control custom-radio" style="float:right;display:inline;margin:5px;">
								  <input type="radio" class="custom-control-input rad" id="radpaid" name="grouprad" value="1">
								  <label class="custom-control-label" for="radpaid" id="forradpaid" style="color:blue;"><strong>Paid</strong></label>
								</div>

								<!-- Group of default radios - option 3 -->
								<div class="custom-control custom-radio" style="float:right;display:inline;margin:5px;">
								  <input type="radio" class="custom-control-input rad" id="radnotyetpaid" name="grouprad" checked value="0">
								  <label class="custom-control-label" for="radnotyetpaid" id="forradnotyetpaid" style="color:red;"><strong>Not yet paid</strong></label>
								</div>
			    			</div>
			    			<!-- Image loader -->
									<div id="fade"></div>
							        <div id="modal">
							            <img id="loader" src="/logo/ajaxloading4.gif" />

							        </div>
			    			<div class="panel-body" id="table_data">
			    				@include('sales.s_invoice_law')
			    			</div>
			    			<div class="panel-footer">
			    				<div class="row">
				    				<div class="col-lg-2">
				    					<div class="row">
				    					<button class="btn btn-info" id="btnpaidnow" style="width:100px;margin-left:10px;">Paid</button>
				    					</div>
				    				</div>
				    				<div class="col-lg-2">
				    					<div class="row">
				    					<h3 style="display:inline;">
					    				<input type="checkbox" class="custom-control-input" style="height:20px;width:20px;" id="ckcheck">
					    				Checked all
					    				</h3>
					    				</div>
				    				</div>
				    				<div class="col-lg-8">
				    					<div class="row">
				    					<span class="label label-info" id="tckusd" style="float:right;font-size:22px;margin-right:10px;">0$</span>
					    				<span class="label label-info" id="tckbat" style="float:right;font-size:22px;margin-right:5px;margin-left:5px;">0B</span>
					    				<span class="label label-info" id="tckkhr" style="float:right;font-size:22px;">0R</span>
				    					</div>
				    				</div>
			    				</div>
			    			</div>
			    			<div class="panel-body" id="saledetail">
			    				<div class="row">
			    					<div class="col-lg-3">
			    						 <label for="inv">Inv#: <span id="inv1" style="font-weight:bold;">0000</span></label> 
			    					</div>
			    					<div class="col-lg-6">
			    						<label for="sup">Customer: <span id="sup1" style="font-weight:bold;">..........</span></label>
			    					</div>
			    					<div class="col-lg-3">
			    						<label for="tt">Total: <span id="total1" style="font-weight:bold;">0</span></label>
			    					</div>
			    				</div>
			    				@include('sales.s_invoice_detail')
			    			</div>
			    		</div>
			    	</div>
	    	</div>

      </div>

    </div>
				
	@include('sales.totalpaidlist_modal')
	@include('closelists.paidlist_modal')
@endsection
@section('script')
	<script src="{{ asset('js') }}/numbertoword.js"></script>
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
				$('#paydate').datetimepicker({
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
			//show invoice detail
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
				var url="{{ route('showsaledetail') }}";
				$.get(url,{id:invid},function(data){
					//console.log(data)
					$('#invoicelistdetail').empty().html(data);
					
				});
			});
			$(document).on('click','.showpaiddetail',function(e){
				e.preventDefault();
				var subname=$(this).data('supname');
				var invid=$(this).data('id');
				var invtotal=$(this).data('totalinv');
				var cur=$(this).data('cur');
				var url="{{ route('showsalepaiddetail') }}";
				$.get(url,{id:invid,law:'law'},function(data){
					//console.log(data)
					
					$('#salepaidmodal').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                		}); 

						$('#ppdt').empty().html(data);
						$('#totalinv').val(formatNumber(invtotal) + cur);
						$('#invnum').val(invid.toString().padStart(4,'0'));
						$('#supname').val(subname);
						$('#tpaid').val(formatNumber($('#totalpaid').val()) + cur);
						var bal=parseFloat(invtotal)-parseFloat($('#totalpaid').val());
						$('#bal').val(formatNumber(bal) + cur);
					})
    			});

			$(document).on('click','.btndelpaid',function(e){
				e.preventDefault();
				var paid_id=$(this).data('id');
				var purinv=$('#invnum').val();
				var cur=$(this).data('cur');
				var totalinv=$('#totalinv').val().replace(cur,'').replace(',','');
				c=confirm('Do you want to remove this paid?');
				if(c==true){
					var url="{{ route('delsalepaid') }}";
					$.post(url,{id:paid_id,purinv:purinv,totalinv:totalinv,paymethod:'law'},function(data){
						console.log(data)
						//alert(data[0].tpaid)
						$('#ppdt').empty().html(data);
						$('#tpaid').val(formatNumber($('#totalpaid').val()) + cur);
						var bal=parseFloat(totalinv)-parseFloat($('#totalpaid').val());
						$('#bal').val(formatNumber(bal) + cur);
						var sb=$('#search_by').val();
						if(sb=='date'){
							$('.btnsearchbydate').click();
						}else if(sb=='sup'){
							$('#search_supplier').click();
						}else if(sb=='dev'){
							$('#search_delivery').click();
						}else if(sb=='inv'){
							$('#search_invoice').click();
						}else if(sb=='law'){
							$('#search_lawfee').click();
						}
					})
				}
			})
			
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
//-------------------------------------------
			$(document).on('change','#typesearch',function(e){
				e.preventDefault();
				var el='<label for="select">Search Type:</label>';
				$('#fillsearch').empty();
				var sel_val=$(this).val();
				if(sel_val==0){
				 el='<label for="select">Search By Customer:</label>'+
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
					el='<label for="select">Search By Transportation:</label>'+
					'<div class="input-group">'+
					'<select name="delivery" id="delivery" class="form-control">'+
					'<option value=""></option>'+
					'@foreach ($deliveries as $dev)'+
						'<option value="{{ $dev->id }}">{{ $dev->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_delivery">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';

					$('#fillsearch').html(el);
					$('#delivery').select2();
				}
				if(sel_val==2){
					el='<label for="select">Search By Tax Rule:</label>'+
					'<div class="input-group">'+
					'<select name="lawfee" id="lawfee" class="form-control">'+
					'<option value=""></option>'+
					'@foreach ($lawfees as $lf)'+
						'<option value="{{ $lf->id }}">{{ $lf->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_lawfee">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';

					$('#fillsearch').html(el);
					$('#lawfee').select2();
				}
				if(sel_val==3){
					 el='<label for="select">Search By Invoice Number:</label>'+
					'<div class="input-group">'+
					'<input type="text" name="invoice" id="invoice" class="form-control" style="height:40px;">'+
					'<div class="input-group-addon btn btn-default" id="search_invoice">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					
					$('#fillsearch').html(el);
				}
				
			})
			
			$(document).on('click','#search_supplier',function(e){
				var supplier=$('#supplier').val();
				$('#search_by').val('sup');
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				var radsel=$('input[name="grouprad"]:checked').val();
				document.getElementById("ckcheck").checked=false;
				var op='';
				
				if(radsel=='0'){
					op='>';
				}else if(radsel==1){
					op='=';
				}else{
					op='>=';
				}
				var url="{{ route('invoicelistsearchpaidforlaw') }}";
				$.get(url,{start_date:start_date,end_date:end_date,operater:op,supplier:supplier},function(data){
					//console.log(data)
					$("#table_data").empty().html(data);
					})
				
			})
			$(document).on('click','#search_delivery',function(e){
				var delivery=$('#delivery').val();
				$('#search_by').val('dev');
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				var radsel=$('input[name="grouprad"]:checked').val();
				document.getElementById("ckcheck").checked=false;
				var op='';
				
				if(radsel=='0'){
					op='>';
				}else if(radsel==1){
					op='=';
				}else{
					op='>=';
				}
				var url="{{ route('invoicelistsearchpaidforlaw') }}";
				$.get(url,{start_date:start_date,end_date:end_date,operater:op,delivery:delivery},function(data){
					//console.log(data)
					$("#table_data").empty().html(data);
					})
				
			})
			$(document).on('click','#search_lawfee',function(e){
				var law=$('#lawfee').val();
				$('#search_by').val('law');
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				var radsel=$('input[name="grouprad"]:checked').val();
				document.getElementById("ckcheck").checked=false;
				var op='';
				
				if(radsel=='0'){
					op='>';
				}else if(radsel==1){
					op='=';
				}else{
					op='>=';
				}
				var url="{{ route('invoicelistsearchpaidforlaw') }}";
				$.get(url,{start_date:start_date,end_date:end_date,operater:op,law:law},function(data){
					//console.log(data)
					$("#table_data").empty().html(data);
					})
				
			})
			$(document).on('click','#search_invoice',function(e){
				var invoice=$('#invoice').val();
				$('#search_by').val('inv');
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				var radsel=$('input[name="grouprad"]:checked').val();
				document.getElementById("ckcheck").checked=false;
				var op='';
				
				if(radsel=='0'){
					op='>';
				}else if(radsel==1){
					op='=';
				}else{
					op='>=';
				}
				var url="{{ route('invoicelistsearchpaidforlaw') }}";
				$.get(url,{start_date:start_date,end_date:end_date,operater:op,invoice:invoice},function(data){
					//console.log(data)
					$("#table_data").empty().html(data);
					})
				
			})
			$(document).on('keydown','#invoice',function(e){
				 if (e.keyCode == 13) {
			        $('#search_invoice').click();
			        e.preventDefault();
			    }
			})
			$(document).on('click','.btnsearchbydate',function(e){
				e.preventDefault();
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				var radsel=$('input[name="grouprad"]:checked').val();
				document.getElementById("ckcheck").checked=false;
				var op='';
				$('#search_by').val('date');
				if(radsel=='0'){
					op='>';
				}else if(radsel==1){
					op='=';
				}else{
					op='>=';
				}
				var url="{{ route('invoicelistsearchpaidforlaw') }}";
				$.get(url,{start_date:start_date,end_date:end_date,operater:op},function(data){
					//console.log(data)
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
			
			
			$(document).on('click','#btnpaidnow',function() {
            	var total=0;
            	var deposit=0;
            	var balance=0;
            	var cur='';
            	var invnums='';
            	var i=0;
            	var customer0='';
            	var cur0='';
            	$('#modal_saletotalpaidlist').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true,
                        
	                }); 
            	$('#frmsavesalepaidlist').trigger('reset');
            	$('#paydate').val(moment().format('DD-MM-YYYY'));
            	$('#spl').empty();
            	$('#btnsavepaid').attr('disabled',true);
            	$('#paymethod').val('law');
	            $("#invoicelist input[type=checkbox]:checked").each(function (){
	                var row = $(this).closest("tr");
	                if(i==0){
	                	 customer0=row.find("td:eq(10)").text();
	                	 cur0=row.find("td:eq(15)").text();
	                }
	                var customer1=row.find("td:eq(10)").text();
	                cur=row.find("td:eq(15)").text();
	                if(customer0 != customer1 || cur0 != cur){
	                	alert('paid invoice not the same name please check again')
	                	$('#btncancel').click();
	                	return false;
	                }

	               	total=row.find("td:eq(11)").text().replace(/,/g,'').replace('B','').replace('R','').replace('$','');
	                invnums =row.find("td:eq(2)").text(); 
	               
	                i++;
	                var url="{{ route('totalsaleinvoicepaid') }}";
	                var paytype='law';
	                $.ajax({
	                 	 url:"{{ route('totalsaleinvoicepaid') }}",
		          		 method:"GET",
		          		 //async : false,
				         data:{paytype:paytype,buyinv:invnums},
				         dataType:'json',
				         success:function(data){
				         	deposit=data[0].totalpaid;
		                	if(deposit==null)
		                	{
		                		deposit=0;
		                	}
		                
	                  $('#customerpaid').val(customer0);
	                  $('#getcur').text(cur);
	                  $('#getpaidcur').val(cur);
	                  balance=parseFloat(total)-parseFloat(deposit);
	                  var psp=Math.floor((deposit/total)*100);
			           
	                  var tr='<tr>'+
	                  		'<td style="padding:7px;width:60px;">'+ i +'</td>'+
	                  		'<td style="padding:0px;width:120px;">'+
	                  		'<input type="text" style="border-style:none;" class="form-control paid_inv" name="paid_inv[]" readonly value="'+ invnums +'">'+
	                  		'</td>'+
	                  		'<td style="padding:0px;width:120px;">'+
	                  		'<input type="text" style="border-style:none;" class="form-control invtotal" name="paid_invtotal[]" readonly value="'+ formatNumber(total) + " " + cur +'">'+
	                  		'</td>'+
	                  		'<td style="padding:0px;width:120px;">'+
	                  		'<input type="text" style="border-style:none;" class="form-control deposited" name="deposited[]" readonly value="'+ formatNumber(deposit)  + " " + cur +'">'+
	                  		'</td>'+
	                  		'<td style="padding:0px;width:120px;">'+
	                  		'<input type="text" style="border-style:none;" class="form-control balanced" name="balanced[]" readonly value="'+ formatNumber(balance) + " " + cur +'">'+
	                  		'</td>'+
	                  		
	                  		'<td style="padding:0px;width:120px;">'+
	                  		'<input type="text" style="border-style:none;" class="form-control paid_deposit" name="paid_deposit[]" value="0">'+
	                  		'</td>'+
	                  		'<td style="padding:0px;width:120px;">'+
	                  		'<input type="text" style="border-style:none;" class="form-control balance" name="balance[]" readonly value="'+ formatNumber(balance) + " "+ cur +'">'+
	                  		'</td>'+
	                  		'<td style="padding:0px;width:60px;">'+
	                  		'<input type="text" style="border-style:none;" class="form-control pps" name="pps[]" readonly value="'+ psp +'%">'+
	                  		'</td>'+
	                  		
	                  		'<td style="padding:2px;width:40px;text-align:center;">'+
	                  		'<a href="#" class="btn btn-danger btn-sm minus_inv"><i class="fa fa-minus"></i></a>'+
	                  		'</td>'+
	                  		'</tr>'
	                  	$('#spl').append(tr);
				         }
	                 });
	                 
	            });
	            if(i>0){
	            	$('#btnsavepaid').attr('disabled',false);
	            }
        })

		$(document).on('click','#btnsavepaid',function(e){
			e.preventDefault();
			var dep= $('#getpaid').val().replace(/,/g,'');
			if(isNaN(dep)){
				alert('paid not alow.')
				return false
			}
			var tbrow = document.getElementById("spl").rows.length;
			if(tbrow==0){
				alert('no paid save')
				return false;
			}
			c=confirm('Do you want to save this payment?');
			if(c==true){
				var url="{{ route('savesalepayment') }}";
				var data=$('#frmsavesalepaidlist').serialize();
				$.post(url,data,function(data){
						console.log(data)
						$('#btncancel').click();
						var sb=$('#search_by').val();
						
						if(sb=='date'){
							$('.btnsearchbydate').click();
						}else if(sb=='sup'){
							$('#search_supplier').click();
						}else if(sb=='dev'){
							$('#search_delivery').click();
						}else if(sb=='inv'){
							$('#search_invoice').click();
						}else if(sb=='law'){
							$('#search_lawfee').click();
						}
				});

			}
		})


		$(document).on('click','.minus_inv',function(e){
			e.preventDefault();
			$(this).parent().parent().remove();
			totalpaid();
		})
		$(document).on('input','.paid_deposit',function(e){
		 var row = $(this).closest("tr");
	     var total=row.find("td:eq(2) input").val().replace(/,/g,'').replace('B','').replace('R','').replace('$','');
	     var olddeposit=row.find("td:eq(3) input").val().replace(/,/g,'').replace('B','').replace('R','').replace('$','');
	     var newdeposit=$(this).val().replace(',','');
	     var alldeposit=parseFloat(olddeposit)+ parseFloat(newdeposit);
	    
	      //read amount
		 var curstr='';
	 	 if($('#getpaidcur').val()=='R'){
	 		curstr='រៀល';
	 	 }else if($('#getpaidcur').val()=='$'){
	 		curstr='ដុល្លា';
	 	 }else{
			curstr='បាត'
		 }
		 var rc=$(this).val();
		 rc=rc.replace(/,/g,'')
		 if(rc!=''){
		 	$('#readnum').text(ReadAmount(rc,' '+ curstr));
		 }
	     
	     
	     var balance=parseFloat(total)-parseFloat(alldeposit);
	     var psp=Math.floor((parseFloat(alldeposit)/parseFloat(total))*100);
	     row.find("td:eq(6) input").val(formatNumber(balance));
	     row.find("td:eq(7) input").val(psp);
	     totalpaid();
	                
	})
	$(document).on('blur','.paid_deposit',function(e){
		$(this).val(formatNumber($(this).val().replace(/,/g,'')));
	})
	function totalpaid() {
		var d=0;
		$('.paid_deposit').each(function(i,e){
			d +=parseFloat($(this).val().replace(/,/g,''));
		});
		$('#getpaid').val(formatNumber(d));
	}
//format number javascript
	function formatNumber(num)
	{
	  	 num=parseFloat(num);
		 return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
	}

	function inputNumber(input,nosign)
	{
		$('tbody').delegate(input,'keydown',function(){
			var tr=$(this).parent().parent();
			number(tr.find(input),nosign);
		});
	}
	
	
	$(document).ajaxStart(function(){
	  openModal();
	});
	$(document).ajaxComplete(function(){
	  setTimeout(function()
	  		{
				closeModal();
			},500);
	});
	function openModal() {
        document.getElementById('modal').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
	}

	function closeModal() {
	    document.getElementById('modal').style.display = 'none';
	    document.getElementById('fade').style.display = 'none';
	}
	$(document).on('change','.customCheck',function(e){
		totalcheck();
	})
	function totalcheck() {
		 var tkhr=0;
	     var tbat=0;
	     var tusd=0;
	     var cur='';
		 $("#invoicelist input[type=checkbox]:checked").each(function (){
	         var row = $(this).closest("tr");
	         cur=row.find('td:eq(18)').text();
	         var amt=row.find('td:eq(17)').text().replace(/,/g,'');
	         if(cur=='R'){
	         	tkhr +=parseFloat(amt);
	         }else if(cur=='B'){
	         	tbat +=parseFloat(amt);
	         }else if(cur=='$'){
	         	tusd +=parseFloat(amt);
	         }
	      });
	    $('#tckusd').text(formatNumber(tusd)+ " $");
	 	$('#tckbat').text(formatNumber(tbat)+ " B");
	    $('#tckkhr').text(formatNumber(tkhr)+ " R");
	           
	}
	$(document).on('change','.rad',function(e){
		var sb=$('#search_by').val();
		
		if(sb=='date'){
			$('.btnsearchbydate').click();
		}else if(sb=='sup'){
			$('#search_supplier').click();
		}else if(sb=='dev'){
			$('#search_delivery').click();
		}else if(sb=='inv'){
			$('#search_invoice').click();
		}else if(sb=='law'){
			$('#search_lawfee').click();
		}
		if($(this).val()!=0){
			$('#ckcheck').attr('disabled',true);
		}
		else{
			$('#ckcheck').attr('disabled',false);
		}
	})
	$(document).on('change','#ckcheck',function(e){
		$('.customCheck').attr('checked',document.getElementById("ckcheck").checked);
	})

});
	</script>
@endsection