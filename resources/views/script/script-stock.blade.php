<script type="text/javascript">
			
		$(document).ready(function(){
			var today=new Date();
			$('#dateshow').datetimepicker({
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
			$('#closedate').datetimepicker({
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
			$('#printdate').text(moment().format('DD-MM-YYYY'));
//-------------------------------------------
			$(document).on('change','#typesearch',function(e){
				e.preventDefault();
				var el='<label for="select">Search By Date:</label>';
				$('#fillsearch').empty();
				var sel_val=$(this).val();
				if(sel_val==0){
				 el='<label for="select">Search By Category:</label>'+
					'<div class="input-group">'+
					'<select name="category" id="category" class="form-control">'+
					'<option value="">All Categories</option>'+
					'@foreach ($cats as $c)'+
						'<option value="{{ $c->id }}">{{ $c->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_category">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					$('#fillsearch').html(el);
					$('#category').select2();
				}
				else if(sel_val==1){
					 el='<label for="select">Search By Brands:</label>'+
					'<div class="input-group">'+
					'<select name="brand" id="brand" class="form-control">'+
					'<option value="">All Brands</option>'+
					'@foreach ($brands as $b)'+
						'<option value="{{ $b->id }}">{{ $b->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_brand">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					$('#fillsearch').html(el);
					$('#brand').select2();
				}

				else if(sel_val==2){
					 el='<label for="select">Search By Items:</label>'+
					'<div class="input-group">'+
					'<select name="items" id="items" class="form-control">'+
					'<option value="">All items</option>'+
					'@foreach ($stocks as $itm)'+
						'<option value="{{ $itm->id }}">{{ $itm->name }}</option>'+
					'@endforeach'+
					'</select>'+
					'<div class="input-group-addon btn btn-default" id="search_item">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					$('#fillsearch').html(el);
					$('#items').select2();
				}
				else if(sel_val==3){
					 el='<label for="select">Search By Product Code:</label>'+
					'<div class="input-group">'+
					'<input type="text" name="productcode" id="productcode" class="form-control" style="height:40px;">'+
					'<div class="input-group-addon btn btn-default" id="search_productcode">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					$('#fillsearch').html(el);
				}
				else if(sel_val==4){
					 el='<label for="select">Search By BarCode:</label>'+
					'<div class="input-group">'+
					'<input type="text" name="barcode" id="barcode" class="form-control" style="height:40px;">'+
					'<div class="input-group-addon btn btn-default" id="search_barcode">'+
						'<span class="fa fa-search" ></span>'+
					'</div></div>';
					$('#fillsearch').html(el);
				}else{
					 el='<label for="select">Search By Date:</label>'+
					 '<button class="form-control btn btn-info btnsearchbydate" style="height:40px;">Search by Date</button>'
					 $('#fillsearch').html(el);
				}
				
			})
			$(document).on('keydown','#barcode',function(e){
				 if (e.keyCode == 13) {
			        $('#search_barcode').click();
			        e.preventDefault();
			    }
			})
			$(document).on('keydown','#productcode',function(e){
				 if (e.keyCode == 13) {
			        $('#search_productcode').click();
			        e.preventDefault();
			    }
			})

			$(document).on('click','#search_barcode',function(e){
				$('#sby').val('4');
				filter=$('#barcode').val();
				$('#viewby').text('Item Barcode');
				$('#printdate').text($('#dateshow').val());
				var addr=$(location).attr('href');
				var n = addr.indexOf("info");
				var barcode=$('#barcode').val();
				var choosedate=$('#dateshow').val();
				if (n>0){
					var url="{{ route('searchmainstock') }}";
				}else{
					var url="{{ route('searchstock') }}";
				}
				$.get(url,{barcode:barcode,choosedate:choosedate},function(data){
					console.log(data)
					$("#table_data").empty().html(data);
				})
			})
			$(document).on('click','#search_productcode',function(e){
				$('#sby').val('3');
				filter=$('#productcode').val();
				$('#viewby').text('Item Code');
				$('#printdate').text($('#dateshow').val());
				var addr=$(location).attr('href');
				var n = addr.indexOf("info");
				var productcode=$('#productcode').val();
				var choosedate=$('#dateshow').val();
				if (n>0){
					var url="{{ route('searchmainstock') }}";
				}else{
					var url="{{ route('searchstock') }}";
				}
				$.get(url,{productcode:productcode,choosedate:choosedate},function(data){
					$("#table_data").empty().html(data);
				})
			})
			$(document).on('click','#search_item',function(e){
				$('#sby').val('2');
				filter=$('#items').val();
				$('#viewby').text('Item');
				$('#printdate').text($('#dateshow').val());
				var addr=$(location).attr('href');
				var n = addr.indexOf("info");
				var productcode=$('#items').val();
				var choosedate=$('#dateshow').val();
				if (n>0){
					var url="{{ route('searchmainstock') }}";
				}else{
					var url="{{ route('searchstock') }}";
				}
				$.get(url,{item:productcode,choosedate:choosedate},function(data){
					$("#table_data").empty().html(data);
				})
			})

			$(document).on('click','#search_brand',function(e){
				$('#sby').val('1');
				filter=$('#brand').val();
				$('#viewby').text('Brand:'+$("#brand option:selected").text());
				$('#printdate').text($('#dateshow').val());
				var addr=$(location).attr('href');
				var n = addr.indexOf("info");
				var brand=$('#brand').val();
				var choosedate=$('#dateshow').val();
				if (n>0){
					var url="{{ route('searchmainstock') }}";
				}else{
					var url="{{ route('searchstock') }}";
				}
				
				$.get(url,{brand:brand,choosedate:choosedate},function(data){
					$("#table_data").empty().html(data);
				})
			})

			$(document).on('click','#search_category',function(e){
				$('#sby').val('0');
				filter=$('#category').val();
				$('#viewby').text('Category:'+ $("#category option:selected").text());
				$('#printdate').text($('#dateshow').val());
				var addr=$(location).attr('href');
				var n = addr.indexOf("info");
				var category=$('#category').val();
				var choosedate=$('#dateshow').val();
				if (n>0){
					var url="{{ route('searchmainstock') }}";
				}else{
					var url="{{ route('searchstock') }}";
				}
				
				$.get(url,{category:category,choosedate:choosedate},function(data){
					$("#table_data").empty().html(data);
				})
			})

			$(document).on('click','.btnsearchbydate',function(e){
				e.preventDefault();
				$('#sby').val('-1');
				$('#viewby').text('Date');
				$('#printdate').text($('#dateshow').val());
				//$("body").css("cursor", "progress");
				var addr=$(location).attr('href');
				var n = addr.indexOf("info");
				var choosedate=$('#dateshow').val();
				if (n>0){
					var url="{{ route('searchmainstock') }}";
				}else{
					var url="{{ route('searchstock') }}";
				}

				$.get(url,{choosedate:choosedate},function(data){
					$("#table_data").empty().html(data);
					//$('#typesearch').attr('disabled',false);
					//$("body").css("cursor", "default");
					})
			})
			var filter='';
			$(document).on('click','#btnprintstock',function(e){
				e.preventDefault();
				// $('.colaction').css('display','none');
				// printContent('stockbody');

				var htp=window.location.protocol;
				var htn=window.location.hostname;
				
				var stockdate=$('#dateshow').val();
				var sby=$('#sby').val();

				
				var redirectWindow = window.open(htp+'//'+htn+'/stock/mainstock/print?dd='+ stockdate+'&searchby='+sby+'&filter='+filter, '_blank');
    			redirectWindow.location;
			})
			
			$(document).on('click','#btnsearchbydate2',function(e){
				e.preventDefault();
				$('#viewby').text('Date');
				$('#printdate').text($('#dateshow').val());
				//$("body").css("cursor", "progress");
				var addr=$(location).attr('href');
				var n = addr.indexOf("info");
				var choosedate=$('#dateshow').val();
				if (n>0){
					var url="{{ route('searchmainstock2') }}";
				}else{
					var url="{{ route('searchstock') }}";
				}

				$.get(url,{choosedate:choosedate},function(data){
					$("#table_data").empty().html(data);
					//$('#typesearch').attr('disabled',false);
					//$("body").css("cursor", "default");
					})
			})
			$(document).on('click','#btnprintstock2',function(e){
				e.preventDefault();
				var htp=window.location.protocol;
				var htn=window.location.hostname;
				var stockdate=$('#dateshow').val();
				var redirectWindow = window.open(htp+'//'+htn+'/stock/mainstock2/print?dd='+ stockdate, '_blank');
    			redirectWindow.location;
			})
			$(document).on('click','.btnviewstockproccess',function(e){
				e.preventDefault();
				var pid=$(this).data('id');
				var pcode=$(this).data('code');
				var pname=$(this).data('name');
				$('#modal_pid').text(pid);
				$('#modal_code').text(pcode);
				$('#modal_name').text(pname);
				var url="{{ route('showstockprocess') }}";
				var seldate=$('#dateshow').val();
				$.get(url,{showdate:seldate,pid:pid},function(data){
					//console.log(data)
					$('#stockprocess_modal').modal('show');
					$('#stockprocess').empty().html(data);
				})
			})
			$(document).on('click','.btnclosestock',function(e){
				e.preventDefault();
				$('#frmclosestock').trigger('reset');
				$('#closedate').val(moment(new Date()).format('DD-MM-YYYY'));
				var pid=$(this).data('id');
				var pcode=$(this).data('code');
				var pname=$(this).data('name');
				var unit=$(this).data('unit')
				var cost=$(this).data('cost');
				var cur=$(this).data('cur');
				var pstock=$(this).data('stock');
				$('#pid').val(pid);
				$('#pcode').val(pcode);
				$('#pname').val(pname);
				$('#stockqty').val(pstock);
				$('#unit').val(unit);
				$('#cost').val(formatNumber(cost));
				$('#cur').val(cur);
				$('#stockclose_modal').modal('show');
			})
			$(document).on('keyup','#stockqty,#cost',function(e){
				e.preventDefault();
				var amt=0;
				var qty=$('#stockqty').val();
				var cost=$('#cost').val().replace(/,/g,'');
				amt=parseFloat(qty) * parseFloat(cost);
				$('#stockamount').val(formatNumber(amt)+ ' ' + $('#cur').val()) ;
			})
			$(document).on('click','#btnsavestock',function(e){
				e.preventDefault();
				var url="{{ route('saveclosestock') }}";
				var data=$('#frmclosestock').serialize();
				$.post(url,data,function(data){
					console.log(data)
					if($.isEmptyObject(data.error)){
	                       //alert('Save Stock Completed')
	                       if(data.ext){
	                       		alert(data.ext)
	                       }else{
	                       		$('#stockclose_modal').modal('hide');
	                       		refresh();
	                       }

	                    }else{
	                        alert(data.error);
	                    }
				})
			})

			function refresh() {
				var viewby=$('#viewby').text();
	                       
               if(viewby.indexOf('Item Barcode')>=0){
               		$('#search_barcode').click();
               }
               else if(viewby.indexOf('Item Code')>=0){
               		$('#search_productcode').click();
               }
               else if(viewby.indexOf('Item')>=0){
               		$('#search_item').click();
               }
               else if(viewby.indexOf('Brand')>=0){
               		$('#search_brand').click();
               }
               else if(viewby.indexOf('Category')>=0){
               		$('#search_category').click();
               }
               else{
               		$('.btnsearchbydate').click();
               }
			}
			number('#stockqty');
			number('#cost');

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
			//ajax pagination
			function fetch_data(page,start_date,end_date,search_by,search_val) {
				$.ajax({
						
						url:"/purchase/pagination/fetch_data?page="+ page +"&start_date="+ start_date +"&end_date="+ end_date +"&search_by="+ search_by +"&search_val="+search_val,
						success:function(data)
						{
							$('#table_data').empty().html(data);
						}
					});
			}
			$(document).on('click','.pagination a',function(event){
				event.preventDefault();
				var start_date=$('#start_date').val();
				var end_date=$('#end_date').val();
				var page=$(this).attr('href').split('page=')[1];
				var search_by=$('#search_by').val();
				var search_val=$('#search_val').val();
				fetch_data(page,start_date,end_date,search_by,search_val);
			});

			$(document).on('change','#choosedate',function(e){
				var seldate=$(this).val();
				$('#dateshow').val(seldate);
				//$('#fillsearch').html('');
				//$('#typesearch').attr('disabled',true);
			})
			$(document).on('click','.btnremovestockprocess',function(e){
				e.preventDefault();
				var c=confirm("Do you want to remove this item from stock?");
				
				if(c==true){
					var m=$(this).data('mode');
					var dd=$(this).data('date');
					var pid=$('#modal_pid').text();
					var id=$(this).data('id');
					var url="{{ route('removestockprocess') }}";
					$.post(url,{pid:pid,id:id,dd:dd,mode:m},function(data){
						//console.log(data)
						if(data.success){
								var url="{{ route('showstockprocess') }}";
								var seldate=$('#dateshow').val();
								$.get(url,{showdate:seldate,pid:pid},function(data){
								$('#stockprocess').empty().html(data);
								refresh();
							});
						}else{
							alert('error')
						}
					})
				}
				
			})

		
		// function printContent(el)
		// {
		// 	  var restorpage=document.body.innerHTML;
		// 	  var printloc=document.getElementById(el).innerHTML;
		// 	  document.body.innerHTML=printloc;
		// 	  window.print();
		// 	  document.body.innerHTML=restorpage;
		// 	  var today=new Date();
		// 	  $('.colaction').css('display','block');
		// 	$('#dateshow').datetimepicker({
		// 		timepicker:false,
		// 		datepicker:true,
		// 		//value:'13-03-2020',
		// 		value:today,
		// 		//format:'H:i',
		// 		format:'d-m-yy',
		// 		autoclose:true,
		// 		todayBtn:true,
		// 		startDate:today,
		// 	});
		// }
	});
</script>