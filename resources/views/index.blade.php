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
</head>
<body>
    @include('partials.session-message')
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
        <!-- index specific menu end -->

        @include('partials.header')
        <div class="index-body">
            <div class="index-body-left">
                <div class="index-body-content">
                    <h5 id="web-h5">UNLOCK<br>YOUR EXTREME<br>POTENTIAL.<br>NO EXCUSES.</h5>
                    <h5 id="mobile-h5">
                        <p>UNLOCK</p>
                        <p>YOUR EXTREME</p>
                        <p>POTENTIAL.</p>
                        <p>NO EXCUSES.</p>
                    </h5>
                    <p id="message">Xtreme Gym World is your partner in reaching every fitness goal.</p>
                    <p id="message">Begin your journey to a stronger, healthier you today.</p>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('filter') }}">PROCEED</a>
                            @else
                                <a href="login">BE XTREME NOW!</a>
                        @endauth
                    @endif
                </div>
            </div>
            <div class="index-body-right">
                <div class="image-holder">
                    <img src="{{ asset('images/xtreme-bg.jpg') }}" alt="img">
                </div>
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