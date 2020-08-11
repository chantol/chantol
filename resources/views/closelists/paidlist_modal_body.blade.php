	 {{-- <div class="row">
                @php
                  $dp='0';
                  $buyinv='';
                  $supname='';
                  $totalinv='0';
                  $cur='';
                  if($pdt->count()>0){
                    if($pdt[0]->cur=='$'){
                      $dp=2;
                    }
                    $buyinv=$pdt[0]->sale_id;
                    $supname=$pdt[0]->sale->supplier->name;
                    $totalinv=$pdt[0]->sale->total;
                    $cur=$pdt[0]->cur;
                  }
                @endphp
                <div class="col-lg-3">
                  <label for="inv">Invoice#</label>
                  <input type="text" class="form-control" name="invnum" id="invnum" value="{{ sprintf("%04d",$buyinv) }}" readonly>
                </div>
                <div class="col-lg-6">
                  <label for="inv">Customer</label>
                  <input type="text" class="form-control" name="supname" id="supname" value="{{ $supname }}" readonly>
                </div>
                <div class="col-lg-3">
                  <div class="row"> 

                    <input type="hidden" class="form-control" name="totalinv" id="totalinv" value="{{ $totalinv }}" readonly style="text-align:right;">
                    <label for="inv">Total Paid</label>
                    <input type="text" class="form-control" name="tpaid" id="tpaid" readonly style="text-align:right;" value="{{ number_format($tpaid,$dp,'.',',') . ' ' . $cur }}">
                    
                  </div>
                  
                </div>
            </div> --}}
        	<input type="hidden" class="form-control" name="totalpaid" id="totalpaid" readonly style="text-align:right;" value="{{ $tpaid }}">
          
          <div class="table-responsive text-nowrap" style="overflow:scroll;">  
              <table class="table table-bordered table-hover">
              <thead>
                <tr style="text-align:center;">
                  <td>No</td>
                  
                  <td>Cashier</td>
                  <td>Date</td>
                  <td>Paid Amount</td>
                  <td>Note</td>
                  <td>Action</td>
                </tr>
              </thead>
              
              <tbody id="showpaiddetail">
                @php
                  function phpformatnumber($num){
                    $dc=0;
                    $p=strpos((float)$num,'.');
                    if($p>0){
                      $fp=substr($num,$p,strlen($num)-$p);
                      $dc=strlen((float)$fp)-2;
                      
                    }
                    return number_format($num,$dc,'.',',');
                  }
                @endphp
	                @foreach ($pdt as $key => $invd)
						      <tr>
      							<td style="text-align:center;">
      					         {{ ++ $key }}
      							</td>
      							
      							<td style="text-align:center;">
      								{{ $invd->user->name }}
      							</td>
      							
      							<td style="text-align:center;">{{ date('d-m-Y',strtotime($invd->dd)) }}</td>
      							
      							<td style="text-align:right;">
      								{{ phpformatnumber($invd->paidamt) . ' ' . $invd->cur}}
      							</td>

      							<td>{{ $invd->paynote }}</td>
      							<td style="width:30px;text-align:center;"><a href="#" data-id="{{ $invd->id }}" data-cur="{{ $invd->cur }}" class="btn btn-sm btn-warning btndelpaid" style="color:blue;"><i class="fa fa-trash-o"></i></a></td>
						      </tr>
					@endforeach
              </tbody>
          </table>
          </div>



