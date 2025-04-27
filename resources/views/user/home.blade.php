@extends('layouts.UserDesign')

@section('title', 'Module - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reservations.css') }}">

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
    <meta name="calendar-events-route" content="{{ route('calendar.preview') }}">
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
                        Xtreme Reservations Calendar
                    </h4>
                    <div class="section-three">
                        <div class="calendar" id="calendar">
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

    <!-- Structure -->

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            if (!calendarEl) {
                console.error('Calendar element not found!');
                return;
            }

            const calendar = new FullCalendar.Calendar(calendarEl, {
                eventDisplay: 'block',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'title',
                    right: 'today prev,next'
                },
                events: {
                    url: document.querySelector('meta[name="calendar-events-route"]')?.content || "/calendar/events",
                    method: 'GET',
                    failure: function(error) {
                        console.log('Error fetching events:', error);
                        alert('Error fetching calendar events!');
                    }
                },
                editable: true,
                selectable: true,
                eventClick: function(info) {
                    alert('Reservation Details: ' + info.event.title + "\n" + (info.event.extendedProps.description || ''));
                },
                dateClick: function(info) {
                    alert('Clicked on: ' + info.dateStr);
                },
            });

            calendar.render();
            console.log('FullCalendar initialized.');
        });
    </script>
@endsection

@section('js-container')
    <!-- Backup Js -->
@endsection