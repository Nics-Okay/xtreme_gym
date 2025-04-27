<div class="menu-container">
    <h1>XTREME</h1>

    <div class="menu-section time-date">
        <div class="timeDate">
            <div id="clock"></div>
            <div id="date"></div>
        </div>
        <button id="lock-toggle" onclick="toggleLock()">
            <ion-icon name="{{ auth()->user()->locked ? 'lock-closed' : 'lock-open' }}"></ion-icon>
        </button>
    </div>

    <div class="menu-section underline"></div>

    <div class="menu-content">
        <ul>
            <li><a href="{{ route('dashboard') }}" class="menu-name dashboard"><div class="icon-box"><i class="fa-solid fa-chart-simple"></i></div><p>Dashboard</p></a>
            </li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <p>Members</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('member.show') }}" class="menu-name manage-members"><i class="fa-solid fa-users"></i>Manage Members</a>
                        <a href="{{ route('transaction.membershipRequest') }}" class="menu-name membership-requests"><i class="fa-solid fa-users"></i>Membership Requests</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <div class="icon-box">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <p>Guest & Attendees</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('guest.show') }}" class="menu-name manage-guests"><i class="fa-solid fa-chart-simple"></i>Manage Guests</a>
                        <a href="{{ route('attendee.show') }}" class="menu-name attendance"><i class="fa-solid fa-chart-simple"></i>Manage Attendees</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <p>Classes & Trainers</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('trainer.show') }}" class="menu-name manage-trainers"><i class="fa-solid fa-chart-simple"></i>Trainer Management</a>
                        <a href="{{ route('training.show') }}" class="menu-name manage-trainers"><i class="fa-solid fa-chart-simple"></i>Training Management</a>
                        <a href="{{ route('apprentice.show') }}" class="menu-name manage-trainers"><i class="fa-solid fa-chart-simple"></i>Apprentice Management</a>
                        <a href="{{ route('classList.show') }}" class="menu-name class-schedules"><i class="fa-solid fa-chart-simple"></i>Class Management</a>
                        <a href="{{ route('student.show') }}" class="menu-name students"><i class="fa-solid fa-chart-simple"></i>Student Management</a>
                    </div>
                </div>
            </li>
            <li><a href="{{ route('calendar') }}" class="menu-name reservations">
                    <div class="icon-box">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    Reservations
                </a>
            </li>
            <li><a href="{{ route('rate.show') }}" class="menu-name events">
                    <div class="icon-box">
                        <i class="fas fa-solid fa-users"></i>
                    </div>
                    Membership Plans
                </a>
            </li>

            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <p>Events & Tournaments</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('event.show') }}" class="menu-name manage events"><i class="fa-solid fa-users"></i>Events Management</a>
                        <a href="{{ route('tournaments.index') }}" class="menu-name tournaments"><i class="fa-solid fa-users"></i>Tournament Management</a>
                    </div>
                </div>
            </li>

            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fas fa-money-bill-alt"></i>
                        </div>
                        <p>Transactions</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('transaction.show') }}" class="menu-name payments-history"><i class="fa-solid fa-chart-simple"></i>Payments History</a>
                        <a href="{{ route('transaction.studentRequest') }}" class="menu-name class-schedules"><i class="fa-solid fa-chart-simple"></i>Student Request</a>
                        <a href="{{ route('transaction.apprenticeRequest') }}" class="menu-name manage-trainers"><i class="fa-solid fa-chart-simple"></i>Apprentice Request</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <p>Reports & Analytics</p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="#" class="menu-name revenue-reports"><i class="fa-solid fa-chart-simple"></i>Revenue Reports</a>
                        <a href="#" class="menu-name gym-analytics"><i class="fa-solid fa-chart-simple"></i>Gym Analytics</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="menu">
                    <div class="menu-item" onclick="toggleDropdown()">
                        <div class="icon-box">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <p>Settings </p>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </div>
                    <div class="dropdown-content" id="dropdown">
                        <a href="{{ route('control.show')}}" class="menu-name control-panel"><i class="fa-solid fa-chart-simple"></i>Control Panel</a>
                        <a href="{{ route('equipment.show') }}" class="menu-name gym-equipments"><i class="fa-solid fa-chart-simple"></i>Gym Equipments</a>
                        <a href="{{ route('notification.show') }}" class="menu-name reminders"><i class="fa-solid fa-chart-simple"></i>Notifications</a>
                        <a href="{{ route('review.show') }}" class="menu-name reviews"><i class="fa-solid fa-chart-simple"></i>Reviews</a>
                        <a href="{{ route('profileNew.show') }}" class="menu-name profile-settings"><i class="fa-solid fa-chart-simple"></i>Profile Settings</a>
                    </div>
                </div>
            </li>
            <li>
                <form method="post" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <a href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); this.closest('form').submit();"    >
                        <div class="icon-box">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </div>
                        Log out
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <div class="menu-section user">
        <div class="user-profile" onclick="window.location.href='{{ route('profileNew.show')}}'">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/profile-placeholder.png') }}" 
            alt="Profile Image">
        </div>
        <div class="user-info">
            <p class="user name">{{ $user->first_name ?? ' '}}</p>
            <p class="user role">{{ $user->user_type ?? 'Undefined'}}</p>
        </div>
    </div>
</div>
