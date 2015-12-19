@extends("app")

@section("content")
<p>When you (the "User") authorize the application (the "Service") via Facebook, the web application operated by <a href="https://ian.sh">Ian Carroll</a> (the "Maintainer") collects and indefinitely stores the following information:</p>
<ul>
    <li>User's full name, email address, and Facebook ID</li>
    <li>Groups User administers</li>
    <li>IP addresses, hostnames, User Agents, and other information User's browsers may expose</li>
    <li>Votes, biographies, and other things submitted by User</li>
</ul>
<p>User grants Maintainer an irrevocable, indefinite, royalty-free, transferable, unconditional license to the above data. Maintainer may transfer control of Service and Maintainer's content licenses at any time to a person or company chosen by the current elected administrators. Some of the above data may be inadvertantly transmitted to a third party when generating stack traces and other reports used to aid debugging. Additionally, Service may generate a unique UUID to anonymously publish User's votes, in which the UUID will be shown alongside User's vote.</p>

<p>Maintainer will use this data to aid other users in selecting a candidate, to prevent fraud, to generate statistics, and to publish election results. The Maintainer will not reveal user information to third parties except:</p>
<ul>
    <li>If Maintainer has a good faith belief that the law requires us them to</li>
    <li>If User explicitly authorizes the release of specific information</li>
    <li>If User intentionally engages in fraud, including but not limited to</li>
    <ul>
        <li>Using multiple accounts to cast votes</li>
        <li>Maliciously compromising the integrity of the Service or votes</li>
    </ul>
</ul>

<p>User will indemify Maintainer from any and all losses, damages, injury, and liability relating to their use of this Service.</p>

<p>Questions may be directed towards <a href="mailto:ian@ian.sh">ian@ian.sh</a>.</p>
@endsection
