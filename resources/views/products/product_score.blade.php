@extends('layouts.master')
@section('pagetitle')
	Product Score
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
		
		label{
			/*font-weight:bold;
			font-size:16px;*/
			font-family:"khmer os system";
		}
		input,button,textarea,td{
			font-family:"khmer os system";

		}
		button.en{
			font-family:"Time New Romain";
		}
		.kh{
			font-family:"khmer os system";
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
	</style>
@endsection
@section('content')
	
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa-file-text-o"></i>Product Score</h3>
		</div>
	</div>
	
	<!-- Image loader -->
	<div id="fade"></div>
    <div id="modal">
        <img id="loader" src="/logo/ajaxloading4.gif" />
    </div>
	
	<div class="row">
		<div class="col-lg-2" style="margin-top:0px;">
			<div class="row" style="margin-left:1px;">
			<button id="btnshowall" class="btn btn-primary" style="width:99%;">បង្ហាញផលិតផលទាំងអស់</button>
			<table class="table table-bordered table-hover">
				
				<tbody>
					@foreach ($categories as $key =>$cat)
						<tr>
							<td class="btn btn-info" style="width:100%" data-toggle="collapse" data-target="#{{ $cat->id }}">{{ $cat->name }}
								<div id="{{ $cat->id }}" class="collapse">
									<br>
							    	<table class="table table-bordered table-hover">
							    		<tr>
							    			<td style="color:blue;width:100%" class="btn btn-default catbrand" data-id="{{ $cat->id }}" data-name="{{ $cat->name }}">
							    				ទាំងអស់
							    			</td>
							    		</tr>
							    		
							    		@foreach (App\Brand::getcatbrand($cat->id) as $k => $br)
							    			<tr>
							    				<td style="color:blue;width:100%" data-id="{{ $cat->id . '-' . $br->id }}" data-name="{{ $cat->name . '-' . $br->name }}" class="btn btn-default catbrand">{{ $br->name }}</td>
							    			</tr>
							    		@endforeach
							    	</table>
							  </div>
							</td>
						</tr>

					@endforeach
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-lg-10" id="printloc">
			<div class="panel panel-default" style="margin-top:0px;" id="divheader">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-6">
						<h3 style="padding-top:5px;">Product List</h3>	
						</div>
						<div class="col-lg-6">
							<div class="input-group input-group-sx" style="padding:5px;">
					          <input type="text" name="psearch" id="psearch" class="typeautosearch form-control" placeholder="Search" style="max-width: 400px;display:inline;float:right;">
					          <div class="input-group-btn" >
					            <button type="button" class="btn btn-default btnsearchproduct" style="display:inline;float:right;width:30px;"><i class="fa fa-search" style="margin-left:-12px;"></i></button>
					          </div>
					        </div>
						</div>
					</div>
					
				</div>
	
				<div class="panel-body">
					<div class="table-responsive">
						<table  class="table table-hover table-bordered" id="table_product_list">
							<thead>
								<tr>
									<th style="text-align:center;">N<sup>o</sup></th>
									<th style="text-align:center;">Date</th>
									<th style="text-align:center;">Product Code</th>
									<th style="text-align:center;">Description</th>
									<th style="text-align:center;">Qty Set</th>
									<th style="text-align:center;">Price</th>
									<th style="text-align:center;">Month/Year</th>
									
									<th style="text-align:center;">Category</th>
									<th style="text-align:center;">Brand</th>
									{{-- <th style="text-align:center;">Image</th> --}}
									<th style="text-align:center;" class="colaction">Action</th>
								</tr>
							</thead>
							<tbody id="tbody-product-list">
								
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
	@include('products.productlistscore_history')
	@include('products.updatescore_modal')
	 
@endsection

@section('script')
	<script src="{{ asset('js') }}/toastr.min.js"></script>
	<script src="{{ asset('js') }}/jquery.datetimepicker.full.js"></script>
	<script src="{{ asset('js') }}/numberinput.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		 var remsearch='';
		 var remcatid='';
		 var rembrid='';
		 $(document).on('keydown','#psearch',function(e){
		 	
		 	if (e.keyCode == 13) {
		 		searchproduct($(this).val());
		 		remsearch='2';
		 		e.preventDefault();
		 	}
		 })
		 
		 function refreshsearch() {
		 	
		 	if(remsearch==1){
		 		var url="{{ route('getproductbycategoryscore') }}";
		        $.get(url,{catid:remcatid,brid:rembrid,status:1},function(data){
		        	$('#tbody-product-list').empty().html(data);
		        })
		 		
		 	}else if(remsearch==2){
		 		searchproduct($('#psearch').val());
		 	}else if(remsearch==3){
		 		var url="{{ route('getproductallcategoryscore') }}";
		        $.get(url,{status:radsel},function(data){
		        	$('#tbody-product-list').empty().html(data);
		        	})
		 	}
		 }
		function searchproduct(q) {
			var url="{{ route('productsearchscore') }}";
			$.get(url,{q:q,status:'1'},function(data){
				//console.log(data)
				$('#tbody-product-list').empty().html(data);
			})
		}
		$(document).on('click','.btnsearchproduct',function(e){
			e.preventDefault();
			var q=$('#psearch').val();
			remsearch='2';
			searchproduct(q);
		})
		
		$(document).on('click','.btn-addnew',function(e){
			e.preventDefault();
			$('#modal_productscore').modal({
	                        backdrop: 'static',
	                        keyboard: true, 
	                        show: true

	                		}); 
			$('#scid').val('');
			$('#btnsave_score').text('រក្សាទុក');
			$('#pid').val($(this).data('id'));
			$('#pname').val($(this).data('name'));
			
			var pid=$(this).data('id');
			getproductunit(pid);
			$('#qtyset').focus();
			
		})
		function getproductunit(pid) {
			$('#unit option').remove();
			var url="{{ route('productunit') }}";
			
			$.get(url,{pid:pid},function(data){
				$('#multi').val(data[0].multiple);
				$.each(data,function(i,item){
				 	 			var unit_val=item.barcode;
				 	 			var unit_text=item.unit;
				 	 			
				 	 			$('#unit').append('<option class="opunit" value="'+ unit_text +'" data-multi="'+ item.multiple +'">'+ unit_text +'</option>');
				 	 		})
			})
		}
		$(document).on('click','.btn-edit',function(e){
			e.preventDefault();
			$('#modal_productscore').modal({
	                        backdrop: 'static',
	                        keyboard: true, 
	                        show: true

	                		}); 
			$('#btnsave_score').text('កែប្រែ');
			var scid=$(this).data('scoreid');
			var scname=$(this).data('name');
			var url="{{ route('getinfobyscoreid') }}";
			$.get(url,{id:scid},function(data){
				//console.log(data)
				$('#scid').val(data.id);
				$('#formonth').val(data.formonth);
				$('#foryear').val(data.foryear);
				$('#pid').val(data.product_id);
				getproductunit(data.product_id);
				$('#pname').val(scname);
				$('#qtyset').val(data.qtyset);
				$('#unit').val(data.unit);
				$('#qty').val(data.qty);
				$('#price').val(formatNumber(data.price));
				$('#cur').val(data.cur);

			})
		})
		$(document).on('click','.btn-delete',function(e){
			e.preventDefault();
			var c=confirm("Do you want to remove this item score?");
			if(c==true){
				var url="{{ route('deleteproductscore') }}";
				var scid=$(this).data('scoreid');
				var pid=$(this).data('id');
				$.post(url,{pid:pid,scid:scid},function(data){
					refreshsearch();
				})
			}
		})
		$(document).on('click','.btn-remove',function(e){
			e.preventDefault();
			var c=confirm("Do you want to remove this item score?");
			if(c==true){
				var row=$(this).closest("tr");
				var url="{{ route('deleteproductscore') }}";
				var scid=$(this).data('id');
				var pid=$(this).data('pid');
				$.post(url,{pid:pid,scid:scid},function(data){
					row.remove();
					
					refreshsearch();
				})
			}
		})
		$(document).on('click','.btn-history',function(e){
			e.preventDefault();

			$('#productscorelist_modal').modal('show');
			$('#productid').text('លេខID:'+$(this).data('id'));
			$('#productname').text('ឈ្មោះផលិតផល:'+ $(this).data('name'));
			var url="{{ route('getproductscorelisthistory') }}";
			var pid=$(this).data('id');
			$.get(url,{pid:pid},function(data){
				$('#tblscorelist').empty().html(data);
			})
	                       
		})
		//-----------------------------------------------------------
		var selection = document.getElementById("unit");
		selection.onchange = function(event){

		//var pri = event.target.options[event.target.selectedIndex].dataset.price;
		var multi = event.target.options[event.target.selectedIndex].dataset.multi;
		var barcode= event.target.options[event.target.selectedIndex].value;
		$('#multi').val(multi);
		totalqty();
		};

		function totalqty() {
			var mul=$('#multi').val();
			var qtyset=$('#qtyset').val();
			var qty=mul * qtyset;
			$('#qty').val(qty);
		}
		
		$(document).on('change','#qtyset',function(){
			totalqty();
		})

		$('#frm_add_score').on('submit',function(e){
			e.preventDefault();
			var data= new FormData(this);
			var urlset='';
			if($('#scid').val()==''){
				urlset="{{ route('postproductscore') }}";
			}else{
				urlset="{{ route('updateproductscore') }}";
			}
			$.ajax({
					type:"POST",
					url:urlset,
					data:data,
					datatype:"JSON",
					contentType:false,
					cache:false,
					processData:false,
					success:function(data){
						console.log(data)
						if($.isEmptyObject(data.error)){
			                	toastr.success('Save Product Score Successfully');
			                	
			                	$('#qtyset').val('');
			                	$('#qty').val('');
			                	$('#price').val('')
			                	$('#btnclosemodal').click();
			                	refreshsearch();
						}else{
							alert(data.error)
						}
					}
				});
			});
		
		
		function printErrorMsg (msg) {
	            $(".print-error-msg").find("ul").html('');
	            $(".print-error-msg").css('display','block');
	            $.each( msg, function( key, value ) {
	                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
	            });
	        }
	       $(document).on('click','.catbrand',function(e){
	       	
	       	openModal();
	       	
	    	
			$('#pl').text('តារាងផលិតផល');
			$('#pl').css('color','blue');
	    	
	       	var id=$(this).data('id');
	       	var name=$(this).data('name');
	       	$('#pl').text(name);
	       	var arrid=String(id).split('-');
	       	var catid=0;
	       	var brid=0;
	       	if(arrid.length==1){
	       		 catid=arrid[0];
	       	}else if(arrid.length==2){
	       		 catid=arrid[0];
	       		 brid=arrid[1];
	       	}
	       	remsearch=1;
	       	remcatid=catid;
	       	rembrid=brid;
	       	var url="{{ route('getproductbycategoryscore') }}";
	       	
	        $.get(url,{catid:catid,brid:brid,status:1},function(data){
	        	$('#tbody-product-list').empty().html(data);
	        	setTimeout(function()
			  		{
						closeModal();
					},300);
	        })
	       
	    })

	    
	    $(document).on('click','#btnshowall',function(e){
	    	
	    	openModal();
	    	remsearch=3;
	    	$('#pl').text('តារាងផលិតផល');
			$('#pl').css('color','blue');
	    	var url="{{ route('getproductallcategoryscore') }}";
	        $.get(url,{status:1},function(data){
	        	$('#tbody-product-list').empty().html(data);
	        	setTimeout(function()
			  		{
						closeModal();
					},300);
	        })
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
	//------------------------------
		var path = "{{ route('autocomplete') }}";
	    $('input.typeautosearch').typeahead({
	        source:  function (query, process) {
	        return $.get(path, { query: query }, function (data) {
	                return process(data);
	            });
	        }
	    });
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
		numberOnly('#qtyset');
		number('#price',true)
	})
	</script>
@endsection