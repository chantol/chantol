@foreach ($laws as $key => $law)
	<tr class={{ $law->active==1?"activecolor":"disactivecolor" }}>
		<td>{{ ++$key }}</td>
		<td>{{ $law->id }}</td>
		<td style="font-family:khmer os system;">{{ $law->name }}</td>
		<td>{{ $law->tel }}</td>
		<td>{{ $law->email }}</td>
		<td>{{ $law->address }}</td>
		<td>
			<a href="" class="btn btn-warning btn-sm co-edit" data-id="{{ $law->id }}" data-name="{{ $law->name }}" data-tel="{{ $law->tel }}" data-email="{{ $law->email }}" data-address="{{ $law->address }}"><i class="fa fa-pencil"></i></a>
			<a href="" class="btn btn-danger btn-sm co-delete" data-id="{{ $law->id }}" data-name="{{ $law->name }}" data-active="{{ $law->active }}"><i class="fa fa-trash"></i></a>
			@if ($law->active==-1)
				<a href="" class="btn btn-danger btn-sm co-restore" data-id="{{ $law->id }}" data-name="{{ $law->name }}" data-active="{{ $law->active }}"><i class="fa fa-reply"></i></a>
			@endif
		</td>
	</tr>
@endforeach