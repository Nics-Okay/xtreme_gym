<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>@yield('title', 'Xtreme Gym World')</title>

    <!-- Designs -->
    <link rel="stylesheet" href="{{ asset('css/layouts/adminLayout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/adminMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">

    <!-- CDN's -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script> 

    <!-- Head Access Section -->
    @yield('head-access')
</head>
<body>
    <div class="main-container">

        <!-- Menu -->
        @include('partials.adminMenu')

        <!-- Main Content-->
        <div class="main-content">
            @include('partials.session-message')
            @yield('main-content')
        </div>
    </div>

    <script src="{{ asset('js/admin/main.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof initStarRating !== 'undefined') initStarRating();
            if (typeof initCalendar !== 'undefined') initCalendar();
            if (typeof initCalendarPreview !== 'undefined') initCalendarPreview();
        });
    </script>

    <!-- Js Access Section -->
    @yield('js-container')
</body>
</html>