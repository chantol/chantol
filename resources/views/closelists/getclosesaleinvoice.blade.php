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
@foreach ($invoices as $key => $inv)
				<tr>
					<td style="width:50px;text-align:center;">
		                  {{ ++ $key }}
					</td>
					<td style="text-decoration: underline;"><a href="#" data-id="{{ $inv->id }}" data-supname="{{ $inv->supplier->name }}" data-totalinv="{{ $inv->total }}" data-cur="{{ $inv->cur }}" name="invnum[]" class="showinvdetail">{{ sprintf("%04d",$inv->id) }}</a> </td>
					<td style="display:none;">
						<input type="text" name="invnum[]" value="{{ $inv->id }}">
					</td>
					<td>{{ date('d-m-Y',strtotime($inv->invdate)) }}</td>
					<td>{{ date('d-m-Y h:i:sa',strtotime($inv->created_at)) }}</td>
					<td>{{ $inv->user->name }}</td>
					<td>{{ $inv->supplier->name }}</td>
					
					<td style="text-align:right;">{{ phpformatnumber($inv->subtotal) }} {{ $inv->cur }}</td>
					<td style="text-align:right;">{{ phpformatnumber($inv->shipcost) }} {{ $inv->cur }}</td>
					<td style="text-align:center;">{{ $inv->discount }} %</td>
					
					<td style="text-align:center;">{{ phpformatnumber($inv->total) }}</td>
					<td style="text-align:center;">{{ $inv->cur }}</td>
					<td style="text-align:center;text-decoration: underline;">
						<a href="#" data-id="{{ $inv->id }}" data-deposit="{{ $inv->deposit }}" data-cur="{{ $inv->cur }}" data-supname="{{ $inv->supplier->name }}" data-totalinv="{{ $inv->total }}" class="showpaiddetail">{{ phpformatnumber($inv->deposit) }}</a>
					</td>
					<td style="text-align:center;">{{ $inv->cur }}</td>
					<td style="text-align:center;">{{ phpformatnumber($inv->total-$inv->deposit) }}</td>
					<td style="text-align:center;">{{ $inv->cur }}</td>
					
					<td style="font-family:'Khmer Os System'">
							{{ $inv->p_paid }} %
					</td>
					<td style="text-align:center;">
						<a href="{{ route('purchaseprint',$inv->id) }}" class="btn btn-default btn-xs btnprint" title="print"><i class="fa fa-print"></i></a>
					</td>
					
				</tr>
			@endforeach