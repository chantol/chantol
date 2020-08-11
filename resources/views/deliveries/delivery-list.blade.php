@foreach ($deliveries as $key => $dev)
	<tr style="cursor:pointer;" class={{ $dev->active==1?"activecolor":"disactivecolor" }}>
		<td>{{ ++$key }}</td>
		<td>{{ $dev->id }}</td>
		<td style="font-family:khmer os system;">{{ $dev->name }}</td>
		<td>{{ $dev->tel }}</td>
		<td>{{ $dev->email }}</td>
		<td>{{ $dev->address }}</td>
		<td>{{ $dev->active }}</td>
		<td>
			<a href="" class="btn btn-warning btn-sm dev_edit" data-id="{{ $dev->id }}" data-name="{{ $dev->name }}" data-active="{{ $dev->active }}" data-tel="{{ $dev->tel }}" data-email="{{ $dev->email }}" data-address="{{ $dev->address }}" title="Edit"><i class="fa fa-pencil"></i></a>
			<a href="" class="btn btn-danger btn-sm dev_del" data-id="{{ $dev->id }}" data-name="{{ $dev->name }}" data-active="{{ $dev->active }}" title="remove"><i class="fa fa-trash"></i>
			</a>
			@if ($dev->active==-1)
				<a href="" class="btn btn-danger btn-sm dev_restore" data-id="{{ $dev->id }}" data-name="{{ $dev->name }}" data-active="{{ $dev->active }}" title="Restore"><i class="fa fa-reply"></i>
				</a>
			@endif
		</td>
	</tr>
@endforeach