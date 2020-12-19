<div class="table-responsive">
    <table class="table" id="jenisKejahatans-table">
        <thead>
            <tr>
                <th>Jenis Kejahatan</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($jenisKejahatans as $jenisKejahatan)
            <tr>
                <td>{{ $jenisKejahatan->jenis_kejahatan }}</td>
                <td>
                    {!! Form::open(['route' => ['jenisKejahatans.destroy', $jenisKejahatan->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('jenisKejahatans.show', [$jenisKejahatan->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('jenisKejahatans.edit', [$jenisKejahatan->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
