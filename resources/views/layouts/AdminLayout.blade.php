<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xtreme Gym World')</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/adminLayout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/adminMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/adminHeader.css') }}">
    @yield('head-access')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <div class="main-container">
        @include('partials.adminMenu')


        <div class="main-content">
            <!-- Header Section -->
            <div class="header-container">
                <h2>@yield('header-title', 'Xtreme')</h2>
                <div class="header-section search">
                    <input type="text">
                </div>
            </div>
            
            <!-- Main -->
            @yield('main-content')
        </div>
    </div>

    <!-- Menu Dropdown Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".menu-item").forEach(item => {
                item.addEventListener("click", function () {
                    let dropdown = this.nextElementSibling;
                    let chevron = this.querySelector(".chevron");

                    document.querySelectorAll(".dropdown-content").forEach(d => {
                        if (d !== dropdown) d.classList.remove("show");
                    });

                    document.querySelectorAll(".chevron").forEach(c => {
                        if (c !== chevron) c.classList.remove("rotate");
                    });

                    dropdown.classList.toggle("show");
                    chevron.classList.toggle("rotate");
                });
            });
        });
    </script>
    @yield('js-container')
</body>
</html>