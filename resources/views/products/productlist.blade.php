
@php
	$cat='';
	$brand='';
	$cat1='';
	$brand1='';
	$dorow=0;
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
			<td colspan=8 style="color:blue;">{{ $cat . '-' . $brand }}</td>
		</tr>
	@endif
	
<tr> 
	<td style="text-align:center;">{{ ++$key }}</td>
	<td style="text-align:center;">{{ date('d-m-Y',strtotime($p->created_at)) }}</td>
	<td style="text-align:center;">{{ $p->code }}</td>
	<td style="text-align:center;">{{ $p->name }}</td>
	<td style="text-align:center;">{{ $cat1 }}</td>
	<td style="text-align:center;">{{ $brand1 }}</td>
	
	{{-- <td style="text-align:center;">
		<img src="{{ $p->getImage() }}" alt="" style="height:60px;">
	</td> --}}
	<td class="colaction">
		<a href="" class="btn btn-warning btn-xs btn-edit" title="Edit" data-id="{{ $p->id }}" style="width:30px;color:blue;">
			<i class="fa fa-pencil"></i>
		</a>
		
		<a href="" class="btn btn-danger btn-xs btn-delete" title="Remove" data-id="{{ $p->id }}" data-image="{{ $p->image }}" style="width:30px;">
			<i class="fa fa-trash"></i>
		</a>
	</td>
</tr>
@php
	$dorow=0;
@endphp
@endforeach