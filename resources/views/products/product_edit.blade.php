@extends('layouts.master')
@section('pagetitle')
	Product Edit
@endsection
@section('css')
	<link href="{{ asset('css') }}/jquery.datetimepicker.min.css" rel="stylesheet">
	<style type="text/css">
		.student-photo{
			height:250px;
			padding-left:1px;
			padding-right:1px;
			border:1px solid #ccc;
			background:#eee;
			width:240px;
			margin:0 auto;
			
		}
		.photo > input[type='file']{
			display:none;
		}
		.photo{
			width:30px;
			height:30px;
			border-radius:100%;
		}
		.student-id{

			background-repeat:repeat-x;
			border-color:#ccc;
			padding:1px;
			text-align:center;
			background:#eee;
			border-bottom:1px solid #ccc;
		}
		.btn-browse{
			border-color:#ccc;
			padding:1px;
			text-align:center;
			background:#eee;
			border:none;
			border-top:1px solid #ccc;
			height:25px;
		}
		fieldset{
			margin-top:0px;
		}
		fieldset legend{
			display:block;
			width:100%;
			padding:0;
			font-size:15px;
			line-height:inherit;
			color:#797979;
			border:0;
			border-bottom:1px solid #e5e5e5;
		}

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

	
	{{-- ---------------------- --}}
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa-pen"></i>Product Edit</h3>
			
		</div>
	</div>
	
	{{-- -------------------------- --}}
	<div class="row">

		<div class="col-lg-12">
	@include('message')
	<form action="{{ route('productupdate1') }}" method="POST" id="frm_edit_product" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
		
		
			<div class="col-lg-6 col-md-6 col-sm-6">
				<div class="row">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<b><i class="fa fa-apple"></i>Product Setup</b>

						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-8">
									<div class="row">
										<div class="col-lg-6">
											<label for="category">ក្រុមទំនិញ/Category</label>
											<div class="input-group">
												<select class="form-control" name="sel_category" id="sel_category" style="height:50px;">
													
													@foreach ($categories as $y)
														<option value="{{ $y->id }}" {{ $product->category_id==$y->id ? 'selected' : '' }}>{{ $y->name }}</option>
													@endforeach
												</select>
												<div class="input-group-addon btn btn-default" id="add_category">
													<span class="fa fa-plus" ></span>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
										<label for="category">ម៉ាក/Brand</label>
											<div class="input-group">
												<select class="form-control" name="sel_brand" id="sel_brand"​ style="height:50px;">
													
													@foreach ($brands as $b)
														<option value="{{ $b->id }}" {{ $product->brand_id==$b->id ? 'selected' : '' }}>{{ $b->name }}</option>
													@endforeach
												</select>
												<div class="input-group-addon btn btn-default" id="add_brand">
													<span class="fa fa-plus" ></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">	
										<div class="col-lg-12">
											<div class="form-group">
												<label for="productcode">លេខកូដទំនិញ/Product Code</label>
												<input type="text" name="productcode" id="productcode" class="form-control" style="height:50px;" placeholder="លេខកូដទំនិញ" value="{{ $product->code }}" required>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="form-group">
												<label for="nationalcard">ឈ្មោះទំនិញ/Product Name</label>
												<input type="text" name="productname" id="productname" class="form-control"​ style="height:50px;" placeholder="ឈ្មោះទំនិញ" value="{{ $product->name }}" required>
											</div>
										</div>	
										<div class="col-lg-12">	
											<div class="form-group">
												<label for="unit">ឯកតារាយ</label>
												<div class="input-group">
													<select class="form-control" style="height:40px;font-family:khmer os system;" name="selunit" id="selunit"​>
														@foreach ($units as $u)
															<option value="{{ $u->name }}" {{ $product->itemunit==$u->name?'selected':'' }}>{{ $u->name }}</option>
														@endforeach
													</select>
													<div class="input-group-addon btn btn-default" id="add_unit">
														<span class="fa fa-plus" ></span>
													</div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="col lg-3" style="margin-top:30px;">
									<div class="form-group form-group-login">
										<table style="margin:0 auto;">
											<thead>
												<tr class="info">
													<th class="student-id">PID:<input type="text" name="product_id" id="product_id" value="{{ $product->id }}" readonly style="text-align:center;"></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="photo">
														@if ($product->image)
															<img src="{{ asset('photo'.'/'.$product->image) }}" alt="" class="student-photo" id="showPhoto">
														@else
															{!! Html::image('logo/NoPicture.jpg',null,['class'=>'student-photo','id'=>'showPhoto']) !!}
														@endif
														
														
														<input type="file" name="photo" id="photo" accept="image/x-png,image/png,image/jpg,image/jpeg,image/webp">
													</td>
												</tr>
												<tr>
													<td style="text-align:center;background:#ddd;">
														<button type="button" name="browse_file" id="browse_file" class="btn btn-info btn-browse en" value="Browse"​ style="width:100%;color:blue;">Browse</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="description">ផ្សេងៗ/Description</label>
										<textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
									</div>
								</div>	
							</div>
						</div>
						
					</div>
					
				</div>
				
			</div>
			{{-- ------------------------- --}}
			<div class="col-lg-6 col-md-6 col-sm-6">
				<div class="row">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<b><i class="fa fa-apple"></i>Product Barcode</b>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="form-group">
									<table class="table table-bordered">

										<thead>
											<th style="width:60px;text-align:center;">No</th>
											<th style="width:200px;text-align:center;">Barcode</th>
											<th style="width:200px;text-align:center;">Unit</th>
											<th style="width:200px;text-align:center;">Price</th>
											<th style="width:100px;text-align:center;">Cur</th>
											<th style="width:150px;text-align:center;">Multi</th>
											<th style="text-align:center;"><a href="#" class="btn btn-info addrow"  style="border-radius:15px;"><i class="fa fa-plus"></i></a></th>
										</thead>
										<tbody id="tbl_barcode">
											@foreach ($prcode as $key => $pb)
												<tr>
													<td class="no" style="text-align:center;padding-top:15px;">
														{{ ++$key }}
													</td>
													<td>
														<input type="text" class="form-control barcode" name="barcode[]" value="{{ $pb->barcode }}" style="height:40px;" required>
													</td>
													
													<td>
														<select class="form-control unit" style="height:40px;" name="unit[]" id="unit0" required>
															@foreach ($units as $u)
																<option value="{{ $u->name }}" {{ $pb->unit==$u->name?'selected':'' }}>{{ $u->name }}</option>
															@endforeach
														</select>
													</td>
													<td><input type="text" class="form-control price" name="price[]" style="height:40px;" 
														value="{{ $pb->cur=='$'? number_format($pb->price,2,'.',','):number_format($pb->price) }}" required>
													</td>
													<td>
														<select name="cur[]" class="form-control" style="height:40px;">
															<option value="R" {{ $pb->cur=='R' ? 'selected' : '' }}>R</option>
															<option value="B" {{ $pb->cur=='B' ? 'selected' : '' }}>B</option>
															<option value="$" {{ $pb->cur=='$' ? 'selected' : '' }}>$</option>

														</select>
													</td>
													<td>
														<input type="text" class="form-control multi" name="multi[]" style="height:40px;" value="{{ $pb->multiple }}" required>
													</td>
													<td>
														<a href="#" class="btn btn-danger remove" style="border-radius:15px;margin-top:5px;"><i class="fa fa-minus"></i></a>
													</td>
												</tr>
											@endforeach
											
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
						<div class="panel-footer" style="background:white;height:55px;">
							<button type="submit" class="btn btn-warning btn-save pull-right" style="color:black;"><i class="fa fa-save"></i> &nbsp;Update Info</button>
						</div>
						
						  
						  <div class="panel panel-default">
						    <div class="panel-heading">Old Information</div>
						    <div class="panel-body">
								<table class="table table-bordered">
									<tr><th>Product Code</th><td>{{ $product->code }}</td></tr>
									<tr><th>Product Name</th><td>{{ $product->name }}</td></tr>
									<tr><th>Category</th><td>{{ $product->category->name }}</td></tr>
									<tr><th>Brand</th><td>{{ $product->brand->name }}</td></tr>
									<tr><th>Stock</th><td>{{ $product->stock }}</td></tr>
									<tr><th>Unit</th><td>{{ $product->itemunit }}</td></tr>
									<tr><th>Stock Cost</th><td>${{ $product->costprice }}</td></tr>
									<tr><th>Total</th><td>${{ number_format($product->stock * $product->costprice,2,'.',',') }}</td></tr>
									
									
									
								</table>
						    </div>
						  </div>
						
					</div>
					
				</div>
			</div>	
		
		
	</form>
	</div>
	</div>
	@include('modal.category_modal')		
	@include('modal.brand_modal')@include('products.confirmdelete')
	
@endsection

@section('script')
	<script src="{{ asset('js') }}/jquery.datetimepicker.full.js"></script>
	<script type="text/javascript">
			
		
	// add category
		$('#add_category').on('click',function(){
			
			$('#category_modal').modal('show');
			$('#category_name').val('');
		});
		$('.btn_save_category').on('click',function(){
				var cat_name=$('#category_name').val();
				$.post("{{ route('postcategory') }}",{name:cat_name},function(data){
					$('#sel_category').append($("<option/>",{
						value:data.id,
						text:data.name
					}))
					$('#category_modal').modal('hide');
					
				})
			});
	// end category
	//add brand
		$('#add_brand').on('click',function(){
			
			$('#brand_modal').modal('show');
			$('#brand_name').val('');
		});
		$('.btn_save_brand').on('click',function(){
				var b_name=$('#brand_name').val();
				$.post("{{ route('postbrand') }}",{name:b_name},function(data){
					$('#sel_brand').append($("<option/>",{
						value:data.id,
						text:data.name
					}))
					$('#brand_modal').modal('hide');
					
				})
			});
	//-----------------------------------------		
		$('.btn-browse').on('click',function(){
			$('#photo').click();
		})
		$('#photo').on('change',function(e){
			showFile(this,'#showPhoto');
		})
		function showFile(fileInput,img,showName){
			if(fileInput.files[0]){
				var reader=new FileReader();
				reader.onload=function(e){
					$(img).attr('src',e.target.result);
				}
				reader.readAsDataURL(fileInput.files[0]);
			}
			$(showName).text(fileInput.files[0].name);
		}

		function showFile1(fileInput,img,showName){
			if(fileInput.files[0]){
				var reader=new FileReader();
				reader.onload=function(e){
					$(img).attr('src',e.target.result);
				}
				reader.readAsDataURL(fileInput.files[0]);
			}
			$(showName).text(fileInput.files[0].name);
		}

	//-----------------------------------------
	// delete product
      var pr_id;
      $(document).on('click','.btn-delete',function(e){
        e.preventDefault();
        pr_id=$(this).data('id');//or =$(this).attr('id');
        $("#modalConfirmDelete").modal('show');
      });
      $("#btn_delete").click(function(){
         $.ajax({
            type:"POST",
            url:"{{ route('productdestroy') }}",
            data:{id:pr_id},
            beforeSend:function(){
              $("#btn_delete").text('Delete...');
            },
            
            success:function(data){
              // setTimeout(function(){
              //    $("#modalConfirmDelete").modal('show');
              // },2000);
              $("#btn_closeconfirm").click();
              $("#btn_delete").text('Delete');
              console.log(data);
              location.reload();
            }
          });
      });
	//product barcode
	$('.addrow').on('click',function(){
		AddRow();
		ResetNo();
	});
	function AddRow(){
		var nn=$('#tbl_barcode tr').length+1;
		let tst = Math.round(Date.now() / 1000)+nn;
		var row='<tr>'+
				'<td class="no" style="text-align:center;padding-top:15px;">'+
				
				'</td>'+
				'<td>'+
					'<input type="text" class="form-control barcode" name="barcode[]" required style="height:40px;">'+
				'</td>'+
				'<td>'+
				'<select class="form-control unit" style="height:40px;" name="unit[]" id="unit'+ tst +'" title="'+ tst +'" required>'+
					
				'</select>'+
				'</td>'+
				'<td><input type="text" class="form-control price" name="price[]" required style="height:40px;text-align:right;">'+
				'</td>'+
				'<td>'+
					'<select name="cur[]" class="form-control" style="height:40px;">'+
						'<option value="R">R</option>'+
						'<option value="B">B</option>'+
						'<option value="$">$</option>'+

					'</select>'+
				'</td>'+
				'<td><input type="text" class="form-control multi" name="multi[]" required style="height:40px;">'+
				'</td>'+
				'<td>'+
					'<a href="#" class="btn btn-danger remove" style="border-radius:15px;"><i class="fa fa-minus"></i></a>'+
				'</td>'+
			'</tr>';
				$('#tbl_barcode').append(row);
				//$('.unit option').remove();
				$('#selunit option').clone().appendTo('#unit'+tst);
	}
	// function AddRow_Edit(nn,barcode,unit,price,cur,multi){
	// 	var row='<tr>'+
	// 			'<td class="no" style="text-align:center;padding-top:15px;">'+
	// 			nn +
	// 			'</td>'+
	// 			'<td>'+
	// 				'<input type="text" class="form-control barcode" name="barcode[]" required value='+ barcode +'>'+
	// 			'</td>'+
	// 			'<td><input type="text" class="form-control unit" name="unit[]" required value='+ unit +'>'+
	// 			'</td>'+
	// 			'<td><input type="text" class="form-control price" name="price[]" required value='+ price +'>'+
	// 			'</td>'+
	// 			'<td>'+
	// 				'<select name="cur[]" class="form-control curedit">'+
	// 					'<option value="R" class="a0">R</option>'+
	// 					'<option value="B" class="a1">B</option>'+
	// 					'<option value="$" class="a2">$</option>'+
	// 				'</select>'+
	// 			'</td>'+
	// 			'<td><input type="text" class="form-control multi" name="multi[]" required value='+ multi +'>'+
	// 			'</td>'+
	// 			'<td>'+
	// 				'<a href="#" class="btn btn-danger remove" style="border-radius:15px;"><i class="fa fa-minus"></i></a>'+
	// 			'</td>'+
	// 		'</tr>';
	// 			$('#tbl_barcode').append(row);
	// 			$('.curedit').val(cur);
	// 			// if(cur==0){
	// 			// 	$('.curedit').eq(nn-1).find('.a0').attr('selected',true)
	// 			// }else if(cur==1){
	// 			// 	$('.curedit').eq(nn-1).find('.a1').attr('selected',true)
	// 			// }else{
	// 			// 	$('.curedit').eq(nn-1).find('.a2').attr('selected',true)
	// 			// }
	// }
	function AddRow_Edit(nn,barcode,unit,price,cur,multi){
		var row='<tr>'+
				'<td class="no" style="text-align:center;padding-top:15px;">'+
				nn +
				'</td>'+
				'<td>'+
					'<input type="text" class="form-control barcode" name="barcode[]" style="height:40px;" required title='+ unit +' value='+ barcode +'>'+
				'</td>'+
				'<td>'+
				'<select class="form-control unit" style="height:40px;" name="unit[]" id="unit'+ nn +'" title="'+ nn +'" required>'+
					
				'</select>'+
				'</td>'+
				'<td><input type="text" class="form-control price" name="price[]" style="height:40px;text-align:right;" required value='+ formatNumber(price) +'>'+
				'</td>'+
				'<td>'+
					'<select name="cur[]" class="form-control cur" style="height:40px;">'+
						'<option value="R" class="a0">R</option>'+
						'<option value="B" class="a1">B</option>'+
						'<option value="$" class="a2">$</option>'+
					'</select>'+
				'</td>'+
				'<td><input type="text" class="form-control multi" name="multi[]" required style="height:40px;" value='+ multi +'>'+
				'</td>'+
				'<td>'+
					'<a href="#" class="btn btn-danger remove" style="border-radius:15px;margin-top:5px;"><i class="fa fa-minus"></i></a>'+
				'</td>'+
			'</tr>';
				$('#tbl_barcode').append(row);
				$('.cur').val(cur);
				$('.unit option').remove();
				$('#selunit option').clone().appendTo('.unit');
				
	}
	function filleditunit() {
		$('.barcode').each(function(i,e){
			var unit=$(this).attr('title');
			$('#unit'+i).val(unit);
		})
	}
//---------------------------------------
	function ResetNo(){
		$('.no').each(function(i,e){
			$(this).text(i+1);
		})
	}
	function RemoveAllRow(){
		 var l=$('#tbl_barcode tr').length;

		$('.remove').each(function(i,e){
			
				$(this).parent().parent().remove();
			
		})
	}
//-----------------------
		$('.remove').live('click',function(){
		// var l=$('#tbl_barcode tr').length;
		// if(l==1)
		// {
		// 	alert('You can not remove last one');
		// }else{
		// 	$(this).parent().parent().remove();
			
		// }
		$(this).parent().parent().remove();
		ResetNo();
	});
//-------------------------
$('.btn-edit').on('click',function(e){
		e.preventDefault();
		p_id=$(this).data('id');
		RemoveAllRow();
		$.get("{{ route('editproduct') }}",{id:p_id},function(data){
			$('#product_id').val(data[0].product_id);
			$('#productcode').val(data[0].code);
			$('#productname').val(data[0].name);
			$('#description').val(data[0].description);
			if(data[0].image==''){
				$('#showPhoto').attr('src','{{ asset('logo/NoPicture.jpg') }}');
			}else{
				$('#showPhoto').attr('src','{{ asset('photo') }}'+ '/' + data[0].image);

			}
			$('#frm_add_product').attr('action','{{ route('productupdate1') }}');
			$('.btn-save').text('កែប្រែ');
			$.each(data,function(i,pb){
				$('#cur_id').val(pb.cur);
				AddRow_Edit(i+1,pb.barcode,pb.unit,pb.price,pb.cur,pb.multiple);
				
					})
			
			console.log(data)
		})
	})
//----------------------------
	$('#productcode').on('blur',function(){
		var prcode=$(this).val();
		var proid=$('#product_id').val();
		$.get("{{ route('check_exist_prcode') }}",{prcode:prcode,prid:proid},function(data){
			if(data !=""){
				alert('កូដទំនិញនេះបានប្រើប្រាស់រួចហើយនោះគឺ :' + data[0].name);
			}
			
		})
		
	});
	
		function formatNumber(num) {
	 			
      	num=parseFloat(num);
		 return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
		}	
	</script>
@endsection