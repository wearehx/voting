@extends("app")

@section("content")
<h2 class="uuid">UUID</h2>
<p>When you cast your first vote, a pseudo-random v4 UUID is generated and attached to your account. When you vote in an election, your UUID and vote is made available for download. You may independently calculate the winner of the election and validate your vote was correctly counted. It is important that you only disclose your UUID when you intend for others to see your past, current, and future votes. @if (! Auth::user()->uuid) <b>You do not have a UUID attached to your account.</b> @else <b>Your UUID is <code>{{ Auth::user()->uuid }}</code>.</b> @endif</p>
<h2>Next Election</h2>
<p>The first election will elect <b>{{ env("NUM_ADMINS") }}</b> admins and will accept nominations starting <b title="{{ nextTerm()->starts_at->subDays(14) }}">{{ nextTerm()->starts_at->subDays(14)->diffForHumans() }}</b>. Voting will begin <b title="{{ nextTerm()->starts_at->subDays(7) }}">{{ nextTerm()->starts_at->subDays(7)->diffForHumans() }}</b>, and the term will start <b title="{{ nextTerm()->starts_at }}">{{ nextTerm()->starts_at->diffForHumans() }}</b>.</p>
@endsection
