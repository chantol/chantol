@extends('layouts.master')
@section('pagetitle')
	Exchange Rate
@endsection
@section('css')
	
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-3">
			
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading" style="background:skyblue;">
					<h3 class="panel-title" style="color:red;background:skyblue;"><strong>Exchange Rate Board</strong></h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<td style="text-align:center;">No</td>
								<td style="text-align:center;display:none;">ID</td>
								<td style="text-align:center;">Exchange Currency</td>
								<td style="text-align:center;">Buy</td>
								<td style="text-align:center;">Sale</td>
								<td style="text-align:center;">Action</td>
							</tr>
						</thead>
						<form action="#" id="frmexchange">
							<input type="hidden" name="userid" id="userid" value="{{ Auth::id() }}">
							<tbody>
								@foreach ($xchange as $key => $ex)
									<tr>
										<td style="padding-top:15px; text-align:center;">{{ ++$key }}</td>
										<td style="display:none;">
											<input type="text" class="form-control" name="id[]" value="{{ $ex->id }}">
										</td>
										<td>
											<input type="text" class="form-control" name="excur[]" value="{{ $ex->exchange_cur }}" readonly>
										</td>
										<td>
											<input type="text" class="form-control" name="buy[]" value="{{ (float)$ex->buy }}">
										</td>
										<td>
											<input type="text" class="form-control" name="sale[]" value="{{ (float)$ex->sale }}">
										</td>
										<td>
											<a href="#" class="btn btn-info btn-sm btnsaverate" data-id="{{ $ex->id }}">Save</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</form>
					</table>
				</div>
				<div class="panel-footer" style="height:50px;">
					<button class="" id="btnsaveall" style="float:right;height:30px;width:100px;">Save all</button>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			
		</div>

	</div>
@endsection
@section('script')
	<script>
		$(document).ready(function(){
			$(document).on('click','#btnsaveall',function(){
				var url="{{ route('save-exchange') }}";
				var data=$('#frmexchange').serialize();
				$.post(url,data,function(data){
					console.log(data)
					if(data.success){
						alert('update rate completed')
					}
					//location.reload();
				});
			})

			$(document).on('click','.btnsaverate',function(){
				var url="{{ route('save-exchange1') }}";
				currentRow=$(this).closest("tr");
				var id=$(this).data('id'); 
				
				var excur=currentRow.find("td:eq(2) input").val();
         		var buy=currentRow.find("td:eq(3) input").val(); 
         		var sale=currentRow.find("td:eq(4) input").val(); 
         		var userid=$('#userid').val();
				$.post(url,{id:id,buy:buy,sale:sale,userid:userid},function(data){
					console.log(data)
					if(data.success){
						alert('update rate completed')
					}
					//location.reload();
				});
			})
		})
	</script>
@endsection