<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xtreme Gym World</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/indexMobile.css') }}">
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

    <div class="index-main">
        <div class="menu">
            <div class="toggle-menu" id="toggleMenu">
                <ion-icon name="chevron-up-outline" id="toggleIcon"></ion-icon>
            </div>
            <div class="get-started">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('filter') }}">GET STARTED</a>
                        @else
                            <a href="{{ route('login') }}">GET STARTED</a>
                    @endauth
                @endif
            </div>
            <div class="menu-nav">
                <ul>
                    <li><a href="#">TRAINING SESSIONS</a></li>
                    <li><a href="plans">MEMBERSHIP PLANS</a></li>
                    <li><a href="contact">CONTACT US</a></li>
                    <li><a href="about">ABOUT US</a></li>
                </ul>
            </div>
        </div>

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

    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        const menu = document.querySelector(".menu");
        const toggleMenu = document.getElementById("toggleMenu");
        const toggleIcon = document.getElementById("toggleIcon");

        let inactivityTimeout;

        // Toggle Menu Functionality
        function toggleMenuHandler() {
            menu.classList.toggle("active");
            toggleMenu.classList.toggle("active");
            toggleIcon.name = menu.classList.contains("active") ? "chevron-down-outline" : "chevron-up-outline";
            resetInactivityTimer();
        }

        // Close Menu on Outside Click
        function handleClickOutside(event) {
            if (!menu.contains(event.target) && !toggleMenu.contains(event.target)) {
                closeMenu();
            }
        }

        // Close Menu Function
        function closeMenu() {
            menu.classList.remove("active");
            toggleMenu.classList.remove("active");
            toggleIcon.name = "chevron-up-outline";
        }

        // Reset Inactivity Timer
        function resetInactivityTimer() {
            clearTimeout(inactivityTimeout);
            inactivityTimeout = setTimeout(closeMenu, 10000); // 10 seconds
        }

        // Event Listeners
        toggleMenu.addEventListener("click", toggleMenuHandler);
        document.addEventListener("click", handleClickOutside);
        document.addEventListener("mousemove", resetInactivityTimer);
        document.addEventListener("keydown", resetInactivityTimer);

    </script>
</body>
</html>