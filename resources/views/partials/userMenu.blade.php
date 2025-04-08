<div class="menu-container" id="menu-container">
    <div class="close-menu">
        <ion-icon name="close-outline" id="close-button"></ion-icon>
    </div> 
    <a href="#" class="image-container"> 
        <img src="#" alt="">
    </a>
    <div class="user-info">
        <p class="user name">Juanito Geniza</p>
        <p class="user member-since"><i>Member since: 01/15/2025</i></p>
    </div>
    <div class="menu-content">
        <ul>
            <li><a href="{{ route('user.home') }}"><ion-icon name="home" id="nav-homepage-icon"></ion-icon>Home</a></li>
            <li><a href="#"><ion-icon name="calendar"></ion-icon>Reservations</a></li>
            <li><a href="{{ route('user.membership') }}"><ion-icon name="pricetags"></ion-icon>Membership Plans</a></li>
            <li><a href="#"><ion-icon name="settings" id="nav-settings-icon"></ion-icon></i>Reservations</a></li>
            <li><a href="#"><i class="fa-solid fa-chart-simple"></i>Reservations</a></li>
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