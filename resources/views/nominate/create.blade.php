@extends("app")

@section("content")
<p>You can nominate one user to be put on the ballot per term. Your nomination does not bind you to voting for them, and they must accept the nomination to be placed on the ballot. The user you nominate must have logged in to this application before you can nominate them.</p>
<form method="post">
    <input type="text" name="facebook_id" placeholder="Facebook ID">
    {!! csrf_field() !!}
    <button type="submit" class="btn btn-primary">Nominate</button>
</form>
@endsection
