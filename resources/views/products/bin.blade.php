
@php
	$dd='';
	$dorow=0;
	$getdd='';
@endphp
@foreach ($products as $key => $p)
	@php
		$getdd= date('d-m-Y',strtotime($p->updated_at));
		if($dd <> $getdd){
			$dorow=1;
		}
		$dd=$getdd;
	@endphp
	@if ($dorow==1)
		<tr>
			<td colspan=8 style="color:blue;">{{ $getdd }}</td>
		</tr>
	@endif
	
<tr> 
	<td style="text-align:center;">{{ ++$key }}</td>
	<td style="text-align:center;">{{ date('d-m-Y',strtotime($p->updated_at)) }}</td>
	<td style="text-align:center;">{{ $p->code }}</td>
	<td style="text-align:center;">{{ $p->name }}</td>
	<td style="text-align:center;">{{ $p->category->name }}</td>
	<td style="text-align:center;">{{ $p->brand->name }}</td>
	
	<td class="colaction">
		<a href="" class="btn btn-warning btn-xs btn-restore" title="Restore" data-id="{{ $p->id }}" style="width:30px;color:blue;">
			<i class="fa fa-recycle"></i>
		</a>
		
		<a href="" class="btn btn-danger btn-xs btn-delete2" title="Remove" data-id="{{ $p->id }}" data-image="{{ $p->image }}" style="width:30px;">
			<i class="fa fa-trash-o"></i>
		</a>
	</td>
</tr>
@php
	$dorow=0;
@endphp
@endforeach