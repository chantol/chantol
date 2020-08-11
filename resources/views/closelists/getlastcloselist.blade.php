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
@foreach ($closelist as $key => $cl)
	<tr>
		<td class="rowclick">{{ ++$key }}</td>
		<td class="rowclick">{{ $cl->id }}</td>
		<td class="rowclick">{{ date('d-m-Y',strtotime($cl->dd)) }}</td>
		<td class="rowclick">{{ $cl->user->name }}</td>
		<td class="rowclick">{{ $cl->supplier->name }}</td>
		<td class="rowclick">{{ date('d-m-Y',strtotime($cl->d1)) }}</td>
		<td class="rowclick">{{ date('d-m-Y',strtotime($cl->d2)) }}</td>
		<td class="rowclick">{{ phpformatnumber($cl->ivamount) }}</td>
		<td class="rowclick">{{ phpformatnumber($cl->ivdeposit) }}</td>
		<td class="rowclick">{{ phpformatnumber($cl->ivbalance) }}</td>
		<td class="rowclick">{{ phpformatnumber($cl->oldlist) }}</td>
		<td class="rowclick">{{ phpformatnumber($cl->total) }}</td>
		<td class="rowclick">{{ phpformatnumber($cl->deposit) }}</td>
		<td class="rowclick">{{ phpformatnumber($cl->total - $cl->deposit) }}</td>
		<td class="rowclick">{{ $cl->cur }}</td>
		<td>
			<a href="" class="btn btn-danger btn-sm btndellist" data-id="{{ $cl->id }}">Del</a>
		</td>
	</tr>
@endforeach