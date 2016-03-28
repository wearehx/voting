@extends("app")

@section("content")
    <p>Update your notification preferences.</p><br />
    <form method="post">
        <div class="form-checkbox">
            <label>
                <input type="checkbox" name="voting" checked="{{ Auth::user()->notify('voting') ? 'checked' : '' }}">
                Can vote
            </label>
            <p class="note">
                Receive a notification when you can vote.
            </p>
        </div>
        <div class="form-checkbox">
            <label>
                <input type="checkbox" name="nominating" checked="{{ Auth::user()->notify('nominating') ? 'checked' : '' }}">
                Can nominate
            </label>
            <p class="note">
                Receive a notification when you can nominate others.
            </p>
        </div>
        <div class="form-checkbox">
            <label>
                <input type="checkbox" name="running" checked="{{ Auth::user()->notify('running') ? 'checked' : '' }}">
                Can run
            </label>
            <p class="note">
                Receive a notification when you have been nominated by two people.
            </p>
        </div>
        {!! csrf_field() !!}
    </form>
@endsection
