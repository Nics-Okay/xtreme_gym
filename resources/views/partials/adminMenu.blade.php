<div class="menu-container"> 
    <h1>XTREME</h1>

    <div class="time-and-date">
        <div class="td-content">
            <div class="clock" id="clock"></div>
            <div class="date" id="date"></div>
        </div>
        <button id="lock-toggle" onclick="toggleLock()">
            <ion-icon name="{{ auth()->user()->locked ? 'lock-closed' : 'lock-open' }}"></ion-icon>
        </button>
    </div>

    <div class="menu-section underline"></div>

    <div class="menu-content">
        <ul>
            <li>
                <a href="{{ route('dashboard') }}" class="menu-item m-dashboard">
                    <div class="icon-box">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>Dashboard
                </a>
            </li>
            <li>
                <div class="menu-dropdown-container">
                    <div class="menu-dropdown" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <p>Members</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('member.show') }}" class="menu-item m-manage-members"><i class="fa-solid fa-users"></i>Manage Members</a>
                        <a href="{{ route('transaction.membershipRequest') }}" class="menu-item m-membership-requests"><i class="fa-solid fa-users"></i>Membership Requests</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu-dropdown-container">
                    <div class="menu-dropdown" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <p>Guest & Attendees</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('guest.show') }}" class="menu-item m-manage-guests"><i class="fa-solid fa-users"></i>Manage Guests</a>
                        <a href="{{ route('attendee.show') }}" class="menu-item m-attendance"><i class="fa-solid fa-users"></i>Manage Attendees</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu-dropdown-container">
                    <div class="menu-dropdown" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <p>Classes & Trainers</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('trainer.show') }}" class="menu-item m-manage-trainers"><i class="fa-solid fa-users"></i>Trainer Management</a>
                        <a href="{{ route('training.show') }}" class="menu-item m-manage-trainers"><i class="fa-solid fa-users"></i>Training Management</a>
                        <a href="{{ route('apprentice.show') }}" class="menu-item m-manage-trainers"><i class="fa-solid fa-users"></i>Apprentice Management</a>
                        <a href="{{ route('classList.show') }}" class="menu-item m-class-schedules"><i class="fa-solid fa-users"></i>Class Management</a>
                        <a href="{{ route('student.show') }}" class="menu-item m-students"><i class="fa-solid fa-users"></i>Student Management</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu-dropdown-container">
                    <div class="menu-dropdown" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <p>Reservations</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('facility.show') }}" class="menu-item m-facilities"><i class="fa-solid fa-users"></i>Facilities</a>
                        <a href="{{ route('reservation.show') }}" class="menu-item m-reservations"><i class="fa-solid fa-users"></i>Reservation Management</a>
                    </div>
                </div>
            </li>
            <li>
                <a href="{{ route('rate.show') }}" class="menu-item m-events">
                    <div class="icon-box">
                        <i class="fa-solid fa-gem"></i>
                    </div>Membership Plans
                </a>
            </li>
            <li>
                <div class="menu-dropdown-container">
                    <div class="menu-dropdown" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        <p>Events & Tournaments</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('event.show') }}" class="menu-item m-manage-events"><i class="fa-solid fa-users"></i>Events Management</a>
                        <a href="{{ route('tournaments.index') }}" class="menu-item m-tournaments"><i class="fa-solid fa-users"></i>Tournament Management</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu-dropdown-container">
                    <div class="menu-dropdown" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fa-solid fa-circle-dollar-to-slot"></i>
                        </div>
                        <p>Transactions</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('transaction.show') }}" class="menu-item payments-history"><i class="fa-solid fa-users"></i>Payments History</a>
                        <a href="{{ route('transaction.studentRequest') }}" class="menu-item m-class-schedules"><i class="fa-solid fa-users"></i>Student Requests</a>
                        <a href="{{ route('transaction.apprenticeRequest') }}" class="menu-item m-manage-trainers"><i class="fa-solid fa-users"></i>Apprentice Requests</a>
                        <a href="{{ route('transaction.reservationRequest') }}" class="menu-item m-reservation-requests"><i class="fa-solid fa-users"></i>Reservation Requests</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu-dropdown-container">
                    <div class="menu-dropdown" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <p>Reports & Analytics</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('report.show')}}" class="menu-item m-revenue-reports"><i class="fa-solid fa-users"></i>Revenue Reports</a>
                        <a href="{{ route('analytic.show')}}" class="menu-item m-gym-analytics"><i class="fa-solid fa-users"></i>Gym Analytics</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu-dropdown-container">
                    <div class="menu-dropdown" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <p>Settings </p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('control.show')}}" class="menu-item m-control-panel"><i class="fa-solid fa-users"></i>Control Panel</a>
                        <a href="{{ route('equipment.show') }}" class="menu-item m-gym-equipments"><i class="fa-solid fa-users"></i>Gym Equipments</a>
                        <a href="{{ route('notification.show') }}" class="menu-item m-reminders"><i class="fa-solid fa-users"></i>Notifications</a>
                        <a href="{{ route('review.show') }}" class="menu-item m-reviews"><i class="fa-solid fa-users"></i>Reviews</a>
                        <a href="{{ route('profileNew.show') }}" class="menu-item m-profile-settings"><i class="fa-solid fa-users"></i>Profile Settings</a>
                    </div>
                </div>
            </li>
            <li>
                <a href="#" id="openLogoutModal">
                    <div class="icon-box">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </div>
                    Log out
                </a>
            </li>
        </ul>
    </div>

    <a class="user-profile-container" href="{{ route('profileNew.show')}}">
        <div class="user-profile-image">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/profile-placeholder.png') }}" 
            alt="Profile Image">
        </div>
        <div class="user-info">
            <p class="user name">{{ $user->first_name ?? ' '}} {{ $user->last_name ?? ' '}}</p>
            <p class="user role">{{ $user->user_type ?? 'Undefined'}}</p>
        </div>
    </a>
</div>

<!-- Admin Lock Unlock Modal -->
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

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="logout-modal">
    <div class="logout-modal-content">
        <h3>Log out</h3>
        <p>Are you sure you want to log out?</p>
        <form method="post" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <div class="logout-modal-actions">
                <button type="button" id="closeLogoutModal" class="l-o-cancel">Cancel</button>
                <button type="submit" class="l-o-confirm">Log out</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/admin/time-and-date.js') }}"></script>

<script src="{{ asset('js/admin/dropdown-menu.js') }}"></script>

<script src="{{ asset('js/admin/menu-modal.js') }}"></script>

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

        const lockModal = document.getElementById('lock-modal');
        const initialLockStatus = document.getElementById('locked-status').getAttribute('data-locked') === 'true';

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

                alert(data.message || "Admin unlocked successfully!");

                location.reload();
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