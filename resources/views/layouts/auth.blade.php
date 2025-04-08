<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Xtreme Gym - Fitness with no excuses.">
    <meta name="keywords" content="Gym, Fitness, Fit">
    <meta name="author" content="Xtreme Gym World">
    <title>@yield('title', 'GYMXTREME')</title>
    <link rel="stylesheet" href="{{ asset('css/auth/authWeb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/authMobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/header.css') }}">
    @yield('head-access')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head> 
<body>
    <div class="main-container">
        <div class="header">
            @include('partials.header')
        </div>
        <div class="main">
            @yield('main-content')
        </div>
    </div>
</body>
</html>
