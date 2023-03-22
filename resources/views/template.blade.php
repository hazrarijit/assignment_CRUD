<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('plugins/Bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/parsley/parsley.css') }}">

    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/Bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/parsley/parsley.min.js') }}"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-light navbar-light mb-5">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Company Logo</a>
        @auth
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Hello {{ auth()->user()->name }}!</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
            </li>
        </ul>
        @endguest
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>
