<div class="menu-container" id="menu-container">
    <div class="close-menu">
        <i class="fa-solid fa-bars" id="close-button"></i>
    </div> 
    <a href="{{ route('profileUser.show') }}" class="profile-section">
        <div class="profile-holder">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/profile-placeholder.png') }}" alt="Member Image">
        </div>
    </a>
    <div class="user-info">
        <p class="user name">{{ $user->first_name ?? ' '}} {{  $user->last_name ?? ' ' }}</p>
        <p class="user member-since"><i>ID: {{ $user->unique_id }}</i></p>
    </div>
    <div class="menu-content">
        <ul>
            <li><a href="{{ route('user.home') }}"><ion-icon name="home" id="nav-homepage-icon"></ion-icon>Home</a></li>
            <li><a href="{{ route('user.membership') }}"><ion-icon name="pricetags"></ion-icon>Membership Plans</a></li>
            <li><a href="{{ route('reservations.create') }}"><ion-icon name="settings" id="nav-settings-icon"></ion-icon></i>Reservations</a></li>
            <li><a href="#"><ion-icon name="calendar"></ion-icon>Personal Training</a></li>
            <li><a href="#"><ion-icon name="calendar"></ion-icon>Gym Classes</a></li>
            <li><a href="#"><ion-icon name="calendar"></ion-icon>Tournaments</a></li>
            <li><a href="{{ route('review.create') }}"><i class="fa-solid fa-chart-simple"></i>Attendance Tracker</a></li>
            <li><a href="{{ route('user.settings') }}"><ion-icon name="settings" id="nav-settings-icon"></ion-icon>Settings</a></li>
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