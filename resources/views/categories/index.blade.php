
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
	</style>
@endsection

@section('content')
	<div class="container-fluid" style="margin-top:-20px;margin-left:20px;">
  		  <h2>Category Set</h2>

		  <ul class="nav nav-tabs border-info">
		    <li class="active"><a data-toggle="tab" href="#home">Category</a></li>
		    <li><a data-toggle="tab" href="#unit">Items Unit</a></li>
		    
		  </ul>

		  <div class="tab-content">
		    <div id="home" class="tab-pane fade in active">
		     <div class="row">
		     	<div class="col-lg-4" style="">
		     		<div class="panel panel-default">
		     			<div class="panel-heading">
		     				Category Set
		     			</div>
		     			<div class="panel-body">
		     				<form action="" id="frmcategory">
		     					<input type="hidden" id="cat_id" name="cat_id">
		     					<label for="catname">Category</label>
			     				<input type="text" class="form-control autocomplete_category" name="cat_name" id="cat_name" style="height:40px;font-family:khmer os system;">
			     				<label for="active">Active</label>
			     				<select name="cat_active" id="cat_active" class="form-control" style="height:40px;">
			     					<option value="1">Active</option>
			     					<option value="0">Disactive</option>
			     				</select>
		     				</form>
		     				
		     			</div>
		     			<div class="panel-footer" style="height:50px;">
		     				<button class="btn btn-default" id="btnnewcat">Add New</button>
		     				<button class="btn btn-info pull-right" id="btnsavecategory">Save Category</button>
		     			</div>
		     		</div>
		     		<div class="input-group">
					    <input type="text" class="form-control" placeholder="Search" name="cat_search" id="cat_search" style="font-family:khmer os system;height:40px;">
					    <div class="input-group-btn">
					      <button class="btn btn-default" id="searchcat" style="height:40px;">
					        <i class="fa fa-search"></i>
					      </button>
					    </div>
					  </div>
		     		<table class="table table-hover table-bordered" id="tablecat">
		     			<thead style="background-color:#fff;">
		     				<tr>
		     					<th>No</th>
		     					<th>CatID</th>
		     					<th>Category Name</th>
		     					<th>Active</th>
		     					<th>Action</th>
		     				</tr>
		     			</thead>
		     			<tbody id="tbl_category" style="background-color:white;">
		     				@foreach ($categories as $key => $cat)
		     					<tr style="cursor:pointer;">
		     						<td>{{ ++$key }}</td>
		     						<td>{{ $cat->id }}</td>
		     						<td style="font-family:khmer os system;">{{ $cat->name }}</td>
		     						<td>{{ $cat->active }}</td>
		     						<td>
		     							<a href="" class="btn btn-warning cate_edit" data-id="{{ $cat->id }}" data-name="{{ $cat->name }}" data-active="{{ $cat->active }}">Edit</a>
		     							<a href="" class="btn btn-danger cate_del" data-id="{{ $cat->id }}" data-name="{{ $cat->name }}">Del
		     							</a>
		     						</td>
		     					</tr>
		     				@endforeach
		     			</tbody>
		     		</table>
		     	</div>

		     	<div class="col-lg-8">
		     		<div class="panel panel-default">
		     			<div class="panel-heading">
		     				Brand Set
		     			</div>
		     			<div class="panel-body">
		     				<form action="" id="frmbrand">
			     				<div class="col-lg-6">
			     					<label for="catid">Category ID</label>
			     					<input type="text" class="form-control" id="ctid" name="ctid" style="height:40px;" readonly>
			     					<label for="catname">Category Name</label>
			     					<select name="sel_cat" id="sel_cat" class="form-control" style="width:100%;height:40px;font-family:khmer os system;">
			     						<option value=""></option>
			     						@foreach ($categories as $cat)
			     							<option value="{{ $cat->id }}">{{ $cat->name }}</option>
			     						@endforeach
			     					</select>
			     				</div>
			     				<div class="col-lg-6">
			     					<label for="catname">Brand</label>
			     					<input type="hidden" id="br_id" name="br_id">
			     					<input type="text" class="form-control autocomplete_brand" name="brand_name" id="brand_name" style="height:40px;font-family:khmer os system;">
			     					<label for="active">Active</label>
				     				<select name="brand_active" id="brand_active" class="form-control" style="height:40px;">
				     					<option value="1">Active</option>
				     					<option value="0">Disactive</option>
				     				</select>
			     				</div>
		     				</form>
		     				
		     			</div>
		     			<div class="panel-footer" style="height:50px;">
		     				<button class="btn btn-default" id="btnnewbrand">Add New</button>
		     				<button class="btn btn-info pull-right" id="btnsavebrand">Save Brand</button>
		     			</div>
		     		</div>
		     		<div class="input-group">
					    <input type="text" class="form-control" placeholder="Search" name="brand_search" id="brand_search" style="font-family:khmer os system;height:40px;">
					    <div class="input-group-btn">
					      <button class="btn btn-default" id="searchbrand" style="height:40px;">
					        <i class="fa fa-search"></i>
					      </button>
					    </div>
					  </div>
		     		<table class="table table-hover table-bordered">
		     			<thead style="background-color:#fff;">
		     				<tr>
		     					<th>No</th>
		     					<th>BID</th>
		     					<th>Brand Name</th>
		     					<th>Category</th>
		     					<th>Active</th>
		     					<th>Action</th>
		     				</tr>
		     			</thead>
		     			<tbody id="tbl_brand" style="background-color:white;">
		     				
		     			</tbody>
		     		</table>
		     	</div>
		     </div>
		    </div>
		    <div id="unit" class="tab-pane fade">
		    	<div class="row">
			    	<div class="col-lg-4">
			    		<div class="panel panel-info">
					      	<div class="panel-heading">
					      		Unit Set
					      	</div>
					      	<div class="panel-body">
					      		<label for="unit">Unit Name</label>
					      		<input type="hidden" name="unitid" id="unitid">
					      		<input type="text" class="form-control" name="unitname" id="unitname" style="font-family:khmer os system;">
					      	</div>
					      	<div class="panel-footer" style="text-align:center;">
					      		<button class="btn btn-info" id="btnnewunit">New</button>
					      		<button class="btn btn-info" id="btnsaveunit">Save</button>
					      	</div>
					    </div>
			    	</div>
			    	<div class="col-lg-4">
			    		<table class="table table-bordered table-hover" id="myTable">
			    			<thead style="background-color:#ddd;">
			    				<tr>
			    					<th class="text-center">No</th>
			    					<th class="text-center">ID</th>
			    					<th class="text-center" style="cursor:pointer;" onclick="sortTable(2)">Name <i class="fa fa-sort-amount-asc"></i></th>
			    					<th class="text-center">Action</th>
			    				</tr>
			    			</thead>
			    			<tbody style="background-color:#fff;text-align:center;" id="tbl_unit">
			    				@foreach ($units as $key => $unit)
			    					<tr>
				    					<td>{{ ++$key }}</td>
				    					<td>{{ $unit->id }}</td>
				    					<td style="font-family:khmer os system;">{{ $unit->name }}</td>
				    					<td>
				    						<a href="" class="btn btn-warning btn-sm unit-edit" data-id="{{ $unit->id }}" data-name="{{ $unit->name }}"><i class="fa fa-pencil"></i></a>
				    						<a href="" class="btn btn-danger btn-sm unit-delete" data-id="{{ $unit->id }}" data-name="{{ $unit->name }}"><i class="fa fa-trash"></i></a>
				    						
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

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	<script>
			
			$('#sel_cat').select2();
			var path = "{{ route('autocomplete_category') }}";
		    $('input.autocomplete_category').typeahead({
		        source:  function (query, process) {
		        return $.get(path, { query: query }, function (data) {
		                return process(data);
		            });
		        }
		    })
		    var path = "{{ route('autocomplete_brand') }}";
		    $('input.autocomplete_brand').typeahead({
		        source:  function (query, process) {
		        return $.get(path, { query: query }, function (data) {
		                return process(data);
		            });
		        }
		    })
			//-----------------------------------
			$(document).on('click','#btnsavecategory',function(e){
				if($('#cat_id').val()==''){
					var url="{{ route('savecategory') }}";
				}else{
					var url="{{ route('updatecategory') }}";
				}
				
				var data=$('#frmcategory').serialize();
				$.post(url,data,function(data){
					if($.isEmptyObject(data.error)){
	                        getcategory();
	                        $('#cat_name').val('');
	                        $('#cat_id').val('');
	                        $('#cat_name').focus();
	                        $('#btnsavecategory').text('Save Category');
	                    }else{
	                        alert(data.error);
	                    }
				})
			})
			$(document).on('click','#btnsavebrand',function(e){
				if($('#br_id').val()==''){
					var url="{{ route('savebrand') }}";
				}else{
					var url="{{ route('updatebrand') }}";
				}
				
				var data=$('#frmbrand').serialize();
				$.post(url,data,function(data){
					if($.isEmptyObject(data.error)){
	                        getbrand();
	                        $('#brand_name').val('');
	                        $('#br_id').val('');
	                        $('#brand_name').focus();
	                        $('#btnsavebrand').text('Save Brand');
	                    }else{
	                        alert(data.error);
	                    }
				})
			})
			function getcategory() {
				var url="{{ route('getcategory') }}";
				$('#sel_cat').empty();
				$.get(url,{a:'a'},function(data){
					$('#tbl_category').empty().html(data.table_data);
					$.each(data.cat_data,function(i,item){
		   				$('#sel_cat').append($("<option/>",{
								value:item.id,
								text:item.name
							}))
		   				
		   			});
				})
			}
			function getbrand() {
				var url="{{ route('getbrand') }}";
				var id=$('#ctid').val();
				$.get(url,{catid:id},function(data){
					$('#tbl_brand').empty().html(data);
				})
			}
			$(document).on('click','.cate_edit',function(e){
				e.preventDefault();
				var id=$(this).data('id');
				var name=$(this).data('name');
				var active=$(this).data('active');
				$('#cat_id').val(id);
				$('#cat_name').val(name);
				$('#cat_active').val(active);
				$('#btnsavecategory').text('Update Category');
			})
			$(document).on('click','.cate_del',function(e){
				e.preventDefault();
				var c=confirm('Do you want to remove this category?');
				if(c==true){
					var url="{{ route('delcategory') }}";
					var id=$(this).data('id');
					$.post(url,{id:id},function(data){
						getcategory();
					})
				}
			})
			$(document).on('click','.brand_del',function(e){
				e.preventDefault();
				var c=confirm('Do you want to remove this brand?');
				if(c==true){
					var url="{{ route('delbrand') }}";
					var id=$(this).data('id');
					$.post(url,{id:id},function(data){
						getbrand();
					})
				}
			})
			$(document).on('click','.brand_edit',function(e){
				e.preventDefault();

				var id=$(this).data('id');
				var name=$(this).data('name');
				var active=$(this).data('active');
				var catid=$(this).data('catid');
				var catname=$(this).data('catname');
				
				$('#br_id').val(id);
				$('#brand_name').val(name);
				$('#brand_active').val(active);
				//$('#ctid').val(catid);
				 $('#sel_cat').val(catid);
				 $('#sel_cat').select2().trigger('change');
				$('#btnsavebrand').text('Update Brand');
				

			})
			
			$(document).on('click','#btnnewcat',function(e){
				$('#btnsavecategory').text('Save Category');
				$('#cat_id').val('');
				$('#cat_name').val('');
				$('#cat_active').val(1);
			})
			$(document).on('click','#btnnewbrand',function(e){
				$('#br_id').val('');
				$('#btnsavebrand').text('Save Brand');
				$('#brand_name').val('');
				$('#brand_name').focus();
			})
		    $(document).on('keydown','#cat_search',function(e){
	 	
			 	if (e.keyCode == 13) {
			 		searchcategory($(this).val());
			 		e.preventDefault();
			 	}
			 })
			function searchcategory(q) {
				var url="{{ route('categorysearch') }}";
				$.get(url,{q:q},function(data){
					//console.log(data)
					$('#tbl_category').empty().html(data);
				})
			}
			$(document).on('click','#searchcat',function(e){
				e.preventDefault();
				var q=$('#cat_search').val();
				searchcategory(q);
			})

			$(document).on('keydown','#brand_search',function(e){
	 	
			 	if (e.keyCode == 13) {
			 		searchbrand($(this).val());
			 		e.preventDefault();
			 	}
			 })
			function searchbrand(q) {
				var url="{{ route('brandsearch') }}";
				$.get(url,{q:q},function(data){
					//console.log(data)
					$('#tbl_brand').empty().html(data);
				})
			}
			$(document).on('click','#searchbrand',function(e){
				e.preventDefault();
				var q=$('#brand_search').val();
				searchbrand(q);
			})
			 $("#tablecat tbody").on('click', 'tr td:not(:last-child)', function () {
			 	  var row = $(this).closest('tr');
				  var id=row.find("td:eq(1)").text();
				  var name=row.find("td:eq(2)").text();
				  $('#sel_cat').val(id);
				  $('#sel_cat').select2().trigger('change');
				  var url="{{ route('getbrand') }}";
				  $.get(url,{catid:id},function(data){
				  	$('#tbl_brand').empty().html(data);
				  })
				  $('#br_id').val('');
				  $('#btnsavebrand').text('Save Brand');
				  $('#brand_name').val('');
				  $('#brand_name').focus();

		    });
			$(document).on('change','#sel_cat',function(e){
				var catid=$(this).val();
				$('#ctid').val(catid);
				 
			})
			$(document).on('click','#btnsaveunit',function(e){
				var uname=$('#unitname').val();
				if(uname==''){
					alert('please input unit name')
				}else{
					var id=$('#unitid').val();
					if(id==''){
						var url="{{ route('saveunit') }}"
						$.post(url,{uname:uname},function(data){
							getunit();
							$('#unitname').val('');
							$('#unitname').focus();
						})
					}else{
						var url="{{ route('updateunit') }}"
						$.post(url,{id:id,uname:uname},function(data){
							getunit();
							$('#unitid').val('');
							$('#unitname').val('');
							$('#btnsaveunit').text('Save');
							$('#unitname').focus();
						})
					}
					
				}
			})
			$(document).on('click','.unit-edit',function(e){
				e.preventDefault();
				var id=$(this).data('id');
				var name=$(this).data('name');
				$('#unitid').val(id);
				$('#unitname').val(name);
				$('#btnsaveunit').text('Update');
			})
			$(document).on('click','.unit-delete',function(e){
				e.preventDefault();
				var c=confirm('Do you want to remove this unit?');
				if(c==true){
					var id=$(this).data('id');
					var url="{{ route('deleteunit') }}";
					$.post(url,{id:id},function(e){
						getunit();
					})
				}
				
			})
			$(document).on('click','#btnnewunit',function(e){
				$('#unitid').val('');
				$('#unitname').val('');
				$('#btnsaveunit').text('Save');
				$('#unitname').focus();
			})
			function getunit() {
				var url="{{ route('getunit') }}";
				$.get(url,{},function(data){
					$('#tbl_unit').empty().html(data);
				})
			}
			//------------------------------------
			function sortTable(n) {
			  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			  table = document.getElementById("myTable");
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
		
	</script>
@endsection