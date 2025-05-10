@extends('layouts.UserDesign')

@section('title', 'Module - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reservations.css') }}">
@endsection

@section('main-content')
    <!-- Design -->
    <style>
        .main-section {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
            padding: 0 10px 10px;
            overflow-y: auto;
        }
    </style>

    <!-- Structure -->
    <div class="user-content-container">
        <div class="user-content-header">
            <h3>Welcome to Xtreme {{ $user->first_name }} !</h3>
        </div>
        <div class="user-main-content">
            <div class="main-section">
                <div class="main-home">
                    <div class="section-one">
                        @if (strtolower($user->membership_status) === 'inactive')
                        <p>Avail your first membership here.</p>
                        @elseif (strtolower($user->membership_status) === 'expired')
                        <p>Your membership has expired. Renew <a href="{{ route('user.membership') }}">here.</a></p>
                        @else
                        <p>Membership Status: {{ ucfirst($user->membership_status) }} {{ ucfirst($user->membership_type) }} Membership</p>
                        <p>Validity: {{ $user->membership_validity }}</p>
                        @endif
                    </div>
                    <div class="section-two">
                        <div class="info one">
                            <p>Gym active hours</p>
                            <p>{{ $user->active_hours }}</p>
                        </div>
                        <div class="info two">
                            <p>Total visits</p>
                            <p>{{ $user->visits }}</p>
                        </div>
                    </div>
                    <h4>
                        Xtreme Gym World Presenting:
                    </h4>
                    <div class="section-three-carousel">
                        <div class="carousel">
                            @foreach ($carouselImages as $key => $image)
                            <div class="carousel-item" style="{{ $key === 0 ? 'display: block;' : 'display: none;' }}">
                                <img src="{{ asset('storage/carousel/' . $image->filename) }}" alt="Slide {{ $key + 1 }}">
                            </div>
                            @endforeach
                        </div>

                        <div class="carousel-nav">
                            <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
                            <button class="next" onclick="changeSlide(1)">&#10095;</button>
                        </div>
                    </div>
                    <h4>Xtreme Events</h4>
                    <div class="section-four">
                        @if($events->isEmpty())
                        <p>Events will be shown here. Nothing exists at the moment.</p>
                        @else
                        @foreach($events as $event)
                        <div class="event">
                            <h3>{{ $event->name }}</h3>
                            <p><strong>What:</strong> {{ $event->event_type }}</p>
                            <p><strong>When:</strong> {{ $event->date ?? 'To be announced'}}</p>
                            <p><strong>Description: </strong>{{ $event->description }}</p>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Carousel functionality
        let currentIndex = 0;
        const slides = document.querySelectorAll('.carousel-item');

        function changeSlide(direction) {
            // Hide the current slide
            slides[currentIndex].style.display = 'none';

            // Update index
            currentIndex = (currentIndex + direction + slides.length) % slides.length;

            // Show the new slide
            slides[currentIndex].style.display = 'block';
        }

        // Auto-play functionality (optional)
        setInterval(() => {
            changeSlide(1);
        }, 5000); // 5 seconds interval
    </script>

@endsection

@section('js-container')
<!-- Backup Js -->
@endsection