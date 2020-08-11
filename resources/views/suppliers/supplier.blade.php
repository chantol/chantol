@extends('layouts.master')
@section('pagetitle')
	{{ $text['pagetitle'] }}
@endsection
@section('css')
	<link href="{{ asset('css') }}/toastr.min.css" rel="stylesheet">
	<style type="text/css">
		hr.new1 {
		  border-top: 1px solid #ccc;
		}
		hr.new2 {
		  border-top: 1px solid gray;
		}
		thead{
			
			background-color:#ccc;
		}
		.activecolor{
			color:blue;
		}
		.disactivecolor{
			color:red;
		}
		#myInput {
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
		}
	</style>
@endsection
@section('content')
	<div class="col-lg-12">
		<div class="row" style="margin-top:-20px;">
			<h3>{{ $text['heading'] }}</h3>
			
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<ol class="breadcrumb" style="margin-top:0px;padding:5px;">
						<li id="btnaddnew" style="cursor:pointer;font-weight:bold;"><i class="fa fa-file-text-o"></i>Add New</li>
						<li>
							<div class="form-check" style="display:inline;">
							  <label class="form-check-label" style="color:blue;font-weight:bold;">
							    <input type="radio" class="form-check-input radshow" name="radc" style="font-family:khmer os system;" checked value="1" data-text="Active">Active
							  </label>
							</div>
						</li>
						<li>
							<div class="form-check" style="display:inline;">
							  <label class="form-check-label" style="color:red;font-weight:bold;">
							    <input type="radio" class="form-check-input radshow" name="radc" style="font-family:khmer os system;" value="0" data-text="Disactive">Disactive
							  </label>
							</div>
						</li>
						<li>
							<div class="form-check" style="display:inline;">
							  <label class="form-check-label" style="color:black;font-weight:bold;">
							    <input type="radio" class="form-check-input radshow" name="radc" style="font-family:khmer os system;" value="2" data-text="All">All
							  </label>
							</div>
						</li>
					</ol>
					
				</div>
			</div>
		</div>

		<div class="row" >
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-4">
						<h3 style="margin-top:2px;font-family:khmer os system;">{{ $text['title'] }}</h3>
					</div>
					<div class="col-lg-4">
						<table class="table">
							<tr>
								<td>Search by:</td>
								<td style="padding:0px;">
									<select name="searchtableby" id="searchtableby" class="form-control">
										<option value="1">Name</option>
										<option value="2">Phone Number</option>
										<option value="3">Code</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan=2 style="padding:0px;"><input type="text" id="myInput" onkeyup="autosearch()" placeholder="Auto Search..." title="Type in a name"></td>
							</tr>
						</table>
						
					</div>
					<div class="col-lg-4">
						
						<div class="input-group input-group-sx" style="margin-top:0px;">
				          <input type="text" name="search" id="search" class="typeautosearch form-control" placeholder="Search" style="width:100%;display:inline;float:right;border-radius:25px;" autocomplete="off">
				          <div class="input-group-btn" >
				            <button type="button" class="btn btn-default btnsearch" style="display:inline;float:right;width:40px;border-radius:25px;"><i class="fa fa-search" style="margin-left:0px;"></i></button>
				          </div>
				        </div>
					</div>
				</div>
				<div class="row" style="overflow:auto;">
					<table class="table table-hover table-bordered" id="myTable">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Date</th>
								<th class="text-center">Name</th>
								<th class="text-center">Sex</th>
								<th class="text-center">Telephone</th>
								<th class="text-center">Email</th>
								@if ($text['coltype']==1)
									<th class="text-center">C-Code</th>
									<th class="text-center">C-Price</th>
								@endif
								
								<th class="text-center">Address</th>
								<th class="text-center">Active</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody id="suplist">
							@foreach ($sups as $key =>$sup)
								<tr class={{ $sup->active==1?"activecolor":"disactivecolor" }}>
									<td>{{ ++$key }}</td>
									<td>{{ date('d-m-Y',strtotime($sup->created_at)) }}</td>
									<td style="font-family:khmer os system;">{{ $sup->name }}</td>
									<td style="font-family:khmer os system;">{{ $sup->sex }}</td>
									<td>{{ $sup->tel }}</td>
									<td>{{ $sup->email }}</td>
									@if ($sup->type==1)
										<td>{{ $sup->customercode }}</td>
										<td>{{ $sup->customerprice }}</td>
									@endif
									
									<td style="font-family:khmer os system;">{{ $sup->address }}</td>
									<td>{{ $sup->active }}</td>
									<td>
										<a href="" class="btn btn-warning btn-sm row-edit" data-id="{{ $sup->id }}" data-name="{{ $sup->name }}" data-sex="{{ $sup->sex }}" data-tel="{{ $sup->tel }}" data-email="{{ $sup->email }}" data-address="{{ $sup->address }}" data-active="{{ $sup->active }}" data-cuscode="{{ $sup->customercode }}" data-cusprice="{{ $sup->customerprice }}" title="Edit">
											<i class="fa fa-edit"></i>
										</a>
										<a href="" class="btn btn-danger btn-sm row-delete" data-id="{{ $sup->id }}" data-name="{{ $sup->name }}" title="Remove">
											<i class="fa fa-trash"></i>
										</a>
										@if ($sup->active==0)
											<a href="" class="btn btn-info btn-sm row-restore" data-id="{{ $sup->id }}" data-name="{{ $sup->name }}" title="restore">
												<i class="fa fa-reply"></i>
											</a>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@include('suppliers.supplieradd_modal')
@endsection
@section('script')
	<script src="{{ asset('js') }}/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	<script type="text/javascript">
		
		
		var path = "{{ route('autocomplete.supplier') }}";
	    $('input.typeautosearch').typeahead({
	        source:  function (query, process) {
	        return $.get(path, { query: query,type:$('#coltype').val(),active:val_radio }, function (data) {
	                return process(data);
	            });
	        }
	    });
	    $(document).on('keyup','#customercode',function(){
	    	var q=$(this).val();
	    	if(q != ''){
	    		$.ajax({
	    			url:"{{ route('autocomplete.customercode') }}",
	    			method:"GET",
	    			data:{q:q},
	    			success:function(data)
	    			{
	    				console.log(data)
	    				$('#customercodelist').fadeIn();
	    				$('#customercodelist').html(data);
	    			}
	    		})
	    	}
	    })
	    $(document).on('blur','#customercode',function(){
	    	$('#customercodelist').fadeOut();
	    })
	    $(document).on('click','.liclick',function(e){
	    	e.preventDefault();
	    	$('#customercode').val($(this).text());
	    	$('#customercodelist').fadeOut();
	    })
		$(document).on('click','#btnaddnew',function(e){
			e.preventDefault();
			$('#btnsavesup').text('Save');
			var type=$('#coltype').val();
			$('#frm_supplier').trigger('reset');
			$('#supid').val('');
			$('#supplier_modal').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                		}); 
			
			if(type==0){
				$('#modal_title').text('Add Supplier');
				$('#fcuscode').css('display','none')
				$('#fcusprice').css('display','none')
				
			}else if(type==1){
				$('#modal_title').text('Add Customer');
				$('#fcuscode').css('display','block')
				$('#fcusprice').css('display','block')
			}
			
		})
		$(document).on('click','#btnsavesup',function(e){
			var data=$('#frm_supplier').serialize();
			var supid=$('#supid').val();
			if(supid==''){
				var url="{{ route('supplier.save') }}";
				$.post(url,data,function(data){
					if($.isEmptyObject(data.error)){
						toastr.success('Save Successfully');
						readdata(val_radio);
						$('#frm_supplier').trigger('reset');
						$('#supplier_name').focus();
					}else{
						alert(data.error)
					}
				})
			}else{
				var url="{{ route('supplier.update') }}";
				$.post(url,data,function(data){
					if($.isEmptyObject(data.error)){
						toastr.info('Update Successfully');
						if(searchval==0){
							readdata(val_radio);
						}else if(searchval==1){
							searchbyname()
						}
						$('#closemodalsup').click();
					}else{
						alert(data.error)
					}
				})
			}
			
		})
		$(document).on('click','.row-edit',function(e){
			e.preventDefault();
			var type=$('#coltype').val();
			if(type==0){
				$('#modal_title').text('Update Supplier');
			}else if(type==1){
				$('#modal_title').text('Update Customer');
			}
			var id=$(this).data('id');
			var name=$(this).data('name');
			var sex=$(this).data('sex');
			var tel=$(this).data('tel');
			var email=$(this).data('email');
			var cuscode=$(this).data('cuscode');
			var cusprice=$(this).data('cusprice');
			var address=$(this).data('address');
			var active=$(this).data('active');
			$('#supplier_name').val(name);
			$("input[name=sex][value="+ sex +"]").prop("checked",true);
			$("input[name=active][value="+ active +"]").prop("checked",true);
			$('#supid').val(id);
			$('#tel').val(tel);
			$('#email').val(email);
			$('#customercode').val(cuscode);
			$('#customerprice').val(cusprice);
			$('#address').text(address);
			$('#btnsavesup').text('Update');
			$('#supplier_modal').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                		}); 
		})
		$(document).on('click','.row-delete',function(e){
			e.preventDefault();
			var name=$(this).data('name');
			var c=confirm('Do you want to remove ' + name + '?');
			if(c==true){
				var supid=$(this).data('id');
				var url="{{ route('supplier.delete') }}";
				$.post(url,{supid:supid},function(data){
					if(searchval==0){
						readdata(val_radio);
					}else if(searchval==1){
						searchbyname()
					}
					
				})
			}
		})
		$(document).on('click','.row-restore',function(e){
			e.preventDefault();
			var name=$(this).data('name');
			var c=confirm('Do you want to restore ' + name + '?');
			if(c==true){
				var supid=$(this).data('id');
				var url="{{ route('supplier.restore') }}";
				$.post(url,{supid:supid},function(data){
					if(searchval==0){
						readdata(val_radio);
					}else if(searchval==1){
						searchbyname()
					}
				})
			}
		})
		function readdata(active) {
			var url="{{ route('supplier.readdata') }}";
			var coltype=$('#coltype').val();

			$.get(url,{coltype:coltype,active:active},function(data){
				$('#suplist').empty().html(data);
			})
		}
		var val_radio='1';
		$(document).on('change','.radshow',function(e){
			e.preventDefault();
			searchval=0;
			val_radio=$(this).val();
			readdata(val_radio);
		})
		$(document).on('keydown','#search',function(e){
	 	
	 	if (e.keyCode == 13) {
	 		searchbyname($(this).val());
	 		e.preventDefault();
	 	}
	 })
		$(document).on('click','.btnsearch',function(e){
			e.preventDefault();
			searchbyname();
		})
		var searchval='0';
		function searchbyname() {
			searchval='1';
			var name=$('#search').val();
			var type=$('#coltype').val();
			var url="{{ route('supplier.search') }}";
			$.get(url,{name:name,type:type,active:val_radio},function(data){
				$('#suplist').empty().html(data);
			})
		}
		function autosearch() {
			var searchby=$('#searchtableby').val();
			if(searchby==1){

			}else if(searchby==2){

			}else if(searchby==3){

			}
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById("myInput");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("myTable");
		  tr = table.getElementsByTagName("tr");
		  for (i = 0; i < tr.length; i++) {
		  	if(searchby==1){
		  		td = tr[i].getElementsByTagName("td")[2];
			}else if(searchby==2){
				td = tr[i].getElementsByTagName("td")[4];
			}else if(searchby==3){
				td = tr[i].getElementsByTagName("td")[6];
			}
		    
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

	


	</script>
@endsection