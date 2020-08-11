@extends('layouts.master')
@section('pagetitle')
	Compay Register
@endsection
@section('css')
	<style>
		.student-photo{
			height:300px;
			padding-left:1px;
			padding-right:1px;
			border:1px solid #ccc;
			background:#eee;
			width:500px;
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
	</style>
@endsection
@section('content')
	<div class="container-fluid" style="overflow:auto;">
		<div class="panel panel-info"​>
			<div class="panel-heading">
				Company Setup
			</div>
			<form action="" method="post" id="frmcompany" enctype="multipart/form-data" autocomplete="off">
				 {{ csrf_field() }}
				<input type="hidden" name="comid" id="comid">
				<input type="hidden" name="old_image" id="old_image">
				<div class="panel-body">
					<div class="col-lg-6">
						<div class="form-group">
						<label for="name">Company Name</label>
						<input type="text" class="form-control" name="companyname" id="companyname">
						<label for="title">Sub Title</label>
						<input type="text" class="form-control" name="subname" id="subname">
						<label for="tel">Tel</label>
						<textarea class="form-control" name="tel" id="tel" cols="30" rows="3"></textarea>
						<label for="email">Email</label>
						<input type="text" class="form-control" name="email" id="email">
						<label for="website">Website</label>
						<input type="text" class="form-control" name="website" id="website">
						<label for="address">Address</label>
						<textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
						
					</div>
					</div>
					<div class="col-lg-6" style="overflow:auto;">
						<div class="form-group form-group-login">
	                      <table style="margin:0 auto;">
	                        <thead>
	                          <tr>
	                            <th style="text-align:center;">Logo</th>
	                          </tr>
	                        </thead>
	                        <tbody>
	                          <tr>
	                            <td class="photo">
	                              {{-- {!! Html::image('logo/nologo.jpg',null,['class'=>'student-photo','id'=>'showPhoto']) !!} --}}
	                              <img src="{{ asset('logo/nologo.jpg') }}" alt="" class="student-photo" id="showPhoto" style="width:auto;height:auto;">
	                              <input type="file" name="image" id="image" accept="image/x-png,image/png,image/jpg,image/jpeg,image/webp">
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
							
						<div class="footer text-center">
							
							<button type="submit" class="btn btn-primary" id="btnsave">Save</button>
							<button class="btn btn-default" id="btnnew" style="font-weight:bold;color:black;margin-left:50px;">New</button>
						</div>
					</div>
					
				</div>
			</form>
		</div>
		<div class="table-responsive" style="overflow:auto;">
			<table class="table table-bordered table-hover">
				<thead>
					<tr style="background-color:#fff;">
						<th>No</th>
						<th>ID</th>
						<th>Company Name</th>
						<th>Sub Title</th>
						<th>Tel</th>
						<th>Email</th>
						<th>Website</th>
						<th>Address</th>
						<th>Logo</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="tbl_company">
					@foreach ($companies as $key => $com)
						<tr>
							<td>{{ ++$key }}</td>
							<td>{{ $com->id }}</td>
							<td>{{ $com->name }}</td>
							<td>{{ $com->subname }}</td>
							<td>{{ $com->tel }}</td>
							<td>{{ $com->email }}</td>
							<td>{{ $com->website }}</td>
							<td>{{ $com->address }}</td>
							
							<td><img src="{{ $com->logo <> '' ? asset('logo/'. $com->logo):'' }}" alt="" style="width:128px;height:128px;"></td>
							<td>
								<a href="#" class="btn btn-warning row-edit" data-id="{{ $com->id }}">Edit</a>
								<a href="#" class="btn btn-danger row-delete" data-id="{{ $com->id }}" data-logo="{{ $com->logo }}">Delete</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
	</div>
@endsection
@section('script')
	<script type="text/javascript">
		$(document).ready(function(){

			$('#frmcompany').on('submit',function(e){
				e.preventDefault();
				var domain=window.location.hostname;
				var protocol=window.location.protocol;
				if($('#comid').val()==''){
					var urlset="{{ route('company.store') }}"
				}else{
					var urlset="{{ route('company.update') }}"
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
								readdata();
								$('#frmcompany').trigger('reset');
								$('#companyname').focus();
								$('#btnsave').text('Save');
								$('#showPhoto').attr('src',protocol + '//' + domain +'/logo/nologo.jpg');
								document.body.scrollTop = scrolledit; // For Safari
  								document.documentElement.scrollTop = scrolledit; // For Chrome, Firefox, IE and Opera
							}else{
								alert(data.error)
							}
						}
					});
				});
			var iscroll=0;
			window.addEventListener("scroll", function (event) {
			     iscroll = this.scrollY;
			    console.log(iscroll)
			});

			$(document).on('click','#btnnew',function(e){
				e.preventDefault();
				location.reload();
			})
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
			var scrolledit=0;
			$(document).on('click','.row-edit',function(e){
				e.preventDefault();
				var id=$(this).data('id');
				$('#comid').val(id);
				$('#btnsave').text('Update');
				scrolledit=iscroll;
				///var domain = $(location).attr('hostname');
				var domain=window.location.hostname;
				var protocol=window.location.protocol;
				var url="{{ route('company.getinfobyid') }}";
				$.get(url,{id:id},function(data){

					$('#companyname').val(data.name);
					$('#subname').val(data.subname);
					$('#tel').val(data.tel);
					$('#email').val(data.email);
					$('#website').val(data.website);
					$('#address').val(data.address);
					$('#old_image').val(data.logo);
					if(data.logo!=''){
						$('#showPhoto').attr('src',protocol + '//' + domain +'/logo/' + data.logo);
					}else{
						$('#showPhoto').attr('src',protocol + '//' + domain +'/logo/nologo.jpg');
					}
					
				})
				document.body.scrollTop = 0; // For Safari
  				document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
			})
			
			$(document).on('click','.row-delete',function(e){
				e.preventDefault();
				var c=confirm("Do you want to delete this item?");
				if(c==true){
					var url="{{ route('company.destroy') }}";
					var id=$(this).data('id');
					var logo=$(this).data('logo');
					$.post(url,{id:id,logo:logo},function(data){
						readdata();
					})
				}
			})

			function readdata() {
				var url="{{ route('company.readdata') }}";
				$.get(url,{a:'a'},function(data){
					$('#tbl_company').empty().html(data);
				})
			}

	})
		
	</script>
@endsection