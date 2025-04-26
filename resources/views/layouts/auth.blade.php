<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Xtreme Gym World - Fitness with no excuses.">
    <meta name="keywords" content="Gym, Fitness, Fit">
    <meta name="author" content="Xtreme Gym World">
    <title>@yield('title', 'Xtreme Gym World')</title>
    <link rel="stylesheet" href="{{ asset('css/auth/authWeb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/authMobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/header.css') }}">
    @yield('head-access')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head> 
<body>
    <div class="main-container">
        @include('partials.header')

        <div class="main">
            @include('partials.session-message')
            @yield('main-content')
        </div>
    </div>
</body>
</html>
