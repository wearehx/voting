@extends("app")

@section("content")
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>UID</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td><a href="https://facebook.com/{{ $user->facebook_id }}">{{ $user->name }}</a></td>
                <td>{{ $user->facebook_id }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
