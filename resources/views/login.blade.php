<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}">
</head>

<body>
    <div class="login-card"><img class="profile-img-card" src="">
        <p class="profile-name-card"> </p>
        @if(Session::has('status'))
            <div class="alert alert-danger">
                <ul>
                    {{ Session::get('status') }}
                </ul>
            </div>
        @endif
        <form class="form-signin" method="POST" action="{{ route('Userlogin') }}">
            {{ csrf_field() }}
            {{ method_field('POST') }}

            <input class="form-control" name="userid" type="text" id="inputUsername" required="" placeholder="Enter Username" autofocus="">
            <input class="form-control" name="password" type="password" id="inputPassword" required="" placeholder="Password">
            <button class="btn btn-primary btn-block btn-lg btn-signin" id="signin" type="submit">Sign in</button>
        </form>
        <a class="forgot-password" href="#">Forgot your password?</a>
    </div>

    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>

</html>

<script>
</script>