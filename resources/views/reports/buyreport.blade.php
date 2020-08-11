@extends('layouts.master')
@section('pagetitle')
	Buy Report
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
	.colorblue{
		color:blue;
	}
	.colorred{
		color:red;
	}
	.colorblack{
		color:black;
	}
	#tablesearch {
		  background-image: url('{{ asset("photo") }}/search.png');
		  background-position: 10px 8px;
		  background-repeat: no-repeat;
		  width: 100%;
		  font-family:khmer os system;
		  /*font-size: 12px;*/
		  height:34px;
		  padding: 5px 5px 5px 40px;
		  border: 1px solid #ddd;
		  border-radius: 25px;
		  margin-top:3px;
		}
	</style>	

@endsection
@section('content')

	 <div class="panel panel-default">
      <div class="panel-heading" style="background:blue;color:white;"><b>***Buy Report</b></div>
      <div class="panel-body">
      		<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-body">
							<div class="col-lg-2" id="startdate">
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
							<div class="col-lg-2" id="enddate">
								<div class="row" style="padding-left:3px;padding-right:3px;">
									<label for="enddate">End Date</label>
									<div class="input-group">
										<input type="text" name="end_date" id="end_date" class="form-control" style="height:40px;">
										<div class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</div>
									</div>
								</div>
								<input type="hidden" id="search_by" value="date">
							</div>
							<div class="col-lg-2">	
								<div class="row" style="">
									<button class="btn btn-primary" id="btnsearchbydate" style="margin-top:25px;height:40px;width:80px;">Show</button>
									<button class="btn btn-info" id="btnsearchbyelephan" style="margin-top:25px;height:40px;width:80px;">Show2</button>
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="row" style="padding-right:3px;">
									<label for="select">Search Type:</label>
									<select name="typesearch" id="typesearch" class="form-control typesearch" style="font-family:khmer os system;height:40px;">
										<option value=""></option>
										<option value="0">អ្នកផ្គត់ផ្គង់</option>
										<option value="1">មុខទំនិញ</option>
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="row" id="fillsearch">
									
								</div>
							</div>
						</div>
					</div>
				</div>
	
				<div class="row">
			    	<div class="col-md-12">
			    		<div class="panel panel-default">
			    			<div class="panel-heading">
			    				<div class="row">
			    				<div class="col-lg-6">
			    					<h3 class="panel-title" style="display:inline;font-family:khmer os system;" id="rptheader"><strong>របាយការណ៌ទិញចូល</strong></h3>
			    					
			    				</div>
			    				
			    				<div class="col-lg-3">
			    					<table class="table table-bordered" style="width:100%;">
			    						<td><p style="display:inline;font-weight:bold;margin-top:0px;">Group By:</p></td>
			    						<td>
			    							<div class="custom-control custom-radio" style="display:inline;">
											  <input type="radio" class="custom-control-input rad" id="groupbydate" name="grouprad" checked value="date">
											  <label class="custom-control-label" for="groupbydate" id="lblgroupbydate" ><strong>Date</strong></label>
											</div>
			    						</td>
			    						<td>
			    							<div class="custom-control custom-radio" style="display:inline;">
											  <input type="radio" class="custom-control-input rad" id="groupbytype" name="grouprad" value="type">
											  <label class="custom-control-label" for="groupbytype" id="lblgroupbytype" style="color:red;"><strong>Category</strong></label>
											</div>
			    						</td>
			    						<td>
			    							<div class="custom-control custom-radio" style="display:inline;">
											  <input type="radio" class="custom-control-input rad" id="groupbyitem" name="grouprad" value="item">
											  <label class="custom-control-label" for="groupbyitem" id="lblgroupbyitem" style="color:blue;"><strong>Item</strong></label>
											</div>
			    						</td>
			    					</table>
			    				</div>
			    				<div class="col-lg-3">
			    					<input type="text" id="tablesearch" onkeyup="autosearch()" placeholder="Search by Item Name..." title="Type in a name">
			    				</div>
								<!-- Group of default radios - option 2 -->
								</div>
			    			</div>

			    			<!-- Image loader -->
							<div id="fade"></div>
					        <div id="modal">
					            <img id="loader" src="/logo/ajaxloading4.gif" />
					        </div>

			    			<div class="panel-body" id="table_data">
			    				{{-- @include('reports.productsale') --}}
			    			</div>
			    			<div class="panel-footer">
			    				<div class="row">
				    				
				    				<div class="col-lg-6">
				    					<div class="row">
				    						<label style="font-family:khmer os system;font-size:22px;margin-left:10px;margin-right:10px;">សរុបលុយទិញ</label>
				    						<span class="label label-info" id="tusd_sale" style="font-size:22px;">0$</span>
					    					<span class="label label-info" id="tbat_sale" style="font-size:22px;">0B</span>
					    					<span class="label label-info" id="tkhr_sale" style="font-size:22px;">0R</span>
				    					</div>
				    				</div>
				    				
			    				</div>
			    			</div>
			    			
			    		</div>
			    	</div>
	    	</div>

      </div>

    </div>
				
	
@endsection
@section('script')
	<script src="{{ asset('js') }}/numbertoword.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	<script type="text/javascript">
		function autosearch() {
				 foundkeysearch='true';
				  var input, filter, table, tr, td, i, txtValue;
				  input = document.getElementById("tablesearch");
				  filter = input.value.toUpperCase();
				  table = document.getElementById("mytable");
				  tr = table.getElementsByTagName("tr");
				  for (i = 0; i < tr.length; i++) {
				    td = tr[i].getElementsByTagName("td")[3];
				    if (td) {
				      txtValue = td.textContent || td.innerText;
				      if (txtValue.toUpperCase().indexOf(filter) > -1) {
				        tr[i].style.display = "";
				      } else {
				        tr[i].style.display = "none";
				      }
				    }       
				  }
				}
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
			function total() {
				$('#tkhr_sale').text(formatNumber($('#tskhr').val()) + ' R');
				$('#tbat_sale').text(formatNumber($('#tsbat').val()) + ' B');
				$('#tusd_sale').text(formatNumber($('#tsusd').val()) + ' $');
			}

			$(document).on('click','#btnsearchbyelephan',function(e){
				e.preventDefault();
				var url="{{ route('getitembuyforeq') }}";
				var d1=$('#start_date').val();
				var d2=$('#end_date').val();
				$.get(url,{d1:d1,d2:d2},function(data){
					$("#table_data").empty().html(data);
				});
			})

			$(document).on('click','#btnsearchbydate',function(e){
				e.preventDefault();
				openModal();
				$('#search_by').val('date');
				var radsel=$('input[name="grouprad"]:checked').val();
				var g1='';
				var g2='';
				
				if(radsel=='date'){
					g1='purchases.invdate';
					g2='purchase_details.product_id';
				}else if(radsel=='item'){
					g2='purchases.invdate';
					g1='purchase_details.product_id';
				}else if(radsel=='type'){
					g1='products.category_id';
					g2='purchase_details.product_id';
				}
				$('#rptheader').text('របាយការណ៌ទិញ គិតពី: ' + $('#start_date').val() + ' ដល់: ' + $('#end_date').val());
				var url="{{ route('getitembuy') }}";
				var d1=$('#start_date').val();
				var d2=$('#end_date').val();
				$.get(url,{d1:d1,d2:d2,g1:g1,g2:g2},function(data){
					$("#table_data").empty().html(data);
					setTimeout(function()
			  		{
						closeModal();
					},300);
				});
				total();
			})
			$(document).on('click','#search_supplier',function(e){
				e.preventDefault();
				openModal();
				$('#search_by').val('supplier');
				var radsel=$('input[name="grouprad"]:checked').val();
				var g1='';
				var g2='';
				if(radsel=='date'){
					g1='purchases.invdate';
					g2='purchase_details.product_id';
				}else if(radsel=='item'){
					g2='purchases.invdate';
					g1='purchase_details.product_id';
				}else if(radsel=='type'){
					g1='products.category_id';
					g2='purchase_details.product_id';
				}
				var s = document.getElementById("supplier");
				var supname = s.options[s.selectedIndex].text;
				$('#rptheader').text('ទិញពី៖ '+ supname + '   គិតពី: ' + $('#start_date').val() + ' ដល់: ' + $('#end_date').val());
				var url="{{ route('getitembuybycustomer') }}";
				var d1=$('#start_date').val();
				var d2=$('#end_date').val();
				var supplierid=$('#suppplier').val();
				var supplier=$('#supplier').val();
				$.get(url,{d1:d1,d2:d2,supplierid:supplier,g1:g1,g2:g2},function(data){
					$("#table_data").empty().html(data);
					setTimeout(function()
			  		{
						closeModal();
					},300);
				});
				total();
			})
			$(document).on('click','#search_item',function(e){
				e.preventDefault();
				openModal();
				var itemname=$('#itemsearch').val();
				
				$('#rptheader').text('របាយការណ៌ទិញផលិតផល៖ '+ itemname + '   គិតពី: ' + $('#start_date').val() + ' ដល់: ' + $('#end_date').val());
				var url="{{ route('getitembuybyitem') }}";
				var d1=$('#start_date').val();
				var d2=$('#end_date').val();
				
				$.get(url,{d1:d1,d2:d2,item:itemname},function(data){
					$("#table_data").empty().html(data);
					setTimeout(function()
			  		{
						closeModal();
					},300);
				});
				total();
			})
			function formatNumber(num) {
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
					 el='<label for="select">Search By Item:</label>'+
					'<div class="input-group">'+
					'<input type="text" name="itemsearch" id="itemsearch" class="form-control autocompleteproductname" style="height:40px;font-family:khmer os system" autocomplete="off">'+
					'<div class="input-group-addon btn btn-default" id="search_item">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					
					$('#fillsearch').html(el);

					var path = "{{ route('autocomplete') }}";
				    $('input.autocompleteproductname').typeahead({
				        source:  function (query, process) {
				        return $.get(path, { query: query }, function (data) {

				                return process(data);
				            });
				        }
				    });
				}
			})
			
			function openModal() {
		        document.getElementById('modal').style.display = 'block';
		        document.getElementById('fade').style.display = 'block';
			}

			function closeModal() {
			    document.getElementById('modal').style.display = 'none';
			    document.getElementById('fade').style.display = 'none';
			}
			$(document).on('change','#groupbydate,#groupbytype,#groupbyitem',function(e){
				var searchby=$('#search_by').val();
				
				if(searchby=='date'){
					$('#btnsearchbydate').click();
				}else if(searchby=='supplier'){
					$('#search_supplier').click();
				}
			})
			
			
});
	</script>
@endsection