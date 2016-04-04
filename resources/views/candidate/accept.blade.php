@extends("app")

@section("content")
<p>You've been nominated by at least one person to run as a moderator for the next term. There is no cost for or limitation on running; if you lose, you can run in the next election with no penalties. If you don't want to run, you don't need to take any further action.</p>
<form method="post">
    <div class="form-checkbox">
        <label>
            <input type="checkbox" name="consent">
            I want to be placed on the next election ballot.
        </label>
    </div>
    <textarea maxlength="250" name="text" required>Write 250 or below (and above 10) characters about yourself here.</textarea><br />
    {!! csrf_field() !!}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
