
	@foreach ($sups as $key =>$sup)
		<tr class={{ $sup->active==1?"activecolor":"disactivecolor" }}>
			<td>{{ ++$key }}</td>
			<td>{{ date('d-m-Y',strtotime($sup->created_at)) }}</td>
			<td style="font-family:khmer os system;">{{ $sup->name }}</td>
			<td style="font-family:khmer os system;">{{ $sup->sex }}</td>
			<td>{{ $sup->tel }}</td>
			<td>{{ $sup->email }}</td>
			@if ($sup->type==1)
				<td>{{ $sup->customercode }}</td>
				<td>{{ $sup->customerprice }}</td>
			@endif
			<td style="font-family:khmer os system;">{{ $sup->address }}</td>
			<td>{{ $sup->active }}</td>
			<td>
				<a href="" class="btn btn-warning btn-sm row-edit" data-id="{{ $sup->id }}" data-name="{{ $sup->name }}" data-sex="{{ $sup->sex }}" data-tel="{{ $sup->tel }}" data-email="{{ $sup->email }}" data-address="{{ $sup->address }}" data-active="{{ $sup->active }}" data-cuscode="{{ $sup->customercode }}" data-cusprice="{{ $sup->customerprice }}" title="Edit">
									<i class="fa fa-edit"></i>
				</a>
				<a href="" class="btn btn-danger btn-sm row-delete" data-id="{{ $sup->id }}" data-name="{{ $sup->name }}" title="Remove">
					<i class="fa fa-trash"></i>
				</a>
				
				@if ($sup->active==0)
					<a href="" class="btn btn-info btn-sm row-restore" data-id="{{ $sup->id }}" data-name="{{ $sup->name }}" title="restore">
						<i class="fa fa-reply"></i>
					</a>
				@endif
				
			</td>
		</tr>
	@endforeach
