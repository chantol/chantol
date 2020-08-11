@extends('layouts.master')
@section('pagetitle')
	Score Report
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
		 @page
		    {
		    	size:A4 landscape;
		        margin:2mm 2mm 2mm 2mm;
		       
		    }
	</style>	

@endsection
@section('content')

	 <div class="panel panel-default">
      <div class="panel-heading" style="background:blue;color:white;"><b>***Score Report</b></div>
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
							<div class="col-lg-3">
								<label for="customer">Select Customer</label>
								<select name="customer" id="customer" class="form-control" style="height:40px;">
									<option value="0">ALL Customer</option>
									@foreach ($customers as $cus)
										<option value="{{ $cus->id }}">{{ $cus->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-lg-2">	
								<div class="row" style="">
									<button class="btn btn-primary" id="btnsearchbydate" style="margin-top:25px;height:40px;width:80px;">Show</button>
									<button class="btn btn-info" id="btnprint" style="margin-top:25px;height:40px;width:80px;">Print</button>
								</div>
							</div>
							
							
						</div>
					</div>
				</div>
	
				<div class="row" >
			    	<div class="col-md-12">
			    		<div class="panel panel-default" id="printlocation">
			    			<div class="panel-heading" style="height:40px;">
			    				<table>
			    					<tr>
			    						<td style="font-family:khmer os system;padding-right:20px;" id="rptheader">របាយការណ៌លក់និងពិន្ទុ</td>
			    						<td style="font-family:khmer os system;" id="rptheader1">អតិថិជន</td>
			    					</tr>
			    				</table>
			    			</div>

			    			<!-- Image loader -->
							<div id="fade"></div>
					        <div id="modal">
					            <img id="loader" src="/logo/ajaxloading4.gif" />
					        </div>

			    			<div class="panel-body" id="table_data">
			    				{{-- @include('reports.productsale') --}}
			    			</div>
			    			<div class="panel-footer" style="border-style:none;">
			    				<div class="row">
				    				<div class="col-lg-6">
				    					<div class="row">
				    						<label style="font-family:khmer os system;font-size:22px;margin-left:10px;margin-right:10px;">សរុបទឹកប្រាក់ពិន្ទុ</label>
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
		$('#customer').select2();
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

				var nkhr=$('#tpkhr').val();
				var nbat=$('#tpbat').val();
				var nusd=$('#tpusd').val();
				nkhr=Number(nkhr).toFixed(0);
				nbat=Number(nbat).toFixed(0);
				nusd=Number(nusd).toFixed(2);
				$('#tkhr_profit').text(formatNumber(nkhr) + ' R');
				$('#tbat_profit').text(formatNumber(nbat) + ' B');
				$('#tusd_profit').text(formatNumber(nusd) + ' $');
			}

			

			$(document).on('click','#btnsearchbydate',function(e){
				e.preventDefault();
				openModal();
				$('#search_by').val('date');
			 	var s = document.getElementById("customer");
				var cusname = s.options[s.selectedIndex].text;
				$('#rptheader').text('របាយការណ៌លក់ពិន្ទុ គិតពី: ' + $('#start_date').val() + ' ដល់: ' + $('#end_date').val());
				$('#rptheader1').text("អតិថិជន: " + cusname);
				var url="{{ route('getitemsalescore') }}";
				var d1=$('#start_date').val();
				var d2=$('#end_date').val();
				var cusid=$('#customer').val();
				$.get(url,{d1:d1,d2:d2,cusid:cusid},function(data){
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
			function printContent(el)
		{
			  var restorpage=document.body.innerHTML;
			  var printloc=document.getElementById(el).innerHTML;
			  document.body.innerHTML=printloc;
			  window.print();
			  document.body.innerHTML=restorpage;
			  $('#customer').select2();
			  var today=new Date();
			  $('#start_date').datetimepicker({
					timepicker:false,
					datepicker:true,
					value:today,
					//format:'H:i',
					format:'d-m-yy',
					autoclose:true,
					todayBtn:true,
					startDate:today,

				});
				$('#end_date').datetimepicker({
					timepicker:false,
					datepicker:true,
					//value:'13-03-2020',
					value:today,
					//format:'H:i',
					format:'d-m-yy',
					autoclose:true,
					todayBtn:true,
					startDate:today,

				});
		}
		$(document).on('click','#btnprint',function(e){
			e.preventDefault();
			$('#customer').select2('destroy');
			printContent('printlocation');
		})
			
			
});
	</script>
@endsection