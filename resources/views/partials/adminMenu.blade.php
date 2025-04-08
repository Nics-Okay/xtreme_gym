<div class="menu-container">
    <h1>XTREME</h1>

    <div class="menu-section user">
        <p class="user name">Nickname</p>
        <p class="user role">User</p>
    </div>

    <div class="menu-section underline"></div>

    <div class="menu-content">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-simple"></i>Dashboard</a></li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <i class="fa-solid fa-chart-simple"></i>
                        <p>Members</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Manage Members</a>
                        <a href="{{ route('rate.show') }}"><i class="fa-solid fa-chart-simple"></i>Membership Plans</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <i class="fa-solid fa-chart-simple"></i>
                        <p>Guest & Attendees</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Manage Guests</a>
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Attendance</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <i class="fa-solid fa-chart-simple"></i>
                        <p>Trainers</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Manage Trainers</a>
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Class Schedules</a>
                    </div>
                </div>
            </li>
            <li><a href="#"><i class="fa-solid fa-chart-simple"></i>Reservations</a></li>
            <li><a href="#"><i class="fa-solid fa-chart-simple"></i>Events</a></li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <i class="fa-solid fa-chart-simple"></i>
                        <p>Transactions</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Payments History</a>
                        <a href="{{ route('transaction.membershipRequest') }}"><i class="fa-solid fa-chart-simple"></i>Membership Requests</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <i class="fa-solid fa-chart-simple"></i>
                        <p>Reports & Analytics</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Revenue Reports</a>
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Gym Analytics</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <i class="fa-solid fa-chart-simple"></i>
                        <p>Settings </p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Control Panel</a>
                        <a href="{{ route('equipment.show') }}"><i class="fa-solid fa-chart-simple"></i>Gym Equipments</a>
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Reviews</a>
                        <a href="#"><i class="fa-solid fa-chart-simple"></i>Reminders</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="menu-section logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{route('logout')}}" onclick="event.preventDefault();
                                this.closest('form').submit();">
                <div class="logout-container">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <p>Log out</p>
                </div>
            </a>
        </form>
    </div>
</div>