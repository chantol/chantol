
@extends('layouts.master')
@section('pagetitle')
	Category Set
@endsection
@section('css')
	<style type="text/css">
		.tab-content {
		    border-left: 1px solid #ddd;
		    border-right: 1px solid #ddd;
		     border-bottom: 1px solid #ddd;
		    padding: 10px;
		}

		.nav-tabs {
		    margin-bottom: 0;
		}
		.myInput {
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

		.activecolor{
			color:blue;
		}
		.disactivecolor{
			color:rgb(255, 80, 71);
		}
	</style>
@endsection

@section('content')
	<div class="container-fluid" style="margin-top:-20px;margin-left:20px;">
  		  <h2>Delivery Set</h2>

		  <ul class="nav nav-tabs border-info">
		    <li class="active"><a data-toggle="tab" href="#home">Delivery</a></li>
		    <li><a data-toggle="tab" href="#co">CO LAW</a></li>
		    
		  </ul>

		  <div class="tab-content">
		    <div id="home" class="tab-pane fade in active">
		     <div class="row">
		     	<div class="col-lg-4" style="">
		     		<div class="panel panel-default">
		     			<div class="panel-heading">
		     				Delivery Set
		     			</div>
		     			<div class="panel-body">
		     				<form action="" id="frmdelivery">
		     					<div class="form-group">
			     					<input type="hidden" id="dev_id" name="dev_id">
			     					<label for="devname">Delivery</label>
				     				<input type="text" class="form-control autocomplete_category" name="dev_name" id="dev_name" style="height:40px;font-family:khmer os system;">
			     				</div>
			     				<div class="form-group">
				                  <label for="tel">Tel:</label>
				                  <input type="text" class="form-control" name="tel" id="tel" autocomplete="off">
				               	</div>
				               	<div class="form-group">
				                  <label for="email">Email:</label>
				                  <input type="email" class="form-control"  name="email" id="email" autocomplete="off">
				                </div>
				                <div class="form-group">
				                	<label for="active">Active</label>
				     				<select name="dev_active" id="dev_active" class="form-control" style="height:40px;">
				     					<option value="1">Active</option>
				     					<option value="0">Disactive</option>
				     				</select>
				                </div>
				                <div class="form-group">
				                  <label for="Address">Address:</label>
				                  <textarea name="address" id="address" class="form-control" cols="30" rows="3"></textarea>
				               	</div>
		     				</form>
		     				
		     			</div>
		     			<div class="panel-footer" style="height:50px;">
		     				<button class="btn btn-default" id="btnnewdev">Add New</button>
		     				<button class="btn btn-info pull-right" id="btnsavedev">Save</button>
		     			</div>
		     		</div>
		     		
		     	</div>
		     	<div class="col-lg-8">

		     		<div class="row">
		     			<div class="col-lg-6" style="background-color:#ccc;border-radius:25px;padding:5px;height:34px;">
		     				<div class="form-check" style="display:inline;padding-right:5px;">
							  <label class="form-check-label" style="color:blue;font-weight:bold;">
							    <input type="radio" class="form-check-input radshow" name="radc" style="font-family:khmer os system;" checked value="1" data-text="Active">Active
							  </label>
							</div>
							<div class="form-check" style="display:inline;padding-right:5px;">
							  <label class="form-check-label" style="color:rgb(255, 80, 71);font-weight:bold;">
							    <input type="radio" class="form-check-input radshow" name="radc" style="font-family:khmer os system;" value="0" data-text="Disactive">Disactive
							  </label>
							</div>
							<div class="form-check" style="display:inline;">
							  <label class="form-check-label" style="color:black;font-weight:bold;">
							    <input type="radio" class="form-check-input radshow" name="radc" style="font-family:khmer os system;" value="2" data-text="All">All
							  </label>
							</div>
							&nbsp;&nbsp;
							<div class="form-check" style="display:inline;">
							  <label class="form-check-label" style="color:red;font-weight:bold;">
							    <input type="radio" class="form-check-input radshow" name="radc" style="font-family:khmer os system;" value="-1" data-text="bin">Recycle Bin
							  </label>
							</div>
		     			</div>
		     			<div class="col-lg-6">
		     				<input type="text" id="myInput" class="myInput" onkeyup="autosearch()" placeholder="Search by name..." title="Type in a name">
		     			</div>
		     		</div>
		     		<div class="row">
			     		<table class="table table-hover table-bordered" id="tabledev">
			     			<thead style="background-color:#fff;">
			     				<tr>
			     					<th>No</th>
			     					<th>ID</th>
			     					<th>Name</th>
			     					<th>Tel</th>
			     					<th>Email</th>
			     					<th>Address</th>
			     					<th>Active</th>
			     					<th>Action</th>
			     				</tr>
			     			</thead>
			     			<tbody id="tbl_delivery" style="background-color:white;">
			     				@foreach ($deliveries as $key => $dev)
			     					<tr style="cursor:pointer;" class={{ $dev->active==1?"activecolor":"disactivecolor" }}>
			     						<td>{{ ++$key }}</td>
			     						<td>{{ $dev->id }}</td>
			     						<td style="font-family:khmer os system;">{{ $dev->name }}</td>
			     						<td>{{ $dev->tel }}</td>
			     						<td>{{ $dev->email }}</td>
			     						<td>{{ $dev->address }}</td>
			     						<td>{{ $dev->active }}</td>
			     						<td>
			     							<a href="" class="btn btn-warning btn-sm dev_edit" data-id="{{ $dev->id }}" data-name="{{ $dev->name }}" data-active="{{ $dev->active }}" data-tel="{{ $dev->tel }}" data-email="{{ $dev->email }}" data-address="{{ $dev->address }}" title="Edit"><i class="fa fa-pencil"></i></a>
			     							<a href="" class="btn btn-danger btn-sm dev_del" data-id="{{ $dev->id }}" data-name="{{ $dev->name }}" data-active="{{ $dev->active }}" title="remove"><i class="fa fa-trash"></i>
			     							</a>
			     							@if ($dev->active==-1)
			     								<a href="" class="btn btn-danger btn-sm dev_restore" data-id="{{ $dev->id }}" data-name="{{ $dev->name }}" data-active="{{ $dev->active }}" title="Restore"><i class="fa fa-reply"></i>
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
		    <div id="co" class="tab-pane fade">
		    	<div class="row">
			    	<div class="col-lg-4">
			    		<div class="panel panel-info">
					      	<div class="panel-heading">
					      		CO Law Set
					      	</div>
					      	<div class="panel-body">
					      		<form action="" id="frmlaw">
						      		<div class="form-group">
						      			<label for="co">CO Name</label>
						      			<input type="hidden" name="co_id" id="co_id">
						      			<input type="text" class="form-control" name="co_name" id="co_name">
						      		</div>
						      		
						      		<div class="form-group">
					                  <label for="tel">Tel:</label>
					                  <input type="text" class="form-control" placeholder="Telephone" name="co_tel" id="co_tel">
					                </div>
					                <div class="form-group">
					                  <label for="email">Email:</label>
					                  <input type="email" class="form-control" placeholder="Email" name="co_email" id="co_email" autocomplete="off">
					                </div>
					                <label for="active">Active</label>
				     				<select name="co_active" id="co_active" class="form-control" style="height:40px;">
				     					<option value="1">Active</option>
				     					<option value="0">Disactive</option>
				     				</select>
					                 <div class="form-group">
					                  <label for="Address">Address:</label>
					                  <textarea name="co_address" id="co_address" class="form-control" cols="30" rows="5"></textarea>
					                </div>
				                </form>
					      	</div>

					      	<div class="panel-footer" style="">
					      		<button class="btn btn-default" id="btnnewco">Add New</button>
					      		<button class="btn btn-info pull-right" id="btnsaveco">Save</button>
					      	</div>
					    </div>
			    	</div>
			    	<div class="col-lg-8">
			    		<div class="row">
			     			<div class="col-lg-6" style="background-color:#ccc;border-radius:25px;padding:5px;height:34px;">
			     				<div class="form-check" style="display:inline;padding-right:5px;">
								  <label class="form-check-label" style="color:blue;font-weight:bold;">
								    <input type="radio" class="form-check-input radshow1" name="radc1" style="font-family:khmer os system;" checked value="1" data-text="Active">Active
								  </label>
								</div>
								<div class="form-check" style="display:inline;padding-right:5px;">
								  <label class="form-check-label" style="color:rgb(255, 80, 71);font-weight:bold;">
								    <input type="radio" class="form-check-input radshow1" name="radc1" style="font-family:khmer os system;" value="0" data-text="Disactive">Disactive
								  </label>
								</div>
								<div class="form-check" style="display:inline;">
								  <label class="form-check-label" style="color:black;font-weight:bold;">
								    <input type="radio" class="form-check-input radshow1" name="radc1" style="font-family:khmer os system;" value="2" data-text="All">All
								  </label>
								</div>
								&nbsp;&nbsp;
								<div class="form-check" style="display:inline;">
								  <label class="form-check-label" style="color:red;font-weight:bold;">
								    <input type="radio" class="form-check-input radshow1" name="radc1" style="font-family:khmer os system;" value="-1" data-text="bin">Recycle Bin
								  </label>
								</div>
			     			</div>
			     			<div class="col-lg-6">
			     				<input type="text" id="myInput1" class="myInput" onkeyup="autosearch1()" placeholder="Search by name..." title="Type in a name">
			     			</div>
		     			</div>
		     			<div class="row">
		     				<table class="table table-bordered table-hover" id="table_law">
				    			<thead style="background-color:#ddd;">
				    				<tr>
				    					<th class="text-center">No</th>
				    					<th class="text-center">ID</th>
				    					<th class="text-center" style="cursor:pointer;" onclick="sortTable(2)">Name <i class="fa fa-sort-amount-asc"></i></th>
				    					<th>Tel</th>
				    					<th>Email</th>
				    					<th>Address</th>
				    					<th class="text-center">Action</th>
				    				</tr>
				    			</thead>
				    			<tbody style="background-color:#fff;text-align:center;" id="tbl_law">
				    				@foreach ($laws as $key => $law)
				    					<tr class={{ $law->active==1?"activecolor":"disactivecolor" }}>
					    					<td>{{ ++$key }}</td>
					    					<td>{{ $law->id }}</td>
					    					<td style="font-family:khmer os system;">{{ $law->name }}</td>
					    					<td>{{ $law->tel }}</td>
					    					<td>{{ $law->email }}</td>
					    					<td>{{ $law->address }}</td>
					    					<td>
					    						<a href="" class="btn btn-warning btn-sm co-edit" data-id="{{ $law->id }}" data-name="{{ $law->name }}" data-tel="{{ $law->tel }}" data-email="{{ $law->email }}" data-address="{{ $law->address }}"><i class="fa fa-pencil"></i></a>
					    						<a href="" class="btn btn-danger btn-sm co-delete" data-id="{{ $law->id }}" data-name="{{ $law->name }}" data-active="{{ $law->active }}"><i class="fa fa-trash"></i></a>
					    						@if ($law->active==-1)
													<a href="" class="btn btn-danger btn-sm co-restore" data-id="{{ $law->id }}" data-name="{{ $law->name }}" data-active="{{ $law->active }}"><i class="fa fa-replay"></i></a>
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
		    
	</div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	<script>
			
			$(document).on('click','#btnsavedev',function(e){
				if($('#dev_id').val()==''){
					var url="{{ route('savedelivery') }}";
				}else{
					var url="{{ route('updatedelivery') }}";
				}
				var deliveryid=$('#dev_id').val();
				var data=$('#frmdelivery').serialize();
				$.post(url,data,function(data){
					if($.isEmptyObject(data.error)){
	                        getdelivery(val_radio);
	                        if(deliveryid != ''){
	                        	if(foundkeysearch==true){
	                        		$('#myInput').val($('#dev_name').val());
	                        		autosearch();
	                        	}
	                        }
	                       
	                        
	                        $('#dev_name').val('');
	                        $('#dev_id').val('');
	                        $('#emial').val('');
	                        $('#tel').val('');
	                        $('#address').text('');
	                        $('#dev_name').focus();
	                        $('#btnsavedev').text('Save');
	                    }else{
	                        alert(data.error);
	                    }
				})
			})
			
			function getdelivery(active) {
				var url="{{ route('getdelivery') }}";
				$.get(url,{active:active},function(data){
					$('#tbl_delivery').empty().html(data);
				})
			}
			
			$(document).on('click','.dev_edit',function(e){
				e.preventDefault();
				var id=$(this).data('id');
				var name=$(this).data('name');
				var tel=$(this).data('tel');
				var email=$(this).data('email');
				var address=$(this).data('address')
				var active=$(this).data('active');
				$('#dev_id').val(id);
				$('#dev_name').val(name);
				$('#tel').val(tel);
				$('#email').val(email);
				$('#address').val(address);
				$('#dev_active').val(active);
				$('#btnsavedev').text('Update');
			})
			$(document).on('click','.dev_del',function(e){
				e.preventDefault();
				var name=$(this).data('name');
				var c=confirm('Do you want to remove this delivery <'+ name +'> ?');
				if(c==true){
					var url="{{ route('deldelivery') }}";
					var id=$(this).data('id');
					var active=$(this).data('active');
					$.post(url,{id:id,active:active},function(data){
						getdelivery(val_radio);
					})
				}
			})
			
			$(document).on('click','.dev_restore',function(e){
				e.preventDefault();
				var name=$(this).data('name');
				var c=confirm('Do you want to restore this delivery <'+ name +'> ?');
				if(c==true){
					var url="{{ route('restoredelivery') }}";
					var id=$(this).data('id');
					$.post(url,{id:id},function(data){
						getdelivery(val_radio);
					})
				}
			})
			
			$(document).on('click','#btnnewdev',function(e){
				$('#btnsavedev').text('Save');
				$('#dev_id').val('');
				$('#dev_name').val('');
				$('#dev_active').val(1);
				$('#tel').val('');
				$('#email').val('');
				$('#address').val('');
				$('#dev_name').focus();
			})
			var val_radio='1';
			$(document).on('change','.radshow',function(e){
				e.preventDefault();
				foundkeysearch=false;
				val_radio=$(this).val();
				getdelivery(val_radio);
			})
			//----------CO function-----------------
			$(document).on('click','#btnsaveco',function(e){
				if($('#co_id').val()==''){
					var url="{{ route('saveco') }}";
				}else{
					var url="{{ route('updateco') }}";
				}
				var coid=$('#co_id').val();
				var data=$('#frmlaw').serialize();
				$.post(url,data,function(data){
					if($.isEmptyObject(data.error)){
	                        getco(val_radio1);
	                        if(coid != ''){
	                        	if(foundkeysearch1==true){
	                        		$('#myInput1').val($('#co_name').val());
	                        		autosearch1();
	                        	}
	                        }
	                       
	                        
	                        $('#co_name').val('');
	                        $('#co_id').val('');
	                        $('#co_emial').val('');
	                        $('#co_tel').val('');
	                        $('#co_address').text('');
	                        $('#co_name').focus();
	                        $('#btnsaveco').text('Save');
	                    }else{
	                        alert(data.error);
	                    }
				})
			})
			
			function getco(active) {
				var url="{{ route('getco') }}";
				$.get(url,{active:active},function(data){
					$('#tbl_law').empty().html(data);
				})
			}
			
			$(document).on('click','.co-edit',function(e){
				e.preventDefault();
				var id=$(this).data('id');
				var name=$(this).data('name');
				var tel=$(this).data('tel');
				var email=$(this).data('email');
				var address=$(this).data('address')
				var active=$(this).data('active');
				$('#co_id').val(id);
				$('#co_name').val(name);
				$('#co_tel').val(tel);
				$('#co_email').val(email);
				$('#co_address').val(address);
				$('#co_active').val(active);
				$('#btnsaveco').text('Update');
			})
			$(document).on('click','.co-delete',function(e){
				e.preventDefault();
				var name=$(this).data('name');
				var c=confirm('Do you want to remove CO <' + name + '> ?');
				if(c==true){
					var url="{{ route('delco') }}";
					var id=$(this).data('id');
					var active=$(this).data('active');
					$.post(url,{id:id,active:active},function(data){
						getco(val_radio1);
					})
				}
			})
			
			$(document).on('click','.co-restore',function(e){
				e.preventDefault();
				var name=$(this).data('name');
				var c=confirm('Do you want to restore CO <' + name + '> ?');
				if(c==true){
					var url="{{ route('restoreco') }}";
					var id=$(this).data('id');
					$.post(url,{id:id},function(data){
						getco(val_radio1);
					})
				}
			})
			
			$(document).on('click','#btnnewco',function(e){
				$('#btnsaveco').text('Save');
				$('#co_id').val('');
				$('#co_name').val('');
				$('#co_active').val(1);
				$('#co_tel').val('');
				$('#co_email').val('');
				$('#co_address').val('');
				$('#co_name').focus();
			})
			var val_radio1='1';
			$(document).on('change','.radshow1',function(e){
				e.preventDefault();
				foundkeysearch1=false;
				val_radio1=$(this).val();
				getco(val_radio1);
			})
			
			//------------------------------------
			function sortTable(n) {
			  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			  table = document.getElementById("table_law");
			  switching = true;
			  //Set the sorting direction to ascending:
			  dir = "asc"; 
			  /*Make a loop that will continue until
			  no switching has been done:*/
			  while (switching) {
			    //start by saying: no switching is done:
			    switching = false;
			    rows = table.rows;
			    /*Loop through all table rows (except the
			    first, which contains table headers):*/
			    for (i = 1; i < (rows.length - 1); i++) {
			      //start by saying there should be no switching:
			      shouldSwitch = false;
			      /*Get the two elements you want to compare,
			      one from current row and one from the next:*/
			      x = rows[i].getElementsByTagName("TD")[n];
			      y = rows[i + 1].getElementsByTagName("TD")[n];
			      /*check if the two rows should switch place,
			      based on the direction, asc or desc:*/
			      if (dir == "asc") {
			        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			          //if so, mark as a switch and break the loop:
			          shouldSwitch= true;
			          break;
			        }
			      } else if (dir == "desc") {
			        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
			          //if so, mark as a switch and break the loop:
			          shouldSwitch = true;
			          break;
			        }
			      }
			    }
			    if (shouldSwitch) {
			      /*If a switch has been marked, make the switch
			      and mark that a switch has been done:*/
			      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			      switching = true;
			      //Each time a switch is done, increase this count by 1:
			      switchcount ++;      
			    } else {
			      /*If no switching has been done AND the direction is "asc",
			      set the direction to "desc" and run the while loop again.*/
			      if (switchcount == 0 && dir == "asc") {
			        dir = "desc";
			        switching = true;
			      }
			    }
			  }
			}
			var foundkeysearch='false';
			function autosearch() {
				 foundkeysearch='true';
				  var input, filter, table, tr, td, i, txtValue;
				  input = document.getElementById("myInput");
				  filter = input.value.toUpperCase();
				  table = document.getElementById("tabledev");
				  tr = table.getElementsByTagName("tr");
				  for (i = 0; i < tr.length; i++) {
				    td = tr[i].getElementsByTagName("td")[2];
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

			var foundkeysearch1='false';
			function autosearch1() {
				 foundkeysearch1='true';
				  var input, filter, table, tr, td, i, txtValue;
				  input = document.getElementById("myInput1");
				  filter = input.value.toUpperCase();
				  table = document.getElementById("table_law");
				  tr = table.getElementsByTagName("tr");
				  for (i = 0; i < tr.length; i++) {
				    td = tr[i].getElementsByTagName("td")[2];
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