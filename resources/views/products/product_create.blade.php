@extends('layouts.master')
@section('pagetitle')
	Product Register
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
			/*font-weight:bold;
			font-size:16px;*/
			font-family:"Khmer OS System";
		}
		input,button,textarea,td{
			font-family:"Khmer OS System";
		}
		button.en{
			font-family:"Time New Romain";
		}
		.kh{
			font-family:"Khmer OS System";
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
	@php
		$myfile = fopen("stockcurrency.txt", "r") or die("Unable to open file!");
		//$myfile = fopen("E:\PHPfile\best.txt", "r") or die("Unable to open file!");
		$stockcur= fgets($myfile);
		fclose($myfile);
	@endphp
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa-file-text-o"></i>Product Registration</h3>
			<table class="table table-hover table-bordered">
				<tr>
					<td><button id="addnewproduct" class="btn btn-info" style="margin-top:-5px;">ចុះឈ្មោះទំនិញ</button></td>
					<td>
						<label class="form-check-label" style="color:blue;">
						    <input type="radio" class="form-check-input radshow" name="radc" style="font-family:khmer os system;" checked value="1" data-text="ទំនិញលក់">ទំនិញលក់
					  </label>
					</td>
					<td>
						<label class="form-check-label" style="color:red;">
					    <input type="radio" class="form-check-input radshow" name="radc" style="font-family:khmer os system;" value="0" data-text="ទំនិញលុប">ទំនិញលុប
					  </label>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<!-- Image loader -->
	<div id="fade"></div>
    <div id="modal">
        <img id="loader" src="/logo/ajaxloading4.gif" />

    </div>
	@include('modal.category_modal')		
	@include('modal.brand_modal')
	@include('products.confirmdelete')
	@include('modal.unit_modal')
	@include('products.create_modal')
	<div class="row">
		<div class="col-lg-2" style="margin-top:-15px;">
			<div class="row" style="margin-left:1px;">
			<button id="btnshowall" class="btn btn-primary" style="width:99%;">បង្ហាញផលិតផលទាំងអស់</button>
			<table class="table table-bordered table-hover">
				{{-- <thead>
					<tr>
						<th>Category</th>
					</tr>
				</thead> --}}
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
							    				<td style="color:blue;" data-id="{{ $cat->id . '-' . $br->id }}" data-name="{{ $cat->name . '-' . $br->name }}" class="catbrand">{{ $br->name }}</td>
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
			<div class="panel panel-default" style="margin-top:-15px;" id="divheader">
				<div class="panel-heading">
					<h3 style="display:inline;float:left;padding-top:10px;font-family:khmer os system;font-size:18px;" id="pl">ទំនិញលក់</h3>
					<div class="input-group input-group-sx" style="padding:5px;">
			          <input type="text" name="psearch" id="psearch" class="typeautosearch form-control" placeholder="Search" style="max-width: 400px;display:inline;float:right;">
			          <div class="input-group-btn" >
			            <button type="button" class="btn btn-default btnsearchproduct" style="display:inline;float:right;width:30px;"><i class="fa fa-search" style="margin-left:-12px;"></i></button>
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
									<th style="text-align:center;">Category</th>
									<th style="text-align:center;">Brand</th>
									{{-- <th style="text-align:center;">Image</th> --}}
									<th style="text-align:center;" class="colaction">Action</th>
								</tr>
							</thead>
							<tbody id="tbody-product-list">
								@foreach ($products as $key => $p)
									<tr> 
										<td style="text-align:center;">{{ ++$key }}</td>
										<td style="text-align:center;">{{ date('d-m-Y',strtotime($p->created_at)) }}</td>
										<td style="text-align:center;">{{ $p->code }}</td>
										<td style="text-align:center;">{{ $p->name }}</td>
										<td style="text-align:center;">{{ $p->category->name }}</td>
										<td style="text-align:center;">{{ $p->brand->name }}</td>
										
										{{-- <td style="text-align:center;">
											<img src="{{ $p->getImage() }}" alt="" style="height:60px;">
										</td> --}}
										<td style="text-align:center;width:115px;" class="colaction">
											<a href="" class="btn btn-warning btn-xs btn-edit" title="Edit" data-id="{{ $p->id }}" style="width:60px;color:blue;">
												Edit
											</a>
											
											<a href="" class="btn btn-danger btn-xs btn-delete" title="Remove" data-id="{{ $p->id }}" style="width:60px;margin-top:5px;">
												Remove
											</a>
										</td>
									</tr>

								@endforeach
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
@endsection

@section('script')
	<script src="{{ asset('js') }}/toastr.min.js"></script>
	<script src="{{ asset('js') }}/jquery.datetimepicker.full.js"></script>
	<script src="{{ asset('js') }}/numberinput.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){

		$('#sel_category').select2();
		$('#sel_brand').select2();
		
		$(document).on('click','#btnprint',function(e){
			$('.colaction').css('display','none');
			$('#divfooter').css('display','none');
			$('#divheader').css('margin-top','0')
			printContent('printloc');
		})
		function printContent(el)
		{
			 $('#sel_category').select2("destroy");
			 $('#sel_brand').select2("destroy");
			 
			  var restorpage=document.body.innerHTML;
			  var printloc=document.getElementById(el).innerHTML;
			  document.body.innerHTML=printloc;
			  window.print();
			  document.body.innerHTML=restorpage;
			  //location.reload();
			  var path = "{{ route('autocomplete') }}";
			    $('input.typeautosearch').typeahead({
			        source:  function (query, process) {
			        return $.get(path, { query: query }, function (data) {
			                return process(data);
			            });
			        }
			    });
			 $('#sel_category').select2();
			 $('#sel_brand').select2();
			 
			  $('.colaction').css('display','block');
			  $('#divfooter').css('display','block');
			  $('#divheader').css('margin-top','-15px')
		}
		$('.btn-new').on('click',function(){
			var oldcat=$('#sel_category').val();
			var oldbrand=$('#sel_brand').val();
			document.getElementById("frm_add_product").reset();
			$('#stockqty').attr('disabled',false);
			$('#unitprice').attr('disabled',false);
			$('#sel_category').val(oldcat);
			//$('#sel_category').select2().trigger('change')
			$('#sel_brand').val(oldbrand);
			$('#productcode').focus();
			// $('#sel_brand').val('');
			// $('#sel_brand').select2().trigger('change')
			$('#showPhoto').attr('src','{{ asset('logo/NoPicture.jpg') }}');
			$('.btn-save').text('រក្សាទុក');
			var url="{{ route('getlastbarcodelist') }}";
			$.get(url,{a:'a'},function(data){
				$('#tbl_barcode').empty().html(data);
			})
		})
	// add category
		$('#add_category').on('click',function(){
			$('#category_modal').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                		}); 
			
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
	$('#add_unit').on('click',function(){
			
			$('#unit_modal').modal('show');
			$('#unit_name').val('');
		});
		$('.btn_save_unit').on('click',function(){
				var u_name=$('#unit_name').val();
				$.post("{{ route('add_unit') }}",{name:u_name},function(data){
					$('#selunit').append($("<option/>",{
						value:data.id,
						text:data.name
					}))
					
					$('.btncloseunit').click();
				})
			});
	//add brand
		$('#add_brand').on('click',function(){
			var catid=$('#sel_category').val();

			if(catid != ''){
				$('#brand_modal').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                		}); 
				$('#brand_name').val('');
				$('#catid').val($('#sel_category').val());
				var el = document.getElementById("sel_category");
				var catname = el.options[el.selectedIndex].text;
				$('#cat_name').val(catname);
			}
			
		});
		$('.btn_save_brand').on('click',function(){
				var b_name=$('#brand_name').val();
				var catid=$('#catid').val();
				if(b_name==''){
					alert('please insert brand name')
				}else{
					$.post("{{ route('postbrand') }}",{name:b_name,category_id:catid},function(data){
					$('#sel_brand').append($("<option/>",{
						value:data.id,
						text:data.name
					}))
						$('#brand_modal').modal('hide');
					})
				}
				
			});
	//-----------------------------------------		
		$('.btn-browse').on('click',function(){
			$('#image').click();
		})
		$('#image').on('change',function(e){
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
              refreshsearch();
            }
          });
      });
      $(document).on('click','.btn-delete2',function(e){
      	e.preventDefault();
      	var c=confirm('Do you want to remove this item from bin?')
      	if(c==true){
      		var url="{{ route('deletefrombin') }}";
      		var pid=$(this).data('id');
      		var img=$(this).data('image');
      		$.post(url,{id:pid,img:img},function(data){
      			refreshsearch();
      		})
      	}
      })
      $(document).on('click','.btn-restore',function(e){
      	e.preventDefault();
      	var c=confirm('Do you want to restore this item?');
      	if(c==true){
      		var url="{{ route('productrestore') }}";
      		var pid=$(this).data('id');
      		$.post(url,{id:pid},function(data){
      			refreshsearch();
      		})
      	}

      })
	//product barcode
	$('.addrow').on('click',function(){
		AddRow();
		ResetNo();
	});

	function AddRow(){
		var nn=$('#tbl_barcode tr').length+1;
		let tst = Math.round(Date.now() / 1000)+nn;
		var row='<tr>'+
				'<td class="no" style="text-align:center;padding-top:15px;width:60px;">'+
				
				'</td>'+
				'<td>'+
					'<input type="text" class="form-control barcode canenter" name="barcode[]" required style="height:40px;width:200px;" autocomplete="off">'+
				'</td>'+
				'<td>'+
				'<select class="form-control unit" style="height:40px;width:120px;" name="unit[]" id="unit'+ tst +'" title="'+ tst +'" required>'+
					
				'</select>'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="price[]" required style="height:40px;text-align:right;font-size:16px;width:120px;" autocomplete="off">'+
				'</td>'+
				'<td>'+
					'<select name="cur[]" class="form-control" style="height:40px;width:80px;">'+
						'<option value="R">R</option>'+
						'<option value="B">B</option>'+
						'<option value="$">$</option>'+

					'</select>'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="dealer[]" required style="height:40px;text-align:right;font-size:16px;width:120px;" autocomplete="off">'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="member[]" required style="height:40px;text-align:right;font-size:16px;width:120px;" autocomplete="off">'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="vip[]" required style="height:40px;text-align:right;font-size:16px;width:120px;" autocomplete="off">'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="suppervip[]" required style="height:40px;text-align:right;font-size:16px;width:120px;" autocomplete="off">'+
				'</td>'+
				'<td><input type="text" class="form-control multi canenter" name="multi[]" required style="height:40px;width:80px;" autocomplete="off">'+
				'</td>'+
				'<td>'+
					'<a href="#" class="btn btn-danger remove" style="border-radius:15px;"><i class="fa fa-minus"></i></a>'+
				'</td>'+
			'</tr>';
				$('#tbl_barcode').append(row);
				//$('.unit option').remove();
				$('#selunit option').clone().appendTo('#unit'+tst);
				//number('.barcode',true);
				number('.price',true);
				number('.multi',true);
	}
	
	function AddRow_Edit(nn,barcode,unit,price,cur,multi,dealer,member,vip,suppervip){
		var row='<tr>'+
				'<td class="no" style="text-align:center;padding-top:15px;width:60px;">'+
				nn +
				'</td>'+
				'<td>'+
					'<input type="text" class="form-control barcode canenter" name="barcode[]" style="height:40px;width:200px;" required title='+ unit +' value='+ barcode +' autocomplete="off">'+
				'</td>'+
				'<td>'+
				'<select class="form-control unit" style="height:40px;width:120px;" name="unit[]" id="unit'+ nn +'" title="'+ nn +'" required>'+
					
				'</select>'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="price[]" style="height:40px;text-align:right;font-size:16px;width:120px;" required value='+ formatNumber(price) +' autocomplete="off">'+
				'</td>'+
				'<td>'+
					'<select name="cur[]" class="form-control cur" style="height:40px;width:80px;">'+
						'<option value="R" class="a0">R</option>'+
						'<option value="B" class="a1">B</option>'+
						'<option value="$" class="a2">$</option>'+
					'</select>'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="dealer[]" style="height:40px;text-align:right;font-size:16px;width:120px;" required value='+ formatNumber(dealer) +' autocomplete="off">'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="member[]" style="height:40px;text-align:right;font-size:16px;width:120px;" required value='+ formatNumber(member) +' autocomplete="off">'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="vip[]" style="height:40px;text-align:right;font-size:16px;width:120px;" required value='+ formatNumber(vip) +' autocomplete="off">'+
				'</td>'+
				'<td><input type="text" class="form-control price canenter" name="suppervip[]" style="height:40px;text-align:right;font-size:16px;width:120px;" required value='+ formatNumber(suppervip) +' autocomplete="off">'+
				'</td>'+
				'<td><input type="text" class="form-control multi canenter" name="multi[]" required style="height:40px;width:80px;" title='+ barcode +' value='+ multi +' autocomplete="off">'+
				'</td>'+
				'<td>'+
					'<a href="#" class="btn btn-danger remove" style="border-radius:15px;margin-top:5px;"><i class="fa fa-minus"></i></a>'+
				'</td>'+
			'</tr>';
				$('#tbl_barcode').append(row);
				
				if(cur=='R'){
					$('.a0').eq(nn-1).attr('selected',true);
				}else if(cur=='B'){
					$('.a1').eq(nn-1).attr('selected',true);
				}else{
					$('.a2').eq(nn-1).attr('selected',true);
				}
				
				$('.unit option').remove();
				$('#selunit option').clone().appendTo('.unit');
				//number('.barcode',true);
				number('.price',true);
				number('.multi',true);
	}
	function filleditunit() {
		$('.barcode').each(function(i,e){
			var unit=$(this).attr('title');
			++i;
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
$(document).on('click','.btn-edit',function(e){
		e.preventDefault();
		p_id=$(this).data('id');
		RemoveAllRow();
		$.get("{{ route('editproduct') }}",{id:p_id},function(data){
			$('.btn-save').text('កែប្រែ');
			
			$('#sel_category').val(data[0].category_id);
			$('#sel_category').select2().trigger('change');
			$('#sel_brand').val(data[0].brand_id);
			$('#sel_brand').select2().trigger('change');
			$('#product_id').val(data[0].product_id);
			$('#productcode').val(data[0].code);
			$('#productname').val(data[0].name);
			$('#description').val(data[0].description);
			$('#stockqty').val(data[0].stock);
			$('#selunit').val(data[0].itemunit);
			$('#unitprice').val(formatNumber(data[0].costprice));
			$('#cur1').val(data[0].buycur);
			$('#old_image').val(data[0].image);
			$('#amount1').val(formatNumber(data[0].costprice*data[0].stock)+' '+data[0].buycur);
			$('#stockqty').attr('disabled',true);
			$('#unitprice').attr('disabled',true);
			//$('#cur1').attr('disabled',true);
			$('#amount1').attr('disabled',true);
			if(data[0].image==''){
				$('#showPhoto').attr('src','{{ asset('logo/NoPicture.jpg') }}');
			}else{
				$('#showPhoto').attr('src','{{ asset('photo') }}'+ '/' + data[0].image);

			}
			//$('#frm_add_product').attr('action','{ route('productupdate1') }}');
			

			$.each(data,function(i,pb){
				//$('#cur_id').val(pb.cur);
				AddRow_Edit(i+1,pb.barcode,pb.unit,pb.price,pb.cur,pb.multiple,pb.dealer,pb.member,pb.vip,pb.suppervip);
				
					})
			filleditunit();
			$('#create_product_modal').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                		}); 
			$('#h4modal').text('Update Product');
			//console.log(data)
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
	 $(document).on('keyup','#stockqty,#unitprice',function(){
		  		var qty=$('#stockqty').val();
		  		var price=$('#unitprice').val().replace(/,/g,'');
				var amount=qty * price;
				$('#amount1').val(formatNumber(amount.toFixed(2))+' ' + $('#cur1').val());
				
			})
	 $(document).on('change','#cur1',function(){
		  		var qty=$('#stockqty').val();
		  		var price=$('#unitprice').val().replace(/,/g,'');
				var amount=qty * price;
				$('#amount1').val(formatNumber(amount.toFixed(2))+' ' + $('#cur1').val());
				
			})
	 $(document).on('change','.unitprice,.price',function(e){
	 	var xy=$(this).val().replace(/,/g,'');
	 	$(this).val(formatNumber(xy));

	 })
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
	 	var radsel=$('input[name="radc"]:checked').val();
	 	if(remsearch==1){
	 		var url="{{ route('getproductbycategory') }}";
	        $.get(url,{catid:remcatid,brid:rembrid,status:radsel},function(data){
	        	$('#tbody-product-list').empty().html(data);
	        })
	 		
	 	}else if(remsearch==2){
	 		searchproduct($('#psearch').val());
	 	}else if(remsearch==3){
	 		var url="{{ route('getproductallcategory') }}";
	        $.get(url,{status:radsel},function(data){
	        	$('#tbody-product-list').empty().html(data);
	        	})
	 	}else if(remsearch==0){
	 		getsavedproduct();
	 	}
	 }
	function searchproduct(q) {
		var radsel=$('input[name="radc"]:checked').val();
    	if(radsel==0){
    		$('#pl').text('ទំនិញលុប');
    		$('#pl').css('color','red');
    	}else{
    		$('#pl').text('ទំនិញលក់');
    		$('#pl').css('color','blue');
    	}
		var url="{{ route('productsearch') }}";
		$.get(url,{q:q,status:radsel},function(data){
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

	
	number('#stockqty',true);
	number('#unitprice',true);
	//number('.barcode',true);
	number('.price',true);
	number('.multi',true);

	$(document).on('keydown','.canenter',function(e){
		 if (e.keyCode == 13) {
	        var $this = $(this),
	        index = $this.closest('td').index();
	        $this.closest('tr').next().find('td').eq(index).find('input').focus().select();
	        e.preventDefault();
	    }
	})
	
	$(document).on('blur','.barcode',function(e){
		var bc=$(this).val();
		var tbl=$('#tbl_barcode tr').length;
		
		var pid=$('#product_id').val();
		var row = $(this).closest('tr');
        var rowind=row.find("td:eq(0)").text();
		var url="{{ route('checkexistbarcode') }}";
		$.get(url,{bk:bc,pid:pid},function(data){
			console.log(data)
			if(!$.isEmptyObject(data.exists)){
				alert(data.exists)
				if(pid==''){
					$('.barcode').eq(rowind-1).val('');
				}else{
					$('.barcode').eq(rowind-1).val($('.multi').eq(rowind-1).attr('title'));
				}
				
			}else{
				
				$('.barcode').each(function(i,e){
					var ibarcode=$('.barcode').eq(i).val();
					
					//console.log(i)
					for(j=i+1;j<tbl;j++){
						console.log(j)
						var jbarcode=$('.barcode').eq(j).val();
						console.log(jbarcode)
						
						if(ibarcode!=''){
							if(ibarcode==jbarcode){
								if(pid==''){
									$('.barcode').eq(j).val('');
								}else{
									
									$('.barcode').eq(j).val($('.multi').eq(j).attr('title'));
								}
								
							}
						}
						
					}
					
				})
			}
		})
	})
	checkscreenwidth();
	function checkscreenwidth() {
		if(screen.width==1920){
			$('#mw').css('width','100%');
		}else if(screen.width==360){
			$('#mw').css('width','100%');
		}else if(screen.width==1366){
			$('#mw').css('width','100%');
		}else if(screen.width==1024){
			$('#mw').css('width','100%');
		}else if(screen.width==800){
			$('#mw').css('width','100%');
		}else{
			$('#mw').css('width','100%');
		}
		
	}
	$(document).on('click','#addnewproduct',function(e){
		e.preventDefault();
		$('#create_product_modal').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true

                		}); 
		
		$('#h4modal').text('Add New Product');
		$('.btn-new').click();
	})

	$('#frm_add_product').on('submit',function(e){
				e.preventDefault();
				var domain=window.location.hostname;
				var protocol=window.location.protocol;
				var k=0;
				if($('#product_id').val()==''){
					remsearch=0;
					var urlset="{{ route('postproduct') }}"
				}else{
					var urlset="{{ route('productupdate1') }}"
					k=1;
				}
				var data= new FormData(this);
				$.ajax({
						type:"POST",
						url:urlset,
						data:data,
						datatype:"JSON",
						contentType:false,
						cache:false,
						processData:false,
						success:function(data){
							//console.log(data)
							if($.isEmptyObject(data.error)){
								if(k==1){
				                	toastr.success('Update Product Successfully');
				                	refreshsearch();
				                	$('#create_product_modal').modal('hide');

				                }else{
				                	toastr.success('Save Product Successfully');
				                	getsavedproduct();
				                	$('.btn-new').click();
				                	
				                }
							}else{
								alert(data.error)
							}
						}
					});
				});
	// $(document).on('click','.btn-save',function(e){
	// 	e.preventDefault();
	// 	var k=0;
	// 	if($(this).text()=='កែប្រែ'){
	// 		k=1;
	// 		var url=" route('productupdate1') }}";
	// 	}else{
	// 		remsearch=0;
	// 		var url=" route('postproduct') }}";
	// 	}
		
	// 	var data=$('#frm_add_product').serialize();
	// 	$.post(url,data,function(data){
	// 		console.log(data)
	// 		if($.isEmptyObject(data.error)){
 //                //alert(data.success);
               
 //                if(k==1){
 //                	toastr.success('Update Product Successfully');
 //                	refreshsearch();
 //                	$('#create_product_modal').modal('hide');

 //                }else{
 //                	toastr.success('Save Product Successfully');
 //                	getsavedproduct();
 //                	$('.btn-new').click();
                	
 //                }
                
 //            }else{
 //            	alert(data.error)
 //                printErrorMsg(data.error);
 //            }
	// 	})
	// })
	function getsavedproduct() {
		var url="{{ route('getsavedproduct') }}";
		$.get(url,{a:'a'},function(data){
			$('#tbody-product-list').empty().html(data);
		})
	}
	function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
       $(document).on('click','.catbrand',function(e){
       	
       	openModal();
       	var radsel=$('input[name="radc"]:checked').val();
    	if(radsel==0){
    		$('#pl').text('ទំនិញលុប');
    		$('#pl').css('color','red');
    	}else{
    		$('#pl').text('ទំនិញលក់');
    		$('#pl').css('color','blue');
    	}
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
       	var url="{{ route('getproductbycategory') }}";
       	
        $.get(url,{catid:catid,brid:brid,status:radsel},function(data){
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
    	var radsel=$('input[name="radc"]:checked').val();
    	if(radsel==0){
    		$('#pl').text('ទំនិញលុប');
    		$('#pl').css('color','red');
    	}else{
    		$('#pl').text('ទំនិញលក់');
    		$('#pl').css('color','blue');
    	}
    	var url="{{ route('getproductallcategory') }}";
        $.get(url,{status:radsel},function(data){
        	$('#tbody-product-list').empty().html(data);
        	setTimeout(function()
		  		{
					closeModal();
				},300);
        })
    })
    $(document).on('change','#sel_category',function(e){
    	e.preventDefault();
    	var catid=$(this).val();
   		var url="{{ route('getbrandid') }}";
   		$('#sel_brand').empty();
   		$.get(url,{catid:catid},function(data){
   			$('#sel_brand').append($("<option/>",{
						value:'',
						text:''
					}))
   			$.each(data,function(i,item){
   				$('#sel_brand').append($("<option/>",{
						value:item.id,
						text:item.name
					}))
   				console.log(item)
   			});
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
})
	</script>
@endsection