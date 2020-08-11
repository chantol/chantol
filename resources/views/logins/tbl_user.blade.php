 @foreach ($users as $key => $user)
    <tr  class={{ $user->active == 0 ? 'cred' : '' }}>
        <td>{{ ++$key }}</td>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>
            {{ $user->username }}
        </td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role->name }}</td>
        <td>{{ $user->active }}</td>
        <td>
            <a href="" class="btn btn-info btn-sm changepwd" data-id="{{ $user->id }}" style="font-weight:bold;">Change PWD</a>
            <a href="" class="btn btn-warning btn-sm user-edit" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-username="{{ $user->username }}" data-email="{{ $user->email }}" data-role="{{ $user->role_id }}" data-active="{{ $user->active }}" style="font-weight:bold;color:blue;">Edit</a>
            <a href="" class="btn btn-danger btn-sm user-delete" data-id="{{ $user->id }}" style="font-weight:bold;">Remove</a>
        </td>
    </tr>
@endforeach