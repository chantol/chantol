@extends('layouts.master')
@section('pagetitle')
	A/R
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
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	     	<p style="font-size:22px;padding:5px;">Account Receiveable</p>
	    </div>
	    
	    
		<a href="{{ route('printallcustomerdebtinvoice') }}" class="btn btn-info navbar-btn" id="btnprintinvdebt" style="font-family:khmer os system;" target="_blank()">
			ព្រីនវិក័យប័ត្រអ្នកជំពាក់ទាំងអស់
		</a>
	  </div>
	</nav>

	
	<div class="row" style="margin-left:-3px;">
		   <!-- Image loader -->
        <div id="fade"></div>
        <div id="modal">
            <img id="loader" src="/logo/ajaxloading4.gif" />
        </div>
		<div class="col-lg-3">
			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading" style="height:20px;">
						<p style="font-family:khmer os system;">ឈ្មោះអតិថិជនដែលត្រូវទារ</p>
					</div>
					<div class="panel-body">
						<div class="table-responsive" style="overflow:auto;">
							<table class="table table-hover table-bordered">
				               <thead>
				               		<tr>
				                       <td colspan=2 style="padding:0px;">
				                           <input type="text" id="customersearch" class="form-control autocomplete" style="font-family:khmer os system;height:40px;" placeholder="Search Customer" autocomplete="off">
				                       </td>
				                   </tr>
				                    <tr style="text-align:center;"> 
				                        <td>No</td>
				                        <td>Customer Name</td>
				                   </tr>
				               </thead>
				               <tbody id="customer">
				                    @foreach ($customers as $key => $cus)
				                        <tr>
				                           <td style="width:auto;">{{ ++$key }}</td>
				                           <td style="padding:0px;"><a href="#" class="btn btn-default cusname" style="height:40px;width:100%;text-align:left;font-family:khmer os content;padding-top:10px;" data-id="{{ $cus->supplier_id }}" data-cname="{{ $cus->supplier->name }}">{{ $cus->supplier->name }}</a></td>
				                       </tr>
				                    @endforeach
				               </tbody>
				           	</table>
				        </div>
					</div>
				</div>
			</div>
		</div>
		{{-- ----------------------------------------- --}}
		<div class="col-lg-9">
				<div class="row" style="margin-left:1px;margin-right:1px;">
					<div class="panel panel-info" style="overflow:auto;">
						<div class="panel-heading" style="height:20px;">
							<p style="font-family:khmer os system;">វិក័យប័ត្រជំពាក់</p>
						</div>
						<div class="panel-body">
							<div class="col-lg-4">
								<div class="row">
									<label for="customername">Customer Name</label>
									<input type="text" class="form-control" name="customername" id="customername" style="height:40px;font-family:khmer os system;" readonly>
									<input type="hidden" class="form-control" name="customerid" id="customerid">
								</div>
							</div>
							<div class="col-lg-3" id="startdate">
								<label for="startdate">Start Date</label>
								<div class="input-group">
									<input type="text" name="start_date" id="start_date" class="form-control" style="height:40px;">
									<div class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</div>
								</div>
							</div>
							<div class="col-lg-3" id="enddate">
								<label for="enddate">End Date</label>
								<div class="input-group">
									<input type="text" name="end_date" id="end_date" class="form-control" style="height:40px;">
									<div class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</div>
								</div>
							</div>
							<div class="col-lg-2">	
								<label for="ckalldate" style="">
			                    	<input type="checkbox" checked id="ckalldate" name="ckalldate">
			                    	all Date
			                    </label>   
								<button class="btn btn-info btnsearchbydate" style="margin-top:0px;size:40px;display:block;">Search by Date</button>
							</div>
						</div>
					</div>
				</div>

				<div class="row" style="margin-top:-25px;">
					<div class="col-lg-12">
			    		<div class="panel panel-default">
			    			<div class="panel-heading">
			    				<h3 class="panel-title" style="display:inline;"><strong>Invoice List</strong></h3>
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

			    			<div class="panel-body" id="table_data">
			    				@include('sales.s_invoice')
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	
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
				$.get(url,{id:invid,customer:'customer'},function(data){
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
					$.post(url,{id:paid_id,purinv:purinv,totalinv:totalinv,paymethod:'customer'},function(data){
						console.log(data)
						//alert(data[0].tpaid)
						$('#ppdt').empty().html(data);
						$('#tpaid').val(formatNumber($('#totalpaid').val()) + cur);
						var bal=parseFloat(totalinv)-parseFloat($('#totalpaid').val());
						$('#bal').val(formatNumber(bal) + cur);
						$('.btnsearchbydate').click();

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
	                        show: true
	                }); 
            	$('#frmsavesalepaidlist').trigger('reset');
            	$('#paydate').val(moment().format('DD-MM-YYYY'));
            	$('#spl').empty();
            	$('#paymethod').val('customer');
            	$('#btnsavepaid').attr('disabled',true);
	            $("#invoicelist input[type=checkbox]:checked").each(function (){
	                var row = $(this).closest("tr");
	                if(i==0){
	                	 customer0=row.find("td:eq(6)").text();
	                	 cur0=row.find("td:eq(17)").text();
	                }
	                var customer1=row.find("td:eq(6)").text();
	                cur=row.find("td:eq(17)").text();
	                if(customer0 != customer1 || cur0 != cur){
	                	alert('paid invoice not the same name please check again')
	                	$('#btncancel').click();
	                	return false;
	                }

	               	total=row.find("td:eq(13)").text().replace(/,/g,'').replace('B','').replace('R','').replace('$','');
	                invnums =row.find("td:eq(2)").text(); 
	                
	                i++;
	                 var paytype='customer';
	                 var url="{{ route('totalsaleinvoicepaid') }}";
	                  $.get(url,{buyinv:invnums,paytype:paytype},function(data){
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
	                  })
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
						$('.btnsearchbydate').click();
						
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
      	var k=String(num).split('.');
      	if(k.length==2){
      		var fnum=k[0].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      		var snum=k[1];
      		return fnum + '.' + snum;
      	}else{
      		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      	}
	}

	function inputNumber(input,nosign)
	{
		$('tbody').delegate(input,'keydown',function(){
			var tr=$(this).parent().parent();
			number(tr.find(input),nosign);
		});
	}
	
	
	// $(document).ajaxStart(function(){
	//   openModal();
	// });
	// $(document).ajaxComplete(function(){
	//   setTimeout(function()
	//   		{
	// 			closeModal();
	// 		},100);
	// });
	// function openModal() {
 //        document.getElementById('modal').style.display = 'block';
 //        document.getElementById('fade').style.display = 'block';
	// }

	// function closeModal() {
	//     document.getElementById('modal').style.display = 'none';
	//     document.getElementById('fade').style.display = 'none';
	// }
	
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
	         cur=row.find('td:eq(17)').text();
	         var amt=row.find('td:eq(20)').text().replace(/,/g,'');
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
		$('.btnsearchbydate').click();
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
	//------------------------------------
	$(document).on('keydown','#customersearch',function(e){
		if(e.keyCode==13){
			var url="{{ route('readcustomerdebtname') }}";
			var q=$(this).val();
			$.get(url,{q:q},function(data){
				e.preventDefault();
				console.log(data)
				$('#customer').empty().html(data);
			});
		}
		
	})
	$(document).on('click','.cusname',function(e){
		e.preventDefault();
		var cid=$(this).data('id');
		$('#customername').val($(this).data('cname'));
		$('#customerid').val(cid);
		getsaleinv(cid);

	})
	function getsaleinv(cid) {
		var isalldate=document.getElementById("ckalldate").checked
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
		
		var url="{{ route('invoicelistsearchfordebt') }}";
		$.get(url,{start_date:start_date,end_date:end_date,operater:op,alldate:isalldate,cid:cid},function(data){
			//console.log(data)
			$("#table_data").empty().html(data);
			})
		
	}

	$(document).on('click','.btnsearchbydate',function(e){
		var cid=$('#customerid').val();
		getsaleinv(cid);
	})
	//-------------------------
	var path = "{{ route('autocomplete_suppliername',1) }}";
    $('input.autocomplete').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
			
});
	</script>
@endsection