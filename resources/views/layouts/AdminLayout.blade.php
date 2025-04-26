<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xtreme Gym World')</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/adminLayout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/adminMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    @yield('head-access')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <div class="main-container">
        @include('partials.adminMenu')
        

        <div class="main-content">
            @include('partials.session-message')
            @yield('main-content')
        </div>
    </div>

    <div id="locked-status" data-locked="{{ auth()->user()->locked ? 'true' : 'false' }}"></div>

    <div id="lock-modal" class="modal hidden">
        <div class="modal-content">
            <h3>Enter Admin Pin</h3>
            <form id="unlock-form">
                @csrf
                <div class="input-container">
                    <input type="password" id="pin_code" name="pin_code" maxlength="6" required autofocus placeholder="6-digit PIN">
                    <button type="button" id="toggle-password" class="toggle-password">
                        <i class="fas fa-eye" id="toggle-password-icon"></i>
                    </button>
                </div>
                <button class="unlock-button" type="button" onclick="unlockAdmin()">Unlock</button>
            </form>
            <a href="javascript:void(0);" onclick="sendResetLink()">Forgot Lock Code?</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('pin_code');
            const icon = document.getElementById('toggle-password-icon');

            togglePassword.addEventListener('click', function () {
                const isPasswordVisible = passwordInput.type === 'text';
                passwordInput.type = isPasswordVisible ? 'password' : 'text';
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>

    @yield('js-container')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const lockModal = document.getElementById('lock-modal');
            const initialLockStatus = document.getElementById('locked-status').getAttribute('data-locked') === 'true';

            // Show modal immediately if locked
            if (initialLockStatus) {
                lockModal.classList.remove('hidden');
            }
        });

        function unlockAdmin() {
            const pinCode = document.getElementById("pin_code").value;

            fetch("{{ route('admin.unlock') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ pin_code: pinCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'unlocked') {

                    document.getElementById('lock-modal').classList.add('hidden');
                    document.getElementById('locked-status').setAttribute('data-locked', 'false');
                } else if (data.status === 'error') {
                    alert(data.message || "Invalid PIN. Please try again.");
                }
            })
            .catch(error => console.error('Error unlocking admin:', error));
        }

        function toggleLock() {
            fetch("{{ route('admin.lock') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ lock: true })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'locked') {
                    location.reload();
                }
            })
            .catch(error => console.error('Error locking admin:', error));
        }

        function sendResetLink() {
            fetch("{{ route('admin.reset-lock-code') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert("Reset link sent to your registered email.");
                } else {
                    alert(data.message || "Failed to send reset link.");
                }
            })
            .catch(error => console.error('Error sending reset link:', error));
        }
    </script>

    <script src="{{ asset('js/admin/main.js') }}"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof initMenu !== 'undefined') initMenu();
        if (typeof initClock !== 'undefined') initClock();
        if (typeof initStarRating !== 'undefined') initStarRating();
        if (typeof initCalendar !== 'undefined') initCalendar();
        if (typeof initLockUnlock !== 'undefined') initLockUnlock();
    });
    </script>
</body>
</html>