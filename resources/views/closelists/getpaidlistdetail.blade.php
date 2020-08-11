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
@foreach ($pdt as $key => $value)
	<tr style="text-align:center;">
		<td>{{ ++$key }}</td>
		<td>{{ $value->id }}</td>
		<td>{{ date('d-m-Y',strtotime($value->paydate)) }}</td>
		<td>{{ $value->user->name }}</td>
		<td>{{ phpformatnumber($value->payamt) . ' ' . $value->cur }}</td>
		<td>{{ phpformatnumber($value->balance) . ' ' . $value->cur }}</td>
		
		<td style="font-family:khmer os system;padding:0px;"><pre style="border-style:none;margin:0px;">{{ $value->note }}</pre></td>
		<td>
			<a href="" class="btn btn-danger btn-sm btndelpaid" data-id="{{ $value->id }}">Del</a>
		</td>
	</tr>
@endforeach