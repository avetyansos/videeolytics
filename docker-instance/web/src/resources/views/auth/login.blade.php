<!DOCTYPE html>
<html>
<head>
    <title>Login to backoffice</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="TS" name="author">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="/favicon.ico" rel="shortcut icon">

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">

    <link rel="stylesheet" media="all" href="{{ asset('plugins/fontawesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" media="all" href="{{ asset(mix('css/app.css')) }}">
    <link rel="stylesheet" media="all" href="{{ asset(mix('css/all.css')) }}">
</head>
<body class="auth-wrapper">
<div class="all-wrapper menu-side with-pattern">
    <div class="auth-box-w">
        <div class="logo-w p-3">
            <a href="{{ route('home') }}"><img style="width: 50%; margin-left: -15px;" src="{{ asset('img/logo-big.png') }}"></a>
        </div>
        <h4 class="auth-header">Sign in to Backoffice</h4>
        <form method="post" action="{{ route('login') }}" class="form-signin">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                <label for="">Email</label>
                <input id="email" type="email" class="form-control form-item {{ $errors->has('email') ? ' error-field' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Your email">
                <div class="pre-icon os-icon os-icon-user-male-circle"></div>
                @if ($errors->has('email'))
                    <span class="help-block form-text with-errors">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                <label for="">Password</label>
                <input id="password" type="password" class="form-control form-item {{ $errors->has('password') ? ' error-field' : '' }}" name="password" required placeholder="Your password">
                <div class="pre-icon os-icon os-icon-fingerprint"></div>
                @if ($errors->has('password'))
                    <span class="help-block form-text with-errors">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="buttons-w">
                <button class="btn btn-primary" type="submit">Login</button>
                <div class="form-check-inline">
                    <label class="form-check-label"><input class="form-check-input" type="checkbox">Remember Me</label>
                </div>
            </div>
        </form>
    </div>
</div>

<input type="hidden" id="assetsUrlForJS" value="{!! asset('') !!}">

<script src="{{ asset(mix('js/manifest.js')) }}"></script>
<script src="{{ asset(mix('js/vendor.js')) }}"></script>
<script src="{{ asset(mix('js/app.js')) }}"></script>

</body>
</html>