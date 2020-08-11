<div class="row">
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
			$buyinv=$pdt[0]->purchase_id;
			$supname=$pdt[0]->purchase->supplier->name;
			$totalinv=$pdt[0]->purchase->total;
			$cur=$pdt[0]->cur;
		}
	@endphp
            <div class="col-lg-3">
              <label for="inv">Invoice#</label>
              <input type="text" class="form-control" name="invnum" id="invnum" value="{{ sprintf("%04d",$buyinv) }}" readonly>
            </div>
            <div class="col-lg-6">
              <label for="inv">Supplier</label>
              <input type="text" class="form-control" name="supname" id="supname" value="{{ $supname }}" readonly>
            </div>
            <div class="col-lg-3">
              <input type="hidden" class="form-control" name="totalinv" id="totalinv" value="{{ $totalinv }}" readonly style="text-align:right;">
              <label for="inv">Total Paid</label>
              <input type="text" class="form-control" name="tpaid" id="tpaid" readonly style="text-align:right;" value="{{ number_format($tpaid,$dp,'.',',') . ' ' . $cur }}">
            </div>
          </div>
          <br>
          <div class="table-responsive text-nowrap" style="overflow:scroll;">  
              <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td>No</td>
                  <td>Cashier</td>
                  <td>Date</td>
                  <td>Paid Amount</td>
                  <td>Paid Note</td>
                  <td></td>
                </tr>
              </thead>
              
              <tbody id="showpaiddetail">
                @foreach ($pdt as $key => $invd)
					<tr>
						@php
							//$itotal=$inv->total + 0;//for convert 500.00 to 500

							if($invd->cur=="R"){
								$decimal=0;
							}else{
								$decimal=0;
							}
							
						@endphp
						
						<td style="text-align:center;">
				              {{ ++ $key }}
						</td>
						
						<td style="text-align:center;">
							{{ $invd->user->name }}
						</td>
						
						<td style="text-align:center;">{{ date('d-m-Y',strtotime($invd->dd)) }}</td>
						
						<td style="text-align:right;">
							{{ number_format($invd->paidamt,$decimal,'.',',') . ' ' . $invd->cur}}
						</td>

						<td>{{ $invd->paynote }}</td>
						<td><a href="#" data-id="{{ $invd->id }}" class="btn btn-sm btn-warning btndelpaid" style="color:blue;"><i class="fa fa-trash-o"></i></a></td>
					</tr>
				@endforeach
              </tbody>
          </table>
          </div>



