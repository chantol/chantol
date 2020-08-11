@php
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
@foreach ($sc as $key => $v)
	<tr>
		<td>{{ ++$key }}</td>
		<td>{{ date('d-m-Y',strtotime($v->dd)) }}</td>
		<td>{{ $v->formonth . '-' . $v->foryear }}</td>
		<td>{{ $v->qtyset . $v->unit }}</td>
		<td>{{ phpformatnumber($v->price) . $v->cur }}</td>
		<td>
			<a href="#" class="btn btn-danger btn-sm btn-remove" data-pid="{{ $v->product_id }}" data-id="{{ $v->id }}"><i class="fa fa-trash"></i></a>
		</td>
	</tr>
@endforeach