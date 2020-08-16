@foreach ($customers as $key =>$c)
	<tr>
		<td>{{ ++$key }}</td>
		<td>{{ $c->id }}</td>
		<td style="font-family:khmer os system;">{{ $c->name }}</td>
		<td>{{ $c->sex }}</td>
		<td>{{ $c->tel }}</td>
		<td>{{ $c->customercode }}</td>
		<td>{{ $c->customerprice }}</td>
	</tr>
@endforeach