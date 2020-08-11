@php
	$cur='';
	$p=0;
@endphp
@foreach ($barcodelist as $key => $bl)
	@php
		if($bl->cur==0){
			$cur='R';
			$p=0;
		}else if($bl->cur==1){
			$cur='B';
			$p=0;
		}else{
			$cur='$';
			$p=2;
		}
	@endphp
	<tr>
		<td>{{ ++ $key }}</td>
		<td>{{ $bl->barcode }}</td>
		<td>{{ $bl->unit }}</td>
		<td>{{ number_format($bl->price,$p,'.',',') . ' '. $cur }}</td>
		
		<td>{{ $bl->multiple }}</td>
	</tr>
@endforeach