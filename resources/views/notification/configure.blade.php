@extends("app")

@section("content")
    <p>Update your notification preferences.</p><br />
    <form method="post">
        <div class="form-checkbox">
            <label>
                <input type="checkbox" name="should_notify_about_running" checked="{{ Auth::user()->should_notify_about_running ? 'checked' : '' }}">
                Can run
            </label>
            <p class="note">
                Receive a notification when you have been nominated by two people.
            </p>
        </div>
        <div class="form-checkbox">
            <label>
                <input type="checkbox" name="should_notify_about_nominating" checked="{{ Auth::user()->should_notify_about_nominating ? 'checked' : '' }}">
                Can nominate
            </label>
            <p class="note">
                Receive a notification when you can nominate others.
            </p>
        </div>
        <div class="form-checkbox">
            <label>
                <input type="checkbox" checked="{{ Auth::user()->should_notify_about_nominating ? 'checked' : '' }}">
                Can vote
            </label>
            <p class="note">
                Receive a notification when you can vote.
            </p>
        </div>
        {!! csrf_field() !!}
    </form>
@endsection