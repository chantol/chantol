@foreach ($companies as $key => $com)
	<tr>
		<td>{{ ++$key }}</td>
		<td>{{ $com->id }}</td>
		<td>{{ $com->name }}</td>
		<td>{{ $com->subname }}</td>
		<td>{{ $com->tel }}</td>
		<td>{{ $com->email }}</td>
		<td>{{ $com->website }}</td>
		<td>{{ $com->address }}</td>
		
		<td><img src="{{ asset('logo/'. $com->logo) }}" alt="" style="width:128px;height:128px;"></td>
		<td>
			<a href="#" class="btn btn-warning row-edit" data-id="{{ $com->id }}">Edit</a>
			<a href="#" class="btn btn-danger row-delete" data-id="{{ $com->id }}" data-logo="{{ $com->logo }}">Delete</a>
		</td>
	</tr>
@endforeach