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
		
		<td style="width:50px;text-align:center;">
              {{ ++ $key }}
		</td>
		<td style="text-align:center;">{{ $invd->barcode }}</td>
		<td style="font-family:khmer os system">{{ $invd->product->name }}</td>
		<td style="text-align:center;">{{ $invd->qty . ' ' . $invd->unit }}</td>
		<td style="text-align:center;">{{ $invd->qtycut . ' ' . $invd->unit }}</td>
		<td style="text-align:center;">{{ $invd->quantity . ' ' . $invd->unit }}</td>

		<td style="text-align:right;">
			{{ number_format($invd->unitprice,$decimal,'.',',') . ' ' . $invd->cur}}
		</td>

		<td style="text-align:center;">
			{{ $invd->discount . '%'}}
		</td>
		<td style="text-align:right;">
			{{ number_format($invd->amount,$decimal,'.',',') . ' ' . $invd->cur}}
		</td>
		
		<td style="text-align:center;">
			{{ $invd->focunit . ' ' . $invd->sunit }}
		</td>
		
		<td style="font-family:khmer os system;text-align:center;">
			{{ $invd->submit==0?'នៅ':'រួចរាល់' }}
		</td>
		<td>
			{{ $invd->submit==1?date('d-m-Y',strtotime($invd->submitdate)):'' }}
		</td>
	</tr>
@endforeach