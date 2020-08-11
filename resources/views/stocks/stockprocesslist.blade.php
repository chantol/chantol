@php
	$costprice=0;
	$p=0;
	$stockbal='';
	$stockbalunit=0;
	$stockbalamt=0;
	function phpformatnumber($num){
      $dc=0;
      $p=strpos((float)$num,'.');
      if($p>0){
        $fp=substr($num,$p,strlen($num)-$p);
        $dc=strlen((float)$fp)-2;
        
      }
      if($dc>2){
      	$dc=2;
      }
      
      return number_format($num,$dc,'.',',');
    }
@endphp
@foreach ($stockprocess as $key => $sp)
	
	@php
		$costprice=$sp->product->costprice;
		$amount=$costprice * $sp->quantity;
		$stockbalunit +=$sp->quantity;
		$stockbal= App\Sale_Detail::convertqtysale($sp->product_id,$stockbalunit);
		$stockbalamt=$costprice * $stockbalunit;
	@endphp
	<tr style="text-align:center;">
		<td>{{ ++ $key }}</td>
		<td>{{ date('d-m-Y',strtotime($sp->dd)) }}</td>
		<td>{{ $sp->user->name }}</td>
		<td>{{ $sp->mode }}</td>
		<td>{{ $sp->desr }}</td>
		<td style="font-family:khmer os system;">
			{{ App\Sale_Detail::convertqtysale($sp->product_id,$sp->quantity) }}
		</td>
		<td style="font-family:khmer os system;">{{ $sp->quantity . ' ' . $sp->unit }}</td>
		<td>{{ phpformatnumber($costprice)}} {{ $sp->cur }}</td>
		<td>{{ phpformatnumber($amount) }} {{ $sp->cur }}</td>
		<td style="font-family:khmer os system;">{{ $stockbal }}</td>
		<td>{{ phpformatnumber($stockbalamt) . $sp->cur }}</td>
		<td>
			<a href="#" class="btn btn-danger btn-sm btnremovestockprocess" data-id="{{ $sp->id }}" data-date="{{ $sp->dd }}" data-mode="{{ $sp->mode }}">Remove</a>
		</td>
	</tr>
@endforeach