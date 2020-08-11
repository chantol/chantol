
@php
	$cat='';
	$brand='';
	$cat1='';
	$brand1='';
	$dorow=0;
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
@foreach ($products as $key => $p)
	@php
		$cat1=$p->getcategoryname($p->category_id);
		$brand1=$p->getbrandname($p->brand_id);
		if($cat != $cat1){
			$dorow=1;
		}
		if($brand != $brand1){
			$dorow=1;
		}
		$cat=$cat1;
		$brand=$brand1;

	@endphp
	@if ($dorow==1)
		<tr>
			<td colspan=10 style="color:blue;">{{ $cat . '-' . $brand }}</td>
		</tr>
	@endif
	
<tr> 
	<td style="text-align:center;">{{ ++$key }}</td>
	<td style="text-align:center;">{{ date('d-m-Y',strtotime($p->created_at)) }}</td>
	<td style="text-align:center;">{{ $p->code }}</td>
	<td style="text-align:center;">{{ $p->name }}</td>
	<td style="text-align:center;">{{ $p->qty_target }}</td>
	<td style="text-align:center;">{{ phpformatnumber($p->scoreprice) . $p->scorecur }}</td>
	<td style="text-align:center;">{{ $p->formonth . '/' . $p->foryear }}</td>
	<td style="text-align:center;">{{ $cat1 }}</td>
	<td style="text-align:center;">{{ $brand1 }}</td>
	
	{{-- <td style="text-align:center;">
		<img src="{{ $p->getImage() }}" alt="" style="height:60px;">
	</td> --}}
	<td class="colaction">
		<a href="" class="btn btn-info btn-sm btn-addnew" title="Add" data-id="{{ $p->id }}" data-name="{{ $p->name }}" style="width:30px;color:blue;">
			<i class="fa fa-plus"></i>
		</a>
		<a href="" class="btn btn-warning btn-sm btn-edit" title="Edit" data-id="{{ $p->id }}" data-name="{{ $p->name }}" data-scoreid="{{ $p->score_id }}" style="width:30px;color:blue;">
			<i class="fa fa-pencil"></i>
		</a>
		<a href="" class="btn btn-danger btn-sm btn-delete" title="Delete" data-id="{{ $p->id }}" data-name="{{ $p->name }}" data-scoreid="{{ $p->score_id }}" style="width:30px;color:blue;">
			<i class="fa fa-trash"></i>
		</a>
		<a href="" class="btn btn-default btn-sm btn-history" title="History" data-id="{{ $p->id }}" data-name="{{ $p->name }}" data-scoreid="{{ $p->score_id }}" style="width:30px;color:blue;">
			H
		</a>
	</td>
</tr>
@php
	$dorow=0;
@endphp
@endforeach