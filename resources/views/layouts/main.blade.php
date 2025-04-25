<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xtreme Gym World')</title>
    <link rel="stylesheet" href="{{ asset('css/partials/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/userHeader.css') }}">
    @yield('head-access')
</head>
<body>
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        background-color: rgba(28, 37, 54);
    }

    .main-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100vw; 
    }

    .main {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-grow: 1;
        width: 100%;
    }
    </style>
    
    <div class="main-container">
        @if (Route::has('login'))
            @auth
                @include('partials.userHeader')
                @else
                    @include('partials.header')
            @endauth
        @endif

        <div class="main">
            @include('partials.session-message')
            @yield('main-content')
        </div>
    </div>
</body>
</html>