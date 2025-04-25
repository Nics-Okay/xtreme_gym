<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xtreme Gym World')</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/userLayout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/userHeader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/userMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/settingsStyle.css') }}">
    @yield('head-access')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script> 
</head>
<body>
    <div class="main-container">
        @include('partials.userMenu')
        @include('partials.userHeader')

        <div class="main-content">
            @include('partials.session-message')
            @yield('main-content')
        </div>
    </div>
    <script src="{{ asset('js/userMenu.js') }}"></script>
    @yield('js-container')
</body>
</html>