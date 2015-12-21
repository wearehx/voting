<!DOCTYPE html>
<html lang="en-us">
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/primer/2.5.0/primer.css" integrity="sha384-o0YWZdA8eYSrFeZHIKGgO4JlK4rFGcLFYg0ZQFR1dVI1B7zOFFZslOivPicg8sgG" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/octicons/3.3.0/octicons.min.css" integrity="sha384-uqbsQpAQoP62HwuzH3oCZpiK65pxW6Y+0SYpz3b1FBh1eXZ9Pzwe9xHgVCs33w3f" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/app.css" media="all">
        <title>{{ trans('common.global_title') }}</title>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>HX Voting</h1>
            </div>

            <div class="container">
                @if (count($errors) > 0)
                <div class="flash flash-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (Session::has('message'))
                <div class="flash top-flash">{{ Session::get('message') }}</div>
                @endif
                <div class="columns">
                    <div class="one-fifth column">
                        <nav class="menu">
                            <a class="menu-item" href="/"><span class="octicon octicon-radio-tower"></span> Home</a>
                            <a class="menu-item" href="/vote" @if(! canVote(false) && ! canNominate(false)) disabled @endif><span class="octicon octicon-broadcast"></span> Vote</a>
                            <a class="menu-item" href="/nominate" @if(! canNominate()) disabled @endif><span class="octicon octicon-thumbsup"></span> Nominate</a>
                            <a class="menu-item" href="/candidacy" @if(! canNominate(false)) disabled @endif><span class="octicon octicon-person"></span> Candidacy</a>
                            <a class="menu-item" href="/data/users"><span class="octicon octicon-organization"></span> Users</a>
                            @if(Auth::check()) <a class="menu-item" href="/logout"><span class="octicon octicon-lock"></span> Logout</a> @endif
                        </nav>
                    </div>
                    <div class="four-fifths column">
                        @yield("content")
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
