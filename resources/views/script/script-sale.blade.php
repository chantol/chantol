<script type="text/javascript">
		$(document).ready(function(){
			var today=new Date();
			$('#invdate').datetimepicker({
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
			$('#invdate1').datetimepicker({
					timepicker:false,
					//hours12:true,//false for 24 hour
					//step:5,//increase 5 minut
					//allowTimes:['01:00','01:15']
					datepicker:true,
					//value:'13-03-2020',
					
					//format:'H:i',
					format:'d-m-yy',
					autoclose:true,
					todayBtn:true,
					startDate:today,

				});


			//check if cap lock is on
   			//$('#message').hide();
			// $('.form-control').keypress(function(e) {
			//   var c = String.fromCharCode(e.which);
			//   if (c.toUpperCase() === c && c.toLowerCase() !== c && !e.shiftKey) {
			//     $('#message').show();
			//   } else {
			//     $('#message').hide();
			//   }

			$(document).on('change','#buyfrom',function(e){
				var url="{{ route('getbuyinv') }}";
				var sid=$(this).find(':selected').attr('data-id')
				
				$.get(url,{supid:sid},function(data){
					//console.log(data)
					$('#buyinv').find('option').remove();
					$.each(data,function(i,item){
						 $('#buyinv').append($('<option>', { 
					        value: item.id,
					        text : item.id 
					    }));
					 });
					$('#buyinv').append($('<option>', { 
					        value:"",
					        text :""
					    }));
				})
				totalbuyinv();
			})
			$(document).on('change','#buyinv',function(e){
				totalbuyinv();
				
			})
			function totalbuyinv() {
				var url="{{ route('getbuyinvtotal') }}";
				var buyinv=$('#buyinv').val();
				$.get(url,{buyinv:buyinv},function(data){
					//console.log(data)
					if(!$.trim(data)){
						$('#buytotal').val(0);
						$('#buycur').val('');
					}else{
						$('#buytotal').val(data[0].total);
						$('#buycur').val(data[0].cur);
					}
					
				})
			}
			document.onkeyup = function(e) {
				//alert(e.which)
			  if (e.ctrlKey && e.which == 39) {
			    $('#invdiscount').focus();
			  // } else if (e.ctrlKey && e.which == 66) {
			  //   alert("Ctrl + B shortcut combination was pressed");
			  // } else if (e.ctrlKey && e.altKey && e.which == 89) {
			  //   alert("Ctrl + Alt + Y shortcut combination was pressed");
			  // } else if (e.ctrlKey && e.altKey && e.shiftKey && e.which == 85) {
			  //   alert("Ctrl + Alt + Shift + U shortcut combination was pressed");
			  }
			};

			$('#sel_supplier').select2();
			$('#sel_delivery').select2();
			$('#sel_law').select2();
			$('#buyfrom').select2();

			$(document).on('keydown','.canenter',function(e){
				 if (e.keyCode == 13) {
			        var $this = $(this),
			        index = $this.closest('td').index();
			        $this.closest('tr').next().find('td').eq(index).find('input').focus().select();
			        e.preventDefault();
			    }
			})
			
			$(document).on('change','#sel_supplier',function(){
				var url="{{ route('getcusvalue') }}";
				var id=$(this).val();
				$.get(url,{id:id},function(data){
					//console.log(data)
					$('#lblcusname').text('អតិថិជន('+data.customerprice+')');
					$('#customervalue').val(data['customerprice']);
					
				})

			})
			 $(document).on('keydown','#customersearch',function(event){
		    
		    	if ( event.which == 13 ) 
		    	{
					event.preventDefault();
					var query=$(this).val();
					
		     		searchcustomer(query);
					$(this).focus();
					$(this).val('');
				}
		    });
			function searchcustomer(q) {
				var url="{{ route('searchcustomermodal') }}";
				$.get(url,{q:q},function(data){
					$('#tbl_customersearch').empty().html(data);
				})
			}
			$(document).on('click','#btnsearchcustomer',function(e){
				e.preventDefault();
				$('#searchcus_modal').modal('show');

				$('#customersearch').val('');
				
			})
			$('#searchcus_modal').on('shown.bs.modal', function () {
  				$('#customersearch').focus()
			})
			$(document).on('click','#btnrereshcusprice',function(e){
				e.preventDefault();
				refreshprice();
			})
			function refreshprice() {
				var cusval=$('#customervalue').val();
				var price=0;
				var qty=0;
				var dis=0;
				var amount=0;
				$('.unitprice').each(function(i,e){
					if(cusval=='Normal' || cusval==''){
						price=$(this).data('nprice');
					}else if(cusval=='Dealer'){
						price=$(this).data('dprice');
					}else if(cusval=='Member'){
						price=$(this).data('mprice');
					}else if(cusval=='VIP'){
						price=$(this).data('vprice');
					}else if(cusval=='Supper VIP'){
						price=$(this).data('svprice');
					}
					$('.unitprice').eq(i).val(formatNumber(parseFloat(price)));
					qty=$('.qty3').eq(i).val();
					dis=$('.discount').eq(i).val();
					amount=(qty * price) - (qty * price * dis)/100;
					$('.amount').eq(i).val(formatNumber(parseFloat(amount)));
				})
				Total();
			}
			$(document).on('click','.btnsavepurchase',function(e){
				e.preventDefault();
				var tbrow = document.getElementById("invoice_items").rows.length-4;
				if(tbrow==0){
					alert('No Order Found !')
				}else{
					var frmdata=$('#frmsale').serialize();
					var url="{{ route('storesale') }}"
					$.post(url,frmdata,function(data){
						//console.log(data)
						if($.isEmptyObject(data.error)){
	                        //alert(data.success);
	                        location.reload();
	                    }else{
	                        printErrorMsg(data.error);
	                    }
						
					})
				}
			})
		//-----------------------------------------------------
		
		$(document).on('click','.btnupdatesale',function(e){
			e.preventDefault();
			var tbrow = document.getElementById("invoice_items").rows.length-4;
			if(tbrow==0){
				alert('No Row Update Found !')
			}else{
				var frmdata=$('#frmsale').serialize();
				var url="{{ route('updatesale') }}"
				$.post(url,frmdata,function(data){
					console.log(data)
					if($.isEmptyObject(data.error)){
                        alert(data.success);
                        location.reload();
                    }else{
                        printErrorMsg(data.error);
                    }
					
				})
			}
		});

		$(document).on('click','.btnupdate-sale',function(e){
			e.preventDefault();
			var tbrow = document.getElementById("invoice_items").rows.length-4;
			if(tbrow==0){
				alert('No Row Update Found !')
			}else{
				var frmdata=$('#frmeditsale').serialize();
				var url="{{ route('updatesale') }}"
				$.post(url,frmdata,function(data){
					console.log(data)
					if($.isEmptyObject(data.error)){
                        alert(data.success);
                        location.reload();
                    }else{
                        printErrorMsg(data.error);
                    }
					
				})
			}
		});

		//-----------------------------------------------------
		function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
        $(document).on('click','.rowremove',function(e){
        	e.preventDefault();
        	var submit=$(this).data('submit');
        	if(submit==1){
        		alert('you can not remove this item.\ncause it already submit')
        	}else{
        		$(this).parent().parent().remove();
        		Total();
        	}
        })
        $(document).on('click','.rowedit',function(e){
        	e.preventDefault();
        	var row = $(this).closest('tr');
        	var rowind=row.find("td:eq(0)").text();
        	var pid=$(this).data('pid');
        	var dd=$('#dd').text();
        	var submit=$(this).data('submit');
        	
        	if(submit==1){
        		var c=confirm("Do you want to edit this item?");
	        	if(c==true){
	        		var url="{{ route('edititemaftersubmit') }}";
	        		$.post(url,{pid:pid,dd:dd},function(data){
	        			$('.qty1').eq(rowind-1).attr('readonly',false);
	        			$('.qty2').eq(rowind-1).attr('readonly',false);
	        			$('.unitprice').eq(rowind-1).attr('readonly',false);
	        			$('.focunit').eq(rowind-1).attr('readonly',false);
	        			$('.submit').eq(rowind-1).val(0);
	        		});
	        	}
        	}
        })
        function padrightzero(num, size) {
		    var s = num + "";
		    while (s.length < size){
		    	s = "0" + s;
		    } 
		    return s;
		}

		$(document).on('click','.btnedit',function(e){
			e.preventDefault();
			var invid_str='0';
			var invid=$(this).data('id');
			$('#btnsavepurchase').css('display','none');
			$('#btnclear').css('display','none');
			$('#btnupdatesale').css('display','block');
			$('#btnnewsale').css('display','block');
			if(invid<1000){
				var con_str='0000'.concat(invid);
				 invid_str=con_str.slice(con_str.length-4,con_str.length);
			}else{
				 invid_str=invid;
			}
			
			url="{{ route('editsaleinv') }}";
			$.get(url,{id:invid},function(data){

				$('#frmtitle').text('Sale Update');
				//$('#frmsale').attr('action'," route('updatesale')");
				$('#orderid').text('Inv#' + invid_str )
				$('#sale_id').val(invid);
				$('#carnum').val(data[0].carnum);
				$('#driver').val(data[0].driver);
				$('#lawfee').val(formatNumber(data[0].lawfee));
				$('#carfee').val(formatNumber(data[0].carfee));
				$('#totalweight').val(formatNumber(data[0].totalweight));
				$('#totaldelivery').val(formatNumber(data[0].totaldelivery));
				
				
				var invdate=new Date(data[0].invdate);
				var dd = String(invdate.getDate()).padStart(2, '0');
				var mm = String(invdate.getMonth() + 1).padStart(2, '0'); //January is 0!
				var yyyy = invdate.getFullYear();
				$('#invdate').val(dd +'-'+ mm + '-'+ yyyy);
				$('#dd').text(dd +'-'+ mm + '-'+ yyyy);
				
				//document.getElementById("sel_supplier").value = data[0].supplier_id;
				//document.getElementById("sel_delivery").value = data[0].delivery_id;
				var value=data[0].supplier_id;
				$('#sel_supplier').val(value);
				$('#sel_supplier').select2().trigger('change');
				
				var value1=data[0].delivery_id;
				$('#sel_delivery').val(value1);
				$('#sel_delivery').select2().trigger('change');
				
				var value2=data[0].law_id;
				$('#sel_law').val(value2);
				$('#sel_law').select2().trigger('change');
				
				var value3=data[0].buyfrom;
				$('#buyfrom').val(value3);
				$('#buyfrom').select2().trigger('change');
				//$('#buyinv').val(padrightzero(data[0].buyinv,4));
				$('#buyinv').val(data[0].buyinv);
				totalbuyinv();
				$('#invoice_items').empty();
				$.each(data,function(i,inv){
				
				readinvdetail(i+1,inv.product_id,inv.barcode,inv.name,inv.qty,inv.unit,inv.qtycut,inv.unitcut,inv.quantity,formatNumber(inv.unitprice-0),inv.discount1,formatNumber(inv.amount),inv.cur_detail,inv.multiunit,inv.qtyunit,inv.submit,inv.focunit,inv.sunit,inv.cost,inv.costcur);
				
					})
				appendtotal(c_format(data[0].subtotal-0,data[0].cur),c_format(data[0].shipcost-0,data[0].cur),data[0].discount,c_format(data[0].total-0,data[0].cur),data[0].cur,data[0].invnote);
				
			})
			
			//ResetNo();
		});
		
		function c_format(num,cur) {
			var decnum=0;
			if(cur=='$'){
				decnum=2;
			}
			return num.formatMoney(decnum,',','.');
		}

		function appendtotal(subtotal,shipcost,discount,total,cur,invdesr) {
			var rowtotal='<tr>'+
							'<td colspan=13 style="border:none;">Note:</td>'+
							'<td class="thick-line text-center"><strong>Subtotal</strong></td>'+
							'<td class="thick-line text-right" style="font-size:18px;padding:0px;">'+
	'<input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="subtotal" name="subtotal" value="'+ subtotal +'">'+
							'</td>'+
							'<td class="thick-line text-left subcur" style="font-size:18px;"><strong>'+ cur +'</strong></td>'+
							'</tr>'+
	    							'<tr>'+
	    								'<td colspan="13" style="border:none;padding:0px;"><input type="text" class="form-control" name="invnote" style="font-family:Khmer Os System;width:99%;height:40px;padding:8px;margin-left:5px;" value="'+ invdesr +'">'+
	    								'</td>'+
	    								'<td class="no-line text-center"><strong>Shipping</strong></td>'+
	    								'<td class="no-line" style="text-align:right;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="shipcost" name="shipcost" value="'+ shipcost +'"></td>'+
	    								'<td class="no-line shipcur" style="font-size:18px;"><strong>'+ cur +'</strong></td>'+
	    							'</tr>'+
	    							'<tr>'+
	    								'<td colspan="13" style="border:none;"></td>'+
	    								'<td class="no-line text-center"><strong>Discount</strong></td>'+
	    								'<td class="no-line" style="text-align:right;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="invdiscount" name="invdiscount" value="'+ discount +'"></td>'+
	    								'<td class="no-line" style="font-size:18px;"><strong>%</strong></td>'+
	    							'</tr>'+
	    							'<tr>'+
	    								'<td colspan="13" style="border:none;">'+
								                
	    								'</td>'+
	    								
	    								'<td class="no-line text-center"><strong>Total</strong></td>'+
	    								'<td class="no-line text-right" style="font-size:18px;padding:0px;"><input type="text" style="width:100%;height:40px;font-size:18px;border-style:none;text-align:right;padding:8px;" id="lasttotal" name="lasttotal" value="'+ total +'"></td>'+
	    								
	    								'<td class="no-line" style="font-size:18px;padding:0px;"><input type="text" style="width:50px;height:40px;font-size:18px;border-style:none;text-align:left;padding:8px;" name="lastcur" id="lastcur" value="'+ cur +'"></td>'+
	    							'</tr>';
	    							$('#invoice_items').append(rowtotal);

		}
		function readinvdetail(nn,pid,barcode,name,qty1,unit,qty2,unit2,qty3,unitprice,discount,amount,cur,multi,qtyunit,submit,focunit,itemunit,costprice,costcur) {
			var newrow='<tr>' +
						'<td class="no" style="text-align:center;padding:7px 0px 0px 0px;">'+ nn +'</td>'+
						'<td style="padding:0px;width:100px;">'+
						'<input type="text" class="form-control " name="productid[]" required style="border-style:none;width:100px;" value="'+ pid +'">'+
						'</td>'+
						'<td style="padding:0px;width:160px;">'+
						'<input type="text" class="form-control barcode" name="barcode[]" required style="border-style:none;width:160px;" value="'+ barcode +'">'+
						'</td>'+
						'<td style="padding:0px;width:250px;">'+
						'<input type="text" class="form-control name" name="name[]" required style="border-style:none;font-family:khmer os system;width:250px;" value="'+ name +'">'+
						'</td>'+

						'<td style="padding:0px;width:70px;">'+
						'<input type="text" class="form-control qty1 canenter" name="qty1[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="'+ qty1 +'">'+
						'</td>'+
						'<td style="padding:0px;width:50px;">'+
						'<input type="text" class="form-control unit1" name="unit1[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="'+ unit +'">'+
						'</td>'+

						'<td style="padding:0px;width:70px;">'+
						'<input type="text" class="form-control qty2 canenter" name="qty2[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="'+ qty2 +'">'+
						'</td>'+
						'<td style="padding:0px;width:50px;">'+
						'<input type="text" class="form-control unit2" name="unit2[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="'+ unit2 +'">'+
						'</td>'+

						'<td style="padding:0px;width:70px;">'+
						'<input type="text" class="form-control qty3" name="qty3[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="'+ qty3 +'">'+
						'</td>'+
						'<td style="padding:0px;width:50px;">'+
						'<input type="text" class="form-control unit3" name="unit3[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="'+ unit +'">'+
						'</td>'+

						'<td style="padding:0px;width:120px;">'+
						'<input type="text" class="form-control text-right unitprice canenter" name="unitprice[]" required '+'style="border-style:none;width:120px;" value="'+ unitprice +'">'+
						'</td>'+
						'<td style="padding:0px;width:40px;">'+
							'<select name="cur[]" class="form-control cur canenter" style="border-style:none;margin-top:0px;padding:0px;width:40px;" disabled>'+
								'<option value="R" class="a0">R</option>'+
								'<option value="B" class="a1">B</option>'+
								'<option value="$" class="a2">$</option>'+

							'</select>'+
						'</td>'+
						'<td style="padding:0px;width:80px;">'+
						'<input type="text" class="form-control discount canenter" name="discount[]" required style="border-style:none;text-align:center;width:80px;" value="'+ discount +'">'+
						'</td>'+
						'<td style="padding:0px;text-align:right; width:270px;" colspan=2>'+
						'<input type="text" class="form-control text-right amount" name="amount[]" required style="border-style:none;font-weight:bold;width:270px;" value="'+ amount +'">'+
						'</td>'+
						'<td style="padding:0px;width:50px">'+
						'<input type="text" class="form-control cur1" name="cur1[]" required style="border-style:none;width:50px;" value="'+ cur +'">'+
						'</td>'+
						'<td style="padding:0px;width:80px">'+
						'<input type="text" class="form-control focunit canenter" name="focunit[]" required style="border-style:none;width:80px;text-align:right;"​ value="'+ focunit +'">'+
						'</td>'+
						'<td style="padding:0px;width:60px">'+
						'<input type="text" class="form-control sunit" name="sunit[]" required style="border-style:none;width:60px;font-family:khmer os system;"​ value="'+ itemunit +'" readonly>'+
						'</td>'+
						'<td style="padding:0px;width:80px">'+
						'<input type="text" class="form-control multi" name="multi[]" required style="border-style:none;width:80px;"​ readonly value="'+ multi +'">'+
						'</td>'+
						// '<td style="padding:0px;width:80px">'+
						// '<input type="text" class="form-control qtyunit" name="qtyunit[]" required style="border-style:none;width:80px;" readonly value="'+ qtyunit +'">'+
						// '</td>'+
						'<td style="padding:0px;width:80px">'+
						'<input type="text" class="form-control submit" name="submit[]" required style="border-style:none;width:80px;" readonly value="'+ submit +'">'+
						'</td>'+
						'<td style="padding:0px;width:80px;">'+
						'<input type="text" class="form-control costprice" name="costprice[]" required style="border-style:none;width:80px;" readonly value="'+ formatNumber(costprice) +'">'+
						'</td>'+
						'<td style="padding:0px;width:80px;">'+
						'<input type="text" class="form-control costcur" name="costcur[]" required style="border-style:none;width:80px;" readonly value="'+ costcur +'">'+
						'</td>'+
						'<td style="text-align:center;padding:0px;">'+
							'<a href="#" class="btn btn-warning btn-xs rowedit" style="color:blue;margin-top:5px;margin-right:5px;" data-pid="'+ pid +'"'+
							'data-submit="'+ submit +'"><i class="fa fa-pencil"></i></a>'+
							'<a href="#" class="btn btn-danger btn-xs rowremove" style="margin-top:5px;"><i class="fa fa-minus" data-submit="'+ submit +'"></i></a>'+
						'</td>'+
					'</tr>';

					$('#invoice_items').append(newrow);
					
					if(submit==1){

						$('.qty1').eq(nn-1).attr('readonly',true);
						$('.qty2').eq(nn-1).attr('readonly',true);
						$('.focunit').eq(nn-1).attr('readonly',true);
						$('.unitprice').eq(nn-1).attr('readonly',true);
							
					}
					
					$('.cur').val(cur);

		}

		$('#add_supplier').on('click',function(){
			$('#supplier_modal').modal('show');
		});
		$('#add_delivery').on('click',function(){
			$('#delivery_modal').modal('show');
		});
		$('#add_co').on('click',function(){
			$('#co_modal').modal('show');
		});
		//------------------------------------------
		$('#frm_supplier').on('submit',function(e){
			e.preventDefault();
			var data=$(this).serialize();
			var url="{{ route('postsupplierinsale') }}";
			$.post(url,data,function(result){
				if(result){
					$('#sel_supplier').append($("<option/>",{
						value:result.id,
						text:result.name
					}))
					$('#frm_supplier').trigger("reset");
					$('#supplier_modal').modal('hide');
				}else{
					alert('no data return')
				}
				
			});
		});
		//------------------------------------------------------
		$('#frm_co').on('submit',function(e){
			e.preventDefault();
			var data=$(this).serialize();
			var url="{{ route('postco') }}";
			$.post(url,data,function(result){
				console.log(result)
				if(result){
					$('#sel_law').append($("<option/>",{
						value:result.id,
						text:result.name
					}))
					$('#frm_co').trigger("reset");
					$('#co_modal').modal('hide');
				}else{
					alert('no data return')
				}
				
			});
		});
		//------------------------------------------------------
			$('#frm_delivery').on('submit',function(e){
				e.preventDefault();
				var data=$(this).serialize();
				var url="{{ route('postdelivery') }}";
				$.post(url,data,function(result){
					if(result){
						$('#sel_delivery').append($("<option/>",{
							value:result.id,
							text:result.name
						}))
						$('#frm_delivery').trigger("reset");
						$('#delivery_modal').modal('hide');
					}else{
						alert('no data return')
					}
					
				});
			});
		//-----------------------------------------------------------
		$(document).on('click','.btnsearchproduct',function(e){
			e.preventDefault();
			$('#ProductSearchModal').modal('show');
		})

		$(document).on('click','.btnsearchproduct1',function(e){
			e.preventDefault();
			$('#additem_modal').modal('show');

		})
		$('#additem_modal').on('shown.bs.modal', function () {
		    $('#acode').focus();
		})  	
		      //-----------------------------
		  $('tbody').delegate('#shipcost,#invdiscount','keyup',function(){
		  		var decpl=0;
		  		var cur=$('.lastcur').text();
		  		if(cur=='$'){
		  			decpl=2;
		  		}
		  		var subtotal=$('#subtotal').val();
				var shipcost=$('#shipcost').val();
				var invdis=$('#invdiscount').val();
				var sub1=subtotal.replace(/,/g,'');
				var ship1=shipcost.replace(/,/g,'');
				var t1=eval(Number(sub1)+Number(ship1));
				var amtdis=(t1 * invdis)/100;
				
				var lasttotal= t1 - amtdis ;
				$('#lasttotal').val(lasttotal.formatMoney(decpl,',','.'));
		  });
		  $('tbody').delegate('.qty1,.qty2,.qty3,.unitprice,.discount,.unit2','keyup',function(){
		  		var decpl=0;
		  		var qty3=0;
				var tr=$(this).parent().parent();
				var cur=tr.find('.cur1').val();
				var qty1=tr.find('.qty1').val();
				var qty2=tr.find('.qty2').val();
				var unit2=tr.find('.unit2').val();
				if(unit2=='%'){
					qty3=qty1 - (qty1 * qty2)/100;
				}else{
					qty3=qty1-qty2;
				}
				//var multi=tr.find('.multi').val();
				tr.find('.qty3').val(qty3);
				
				var price=tr.find('.unitprice').val().replace(/,/g,'');
				var dis=tr.find('.discount').val();
				var amount=(qty3 * price) - (qty3 * price * dis)/100;
				// var qtyunit=multi * qty3;
				// tr.find('.qtyunit').val(qtyunit);
				//tr.find('.amount').val(amount.formatMoney(decpl,',','.'));
				tr.find('.amount').val(formatNumber(amount));
				Total();
			});
		  function Total(){
				var total=0;
				var cur='';
				var cur1='';
				var totalweight=0;
				//var decpl=0;
				$('.amount').each(function(i,e){
					var stramount=$(this).val();
					amount=stramount.replace(/,/g,'')-0;
					tweight =$('.qty3').eq(i).val();
					total +=amount;
					totalweight +=parseFloat(tweight);
					cur=$('.cur1').eq(i).val();
					if(i>0){
						cur1=$('.cur1').eq(i-1).val();
						if(cur1 != cur){
							alert('This invoice has many currency.')
						}
					}
				})
				// if(cur=='$'){
				// 	decpl=2;
				// }
				var tdr=totalweight * $('#carfee').val().replace(/,/g,'');
				$('#totalweight').val(totalweight);
				$('#totaldelivery').val(formatNumber(tdr));
				//$('#subtotal').val(total.formatMoney(decpl,',','.'));
				$('#subtotal').val(formatNumber(total));
				$('.subcur').html('<strong>' + cur +'</strong>');
				var subtotal=$('#subtotal').val();
				var shipcost=$('#shipcost').val();
				var invdis=$('#invdiscount').val();
				var sub1=subtotal.replace(/,/g,'');
				var ship1=shipcost.replace(/,/g,'');
				var t1=eval(Number(sub1)+Number(ship1));
				var amtdis=(t1 * invdis)/100;
				
				var lasttotal= t1 - amtdis ;
				$('#lasttotal').val(formatNumber(lasttotal));
				$('#lastcur').val(cur);
				$('.shipcur').html('<strong>' + cur +'</strong>');
				dodeposit();
			}
			$(document).on('input','#deposit',function(e){
				dodeposit();
			})
			function dodeposit() {
				var lasttotal=$('#lasttotal').val().replace(/,/g,'');
				var dp=$('#deposit').val();
				var bl=parseFloat(lasttotal)-parseFloat(dp);
				$('#lastbal').val(formatNumber(bl));
			}
			$(document).on('blur','#deposit',function(e){
				$('#deposit').val(formatNumber($('#deposit').val().replace(/,/g,'')));
			})
			Number.prototype.formatMoney=function(decPlaces,thouSeparator,decSeparator){
				var n=this,
				decPlaces=isNaN(decPlaces=Math.abs(decPlaces)) ? 2 : decPlaces,
				decSeparator=decSeparator==undefined ? "." : decSeparator,
				thouSeparator=thouSeparator==undefined ? "," : thouSeparator,
				sign = n < 0 ? "-" : "",
				i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
				j = (j = i.length) > 3 ? j % 3 : 0;
				return sign + (j ? i.substr(0,j) + thouSeparator : "")
				+ i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator)
				+(decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");


			}
		   //-------search barcode
		   $(document).on('keydown','.barcode_search',function(event){
		    
		    	if ( event.which == 13 ) 
		    	{
					event.preventDefault();
					var query=$(this).val();
					
		     		searchbarcode(query);
					$(this).focus();
					$(this).val('');
				}
		    });
		   

		 function searchbarcode(q='',qty='1',pri='0'){
		      	
		        $.ajax({
		          url:"{{ route('sale.barcode.search') }}",
		          method:"GET",
		          data:{barcode:q},
		          dataType:'json',
		          success:function(data){
		          	if(data){
		          		var price='0';
		          		var cusval=$('#customervalue').val();
		          		if(pri==0){
		          			if(cusval=='Normal' || cusval==''){
		          				price=data.price;
		          			}else if(cusval=='Dealer'){
		          				price=data.dealer;
		          			}else if(cusval=='Member'){
		          				price=data.member;
		          			}else if(cusval=='VIP'){
		          				price=data.vip;
		          			}else if(cusval=='Supper VIP'){
		          				price=data.suppervip;
		          			}
		          			
		          		}else{
		          			price=pri;
		          		}
		          		var buyinv=$('#buyinv').val();
		          		var cost=data.costprice;
		          		var costcur=data.pcur;
		          		if(buyinv !=''){
		          			var url4="{{ route('getcostfrombuyinv') }}";
		          			$.get(url4,{buyinv:buyinv,pid:data.product_id},function(data4){
		          				if(!$.trim(data4)){

		          				}else{
		          					cost=data4[0].buycost;
		          				 	costcur=data4[0].cur;
		          				}
		          				console.log(data4)
		          				
		          				
		          			})
		          		}
		          		var newrow='<tr>' +
						'<td class="no" style="text-align:center;padding:7px 0px 0px 0px;">1</td>'+
						'<td style="padding:0px;width:100px;">'+
						'<input type="text" class="form-control " name="productid[]" required style="border-style:none;width:100px;" value="'+ data.product_id +'">'+
						'</td>'+
						'<td style="padding:0px;width:160px;">'+
						'<input type="text" class="form-control barcode" name="barcode[]" required style="border-style:none;width:160px;" value="'+ data.barcode +'">'+
						'</td>'+
						'<td style="padding:0px;width:250px;">'+
						'<input type="text" class="form-control name" name="name[]" required style="border-style:none;font-family:khmer os system;width:250px;" value="'+ data.name +'">'+
						'</td>'+

						'<td style="padding:0px;width:70px;">'+
						'<input type="text" class="form-control qty1 canenter" name="qty1[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="'+ qty +'" autocomplete="off">'+
						'</td>'+
						'<td style="padding:0px;width:50px;">'+
						'<input type="text" class="form-control unit1" name="unit1[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="'+ data.unit +'">'+
						'</td>'+

						'<td style="padding:0px;width:70px;">'+
						'<input type="text" class="form-control qty2 canenter" name="qty2[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="0">'+
						'</td>'+
						'<td style="padding:0px;width:50px;">'+
						'<input type="text" class="form-control unit2" name="unit2[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="'+ data.unit +'">'+
						'</td>'+

						'<td style="padding:0px;width:70px;">'+
						'<input type="text" class="form-control qty3" name="qty3[]" required style="border-style:none;padding:0px;text-align:center;width:70px;" value="'+ qty +'" readonly>'+
						'</td>'+
						'<td style="padding:0px;width:50px;">'+
						'<input type="text" class="form-control unit3" name="unit3[]" required style="border-style:none;padding:0px;text-align:center;font-family:khmer os system;width:50px;" value="'+data.unit +'">'+
						'</td>'+

						'<td style="padding:0px;width:120px;">'+
						'<input type="text" class="form-control text-right unitprice canenter allownumericwithdecimal" name="unitprice[]" required '+'style="border-style:none;width:120px;" value="'+ formatNumber(parseFloat(price)) +'" data-nprice="'+ data.price +'" data-dprice="'+ data.dealer +'" data-mprice="'+ data.member +'" data-vprice="'+ data.vip +'" data-svprice="'+ data.suppervip +'">'+
						'</td>'+
						'<td style="padding:0px;width:40px;">'+
							'<select name="cur[]" class="form-control cur canenter" style="border-style:none;margin-top:0px;padding:0px;width:40px;">'+
								'<option value="R" class="a0">R</option>'+
								'<option value="B" class="a1">B</option>'+
								'<option value="$" class="a2">$</option>'+

							'</select>'+
						'</td>'+
						'<td style="padding:0px;width:80px;">'+
						'<input type="text" class="form-control discount canenter" name="discount[]" required style="border-style:none;text-align:center;width:80px;" value="0">'+
						'</td>'+
						'<td style="padding:0px;text-align:right; width:270px;" colspan=2>'+
						'<input type="text" class="form-control text-right amount" name="amount[]" required style="border-style:none;font-weight:bold;width:270px;" value="'+ formatNumber(parseFloat(price) * parseFloat(qty)) +'">'+
						'</td>'+
						'<td style="padding:0px;width:50px">'+
						'<input type="text" class="form-control cur1" name="cur1[]" required style="border-style:none;width:50px;font-weight:bold;" value="R">'+
						'</td>'+
						'<td style="padding:0px;width:80px">'+
						'<input type="text" class="form-control focunit canenter" name="focunit[]" required style="border-style:none;width:80px;text-align:right;"​ value="0">'+
						'</td>'+
						'<td style="padding:0px;width:60px">'+
						'<input type="text" class="form-control sunit" name="sunit[]" required style="border-style:none;width:60px;font-family:khmer os system;"​ value="'+ data.itemunit +'" readonly>'+
						'</td>'+
						'<td style="padding:0px;width:80px">'+
						'<input type="text" class="form-control multi" name="multi[]" required style="border-style:none;width:80px;"​ readonly value="'+ data.multiple +'">'+
						'</td>'+
						// '<td style="padding:0px;width:80px">'+
						// '<input type="text" class="form-control qtyunit" name="qtyunit[]" required style="border-style:none;width:80px;" readonly value="'+ data.multiple +'">'+
						// '</td>'+
						'<td style="padding:0px;width:80px">'+
						'<input type="text" class="form-control submit" name="submit[]" required style="border-style:none;width:80px;" value="0" readonly>'+
						'</td>'+
						'<td style="padding:0px;width:80px;">'+
						'<input type="text" class="form-control costprice" name="costprice[]" required style="border-style:none;width:80px;" value="'+ formatNumber(cost) +'" readonly>'+
						'</td>'+
						'<td style="padding:0px;width:80px;">'+
						'<input type="text" class="form-control costcur" name="costcur[]" required style="border-style:none;width:80px;" value="'+ costcur +'" readonly>'+
						'</td>'+
						'<td style="text-align:center;padding:0px;">'+
							'<a href="#" class="btn btn-warning btn-xs rowedit" style="color:blue;margin-top:5px;margin-right:5px;"><i class="fa fa-pencil"></i></a>'+
							'<a href="#" class="btn btn-danger btn-xs rowremove" style="margin-top:5px;"><i class="fa fa-minus"></i></a>'+
						'</td>'+
					'</tr>';
						var appendrow=CheckExistBarcode(data.barcode,qty);
						//alert(appendrow)
						if(appendrow==0)
						{
							$('#invoice_items').prepend(newrow);
							$('.cur').eq(0).val(data.cur);
						 	$('.cur1').eq(0).val(data.cur)
						 	$('.subcur').html('<strong>'+ data.cur +'</strong>')
						 	$('.shipcur').html('<strong>'+ data.cur +'</strong>')
						 	$('#lastcur').val(data.cur)
    			 			//if(data.cur==0){
							// 	$('.cur').eq(0).find('.a0').attr('selected',true)
							// 	$('.cur1').eq(0).val('R')
							// 	$('.subcur').html('<strong>R</strong>')
							// 	$('.shipcur').html('<strong>R</strong>')
							// 	$('#lastcur').val('R')
							// }else if(data.cur==1){
							// 	$('.cur').eq(0).find('.a1').attr('selected',true)
							// 	$('.cur1').eq(0).val('B')
							// 	$('.subcur').html('<strong>B</strong>')
							// 	$('.shipcur').html('<strong>B</strong>')
							// 	$('#lastcur').val('B')
							// }else{
							// 	$('.cur').eq(0).find('.a2').attr('selected',true)
							// 	$('.cur1').eq(0).val('$')
							// 	$('.subcur').html('<strong>$</strong>')
							// 	$('.shipcur').html('<strong>$</strong>')
							// 	$('#lastcur').val('$')
							// }
    						ResetNo();
    						Total();
    					}
					

		          	}else
		          	{
		          		alert('This barcode not found.');
		          	}
		            console.log(data);
		            // $("#catlist").html(data.table_data);
		            // $("#total_record").text(data.total_data);
		          }
		        });
		      }

		     
				
		      function CheckExistBarcode(barcode,qty)
		      {
		      	var found=0;
		      	$('.barcode').each(function(i,e){
		      		var bc=$(this).val();
		      		var submitval=0;
					if(bc==barcode){
						submitval=$('.submit').eq(i).val();
						found=1;
						if(submitval==1){
							alert('this item already submit.')
							return false;
						}
						
						var k=$('.qty1').eq(i).val();
						var cut=$('.qty2').eq(i).val();
						//var multi=$('.multi').eq(i).val();
						k =parseFloat(k)+parseFloat(qty);
						$('.qty1').eq(i).val(k);
						$('.qty3').eq(i).val(k-cut);
						var qty3=$('.qty3').eq(i).val();
						var price=$('.unitprice').eq(i).val();
						var dis=$('.discount').eq(i).val();
						var amount=(qty3 * price) - (qty3 * price * dis)/100;
						$('.amount').eq(i).val(formatNumber(amount));
						// var qtyunit=multi * qty3;
						// $('.qtyunit').eq(i).val(qtyunit);
						Total();
						
						return false;

					}
				});
				
				return found;
		      }

		      $(document).on('change','.cur',function(e){
		      	$('.cur').val($(this).val());
		      	$('.cur1').val($(this).val());
		      	$('.subcur').html('<strong>'+ $(this).val() +'</strong>');
		      	$('.shipcur').html('<strong>'+ $(this).val() +'</strong>');
		      	$('#lastcur').val($(this).val());
		      })

		 function ResetNo(){
			$('.no').each(function(i,e){
				$(this).text(i+1);
			})
		}
		function RemoveAllRow(){
			var l=$('#tbl_barcode tr').length;
			$('.remove').each(function(i,e){
				$(this).parent().parent().remove();	
			});
		}
//-----------------------
		$('.remove').live('click',function(){
			$(this).parent().parent().remove();
			ResetNo();
			Total();
	});

		function searchproduct($q=''){
        $.ajax({
          url:"{{ route('saleproductsearch') }}",
          method:"GET",
          data:{query:$q},
          dataType:'json',
          success:function(data){
            //console.log(data);
            $("#product_search_table").html(data.table_data);
            
          }
        });
      }
      $(document).on('keyup','#search',function(event){
		    var query=$(this).val();
        	searchproduct(query);
      });

      $(document).on('click','.selproduct',function(e){
      	e.preventDefault();
      	var pbarcode=$(this).data('barcode');
      	var pid=$(this).data('id');
      	var key=$(this).data('key');
      	var qty=$('#qty'+pid+''+key).val();
      	//alert(qty)
      	if(qty==''){
      		qty=1;
      	}
      	searchbarcode(pbarcode,qty);
      	$(this).text('Added');
      })

       $(document).on('click','#tbl-cus tbody tr',function(e){
       		e.preventDefault();
       		var row=$(this).closest('tr');
       		var id=row.find('td:eq(1)').text();
       		$('#sel_supplier').val(id);
       		$('#sel_supplier').select2().trigger('change');
       		$('#searchcus_modal').modal('hide');
       })
        


      //delete invoice
      
      var pr_id;
      $(document).on('click','.btndelinv',function(e){
        e.preventDefault();
        pr_id=$(this).data('id');//or =$(this).attr('id');
        $("#modalConfirmDelete").modal('show');
        $('#click_loc').val(1);
      });
      $(document).on('click','.btndel-purchase',function(e){
        e.preventDefault();
        pr_id=$(this).data('id');//or =$(this).attr('id');
        $("#modalConfirmDelete").modal('show');
        $('#click_loc').val(2);
      });
      $("#btn_delete").click(function(){
      	var click_loc=$('#click_loc').val();
         $.ajax({
            type:"POST",
            url:"{{ route('destroysale') }}",
            data:{id:pr_id},
            success:function(data){
              $("#btn_closeconfirm").click();
              if(click_loc==1){
              	location.reload();
              }else if(click_loc==2){
              	window.close();
              }
            }
          });
      });

      $(document).on('click','.btnnew',function(e){
      	e.preventDefault();
      	location.reload();
      })
     
     $(document).on('keyup','#searchcat',function(e){
                var url="{{ route('searchcategory') }}";
                var q=$(this).val();
                $.get(url,{q:q},function(data){
                    $('#categoryinmodal').empty().html(data);
                })
            })

      //----------------------------------
      findRowNumOnly('.qty1');
      findRowNumOnly('.qty2');
	  findRowNum('.unitprice',false);
	  findRowNum('.discount',true);
	  number('#lawfee',true);
	  number('#carfee',true);
	  number('#buyinv',true);
	  number('#deposit',true);
	  $(document).on('change','.number-separator',function(e){
	  	$(this).val(formatNumber($(this).val()));
	  })
	  $(document).on('input','.carfee,.totalweight',function(e){

	  	var cf=$('.carfee').val().replace(/,/g,'');
	  	var tw=$('.totalweight').val();
	  	var ttw=cf*tw;
	  	$('#totaldelivery').val(formatNumber(ttw));
	  	
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

 	 $(document).on('click','.catname',function(e){
		e.preventDefault();
		var catid=$(this).data('id');
		//alert(catid)
		var url="{{ route('saleproductsearch') }}";
		$.get(url,{category:catid},function(data){
			//console.log(data)
			$("#product_search_table").html(data.table_data);
		})
	})

 	 $('.accordion-toggle').click(function(){
			$('.hiddenRow').hide();
			$(this).next('tr').find('.hiddenRow').show();
		});

 	 // $(document).on('input','#acode',function(e){
 	 // 	var url=" route('searchitemcode')";
 	 // 	var code=$(this).val();
 	 // 	clearadditem();
 	 // 	$.get(url,{code:code},function(data){
 	 // 		$('#aname').val(data[0].name);
 	 // 		$('#abarcode').val(data[0].barcode);
 	 // 		$('#aprice').val(formatNumber(data[0].price) + ' ' + data[0].cur);
 	 // 		$('#acur').val(data[0].cur);
 	 // 		$.each(data,function(i,item){
 	 // 			var unit_val=item.barcode;
 	 // 			var unit_text=item.unit;
 	 // 			$('#aunit').append('<option class="opunit" value="'+ unit_val +'" data-price="'+ item.price +'" data-cur="'+ item.cur +'">'+ unit_text +'</option>');
 	 // 		})
 	 // 		//console.log(data)
 	 // 	})
 	 // })
 	 function clearadditem(argument) {

 	 	$('#aunit option').remove();
 	 	$('#abarcode').val('');
 	 	$('#aname').val('');
 	 	$('#aprice').val('');
 	 	$('#aqty').val('');
 	 	$('#aamount').val('');
 	 }
//------------------------------
 	var selection = document.getElementById("aunit");
	selection.onchange = function(event){

	var pri = event.target.options[event.target.selectedIndex].dataset.price;
	var cur = event.target.options[event.target.selectedIndex].dataset.cur;
	var barcode= event.target.options[event.target.selectedIndex].value;
	$('#abarcode').val(barcode);
	$('#aprice').val(formatNumber(pri) + ' ' + cur);
	$('#acur').val(cur);
	TotalAmt();
	};

	$(document).on('input','#aqty,#aprice',function(e){
		TotalAmt();
	})
	function TotalAmt(argument) {
		var qty=$('#aqty').val();
		var pri=$('#aprice').val().replace(/,/g,'').replace('R','').replace('B','').replace('$','');
		var amt=qty * pri;
		$('#aamount').val(formatNumber(amt)+' ' + $('#acur').val());
	}
	number('#aqty',true);
	number('#aprice',true);

	$(document).on('click','.btn_add_item',function(e){
		e.preventDefault();
		var pbarcode=$('#abarcode').val();
      	var qty=$('#aqty').val();
      	var pri=$('#aprice').val().replace(',','').replace('R','').replace('B','').replace('$','');
      	if(qty==''){
      		qty=1;
      	}
      	searchbarcode(pbarcode,qty,pri);
      	clearadditem();
      	$('#acode').val('');
      	$('#acode').focus();
	})

	 $(document).on('keydown','#acode',function(event){
		    	if ( event.which == 13 ) 
		    	{
					event.preventDefault();
					var price=0;
					var price1=0;
					var cusval=$('#customervalue').val();
					var url="{{ route('searchitemcode') }}";
 	 				var code=$(this).val();
 	 				clearadditem();

 	 				$.get(url,{code:code},function(data){
 	 					console.log(data)
 	 					if(data){
 	 						if(cusval=='Normal' || cusval==''){
		          				price=data[0].price;
		          			}else if(cusval=='Dealer'){
		          				price=data[0].dealer;
		          			}else if(cusval=='Member'){
		          				price=data[0].member;
		          			}else if(cusval=='VIP'){
		          				price=data[0].vip;
		          			}else if(cusval=='Supper VIP'){
		          				price=data[0].suppervip;
		          			}
	 	 					$('#aname').val(data[0].name);
	 	 					$('#abarcode').val(data[0].barcode);
	 	 					$('#aprice').val(formatNumber(price) + ' ' + data[0].cur);
	 	 					$('#acur').val(data[0].cur);
				 	 		$.each(data,function(i,item){
				 	 			var unit_val=item.barcode;
				 	 			var unit_text=item.unit;
				 	 			if(cusval=='Normal' || cusval==''){
			          				price1=item.price;
			          			}else if(cusval=='Dealer'){
			          				price1=item.dealer;
			          			}else if(cusval=='Member'){
			          				price1=item.member;
			          			}else if(cusval=='VIP'){
			          				price1=item.vip;
			          			}else if(cusval=='Supper VIP'){
			          				price1=item.suppervip;
			          			}
				 	 			$('#aunit').append('<option class="opunit" value="'+ unit_val +'" data-price="'+ price1 +'" data-cur="'+ item.cur +'">'+ unit_text +'</option>');
				 	 		})
 	 					}
					})

					$('#aqty').focus();
		    	}
		})
	 $(document).on('keydown','#aqty',function(event){
	 	if(event.which==13){
	 		event.preventDefault();
	 		$('.btn_add_item').focus();
	 	}
	 })
//move modal javascript
	$('.modaldraggable').draggable({
    	//cursor: 'move',
    	//handle: '.modal-header'
	});
 	$('.modaldraggable').css('cursor', 'move');

 });
</script>