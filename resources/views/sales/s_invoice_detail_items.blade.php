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
		<td style="width:50px;text-align:center;">
              {{ ++ $key }}
		</td>
		<td style="text-align:center;">{{ $invd->barcode }}</td>
		<td style="font-family:khmer os system">{{ $invd->product->name }}</td>
		<td style="text-align:center;font-family:khmer os system;">{{ $invd->qty . ' ' . $invd->unit }}</td>
		<td style="text-align:center;font-family:khmer os system;">{{ $invd->qtycut . ' ' . $invd->unit }}</td>
		<td style="text-align:center;font-family:khmer os system;">{{ $invd->quantity . ' ' . $invd->unit }}</td>

		<td style="text-align:right;">
			{{ phpformatnumber($invd->unitprice) . ' ' . $invd->cur}}
		</td>

		<td style="text-align:center;">
			{{ $invd->discount . '%'}}
		</td>
		<td style="text-align:right;">
			{{ phpformatnumber($invd->amount) . ' ' . $invd->cur}}
		</td>
		
		<td style="text-align:center;font-family:khmer os system;">
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