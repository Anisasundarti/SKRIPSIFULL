
<div class="table-responsive">
  
        <table class="table" id="users-table">
        <thead>
            <tr><th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Email Verified At</th>
<!--                 <th>Password</th> -->
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Remember Token</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $users)
            <tr>
                <td>{{ $no++}} </td>
                <td>{{ $users->name }}</td>
                <td>{{ $users->email }}</td>
                <td>{{ $users->email_verified_at }}</td>
                <!-- <td>{{ $users->password }}</td> -->
                <td>{{ $users->alamat }}</td>
                <td>{{ $users->telepon }}</td>
                <td>{{ $users->remember_token }}</td>
                <td>
                    {!! Form::open(['route' => ['users.destroy', $users->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                      
                        <a href="{{ route('users.show', [$users->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('users.edit', [$users->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

