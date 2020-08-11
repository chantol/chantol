@extends('layouts.master')
@section('css')

	<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style type="text/css">
		label{
			font-family:"daunpenh";
			font-size:28px;
			padding-top:5px;
		}
		input,select,button,textarea,td{
			font-family:"Khmer OS System";

		}
		button.en{
			font-family:"Time New Romain";
		}
		
	</style>

@endsection
@section('content')
	<div class="row" style="margin-left:15px;">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="page-header"><i class="fa fa-file-text-o"></i>Products List</h3>
				<ol class="breadcrumb">
					<li><i class="icon_document_alt"></i><a href="{{ route('createproduct') }}">Create Product</a></li>
					
				</ol>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			
			<table id="tbl_product" class="table table-hover table-striped table-bordered table-sm tbl_product" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Image</th>
						<th>Product Code</th>
						<th>Product Name</th>
						<th>Category</th>
						<th>Brand</th>
						<th>Stock</th>
						<th>Unit</th>
						<th>Status</th>
						<th>Description</th>
						<th>Created At</th>
						<th>Updated At</th>
						<th>Action</th>

					</tr>
				</thead>
					
				<tbody>
					
				</tbody>
		</table>

		</div>
		
	</div>	
	@include('products.confirmdelete1')
	@include('modal.viewsoldeprice_modal')
@endsection
@section('script')
 	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.tbl_product').DataTable({
		        processing: true,
		        serverSide: true,
		        ajax:{
		        	url:"{{ route('showallproduct') }}",
		        },
		        columns: [
		        	 {data:'rank',name:'rank'},

		       		{
		       			data:'image',
		       			name:'image',
		       			render:function(data,type,full,meta){
		       				return "<img src={{ asset('photo/')}}/"+data+ " width=60px; height=60px; class='img-thumbnail' />"
		       			},
		       			orderable:false
		       		},
		            
		            {data: 'code', name: 'code'},
		            {data: 'name', name: 'name'},
		            {data:'categoryname',name:'categoryname'},
		            {data:'brandname',name:'brandname'},
		            {data:'stock',name:'stock'},
		            {data:'itemunit',name:'itemunit'},
		            {data:'status',name:'status'},
		            {data:'description',name:'description'},
		            {data:'created_at',name:'created_at'},
		            {data:'updated_at',name:'updated_at'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
		    });

			var pr_id='';
		    $(document).on('click','.remove',function(e){
		    	e.preventDefault();
		    	pr_id=$(this).data('id');
		    	$('#modalConfirmDelete').modal('show');
		    })
		     $("#btn_delete").click(function(){
		    	
		    	 $.ajax({
			            type:"POST",
			            url:"{{ route('productdestroy') }}",
			            data:{id:pr_id},
			            
			            success:function(data){
			             
			              $("#btn_closeconfirm").click();
			             
			              console.log(data);
			              location.reload();
			            }
			          });
		    })

		    $(document).on('click','.showbarcode',function(e){
		    	e.preventDefault();
		    	var pid=$(this).data('id');
		    	var pcode=$(this).data('code');
		    	var pname=$(this).data('name');
		    	$('#modal_pid').text('ID:' + pid);
		    	$('#modal_code').text('Code:' + pcode);
		    	$('#modal_name').text('Name:' + pname);
		    	var url="{{ route('viewbarcode') }}"
		    	$.get(url,{id:pid},function(data){
		    		//console.log(data)

		    		$('#ViewSoldPrice').modal('show');
		    		
		    		
		    		$('#productbarcode').empty().html(data);
		    	})
		    	
		    })

		});

		
</script>
@endsection