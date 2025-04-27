<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xtreme Gym World')</title>

    <!-- Layout Design -->
    <link rel="stylesheet" href="{{ asset('css/layouts/user.css') }}">

    <!-- Menu Design -->
    <link rel="stylesheet" href="{{ asset('css/partials/userMenu.css') }}">

    <!-- Development Design -->
    <link rel="stylesheet" href="{{ asset('css/user/development.css') }}">  

    @yield('head-access')

    <!-- Icons Library -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script> 
</head>
<body>
    <div class="main-container">

        <!-- Status Message -->
        @include('partials.session-message')

        <!-- Menu -->
        @include('partials.userMenu')

        <!-- Header -->
        @include('partials.userHeader')

        <div class="main-content">

            <!-- Content -->
            @yield('main-content')

        </div>
    </div>

    <script src="{{ asset('js/mobile-sizing.js') }}"></script>
    
    <script src="{{ asset('js/userMenu.js') }}"></script>

    @yield('js-container')
</body>
</html>