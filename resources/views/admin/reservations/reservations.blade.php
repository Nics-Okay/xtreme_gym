@extends('layouts.AdminLayout')

@section('title', 'Reservations')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reservations.css') }}">
    <!-- Add FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />

    <meta name="calendar-events-route" content="{{ route('calendar.events') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Facility Reservations</h2>
            <div class="page-button">
                <a href="#"><ion-icon name="add-outline"></ion-icon>Add New Reservation</a>
            </div>
        </div>
        <div class="page-content">
            <div class="reservations">
                <div class="reservations-calendar">
                    <div id="calendar"></div> 
                    <div class="ongoing-list">
                        <p class="list-title">Ongoing Reservations:</p>
                        @if($ongoingReservations->isEmpty())
                            <p>No ongoing reservations.</p>
                        @else
                            @foreach($ongoingReservations as $ongoingReservation)
                                <div class="list-item">
                                    <span style="display: inline-flex; align-items: center;">
                                        <h4 style="margin: 0;">{{ $ongoingReservation->name }}</h4>
                                        <span style="margin: 0 0.5rem;">&bull;</span> <!-- This is the bullet -->
                                        <p>
                                            {{ \Carbon\Carbon::parse($ongoingReservation->reservation_date)->format('F j, Y') }},
                                            {{ $ongoingReservation->start_time ? \Carbon\Carbon::parse($ongoingReservation->start_time)->format('g:i A') : 'Unspecified start time' }}
                                            -
                                            {{ $ongoingReservation->end_time ? \Carbon\Carbon::parse($ongoingReservation->end_time)->format('g:i A') : 'Unspecified end time' }}
                                        </p>
                                    </span>
                                    <span><p>Phone: {{ $ongoingReservation->number ?? 'Number not provided.'}}</p></span>
                                    <span><p>Payment Status: {{ $ongoingReservation->payment_status ?? 'Unpaid' }}</p></span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="upcoming-reservations">
                    <div class="list">
                        <p class="list-title">Upcoming Reservations:</p>
                        @if($upcomingReservations->isEmpty())
                            <p>No upcoming reservations.</p>
                        @else
                            @foreach($upcomingReservations as $upcomingReservation)
                                <div class="list-item">
                                    <span style="display: inline-flex; align-items: center;">
                                        <h4 style="margin: 0;">{{ $upcomingReservation->name }}</h4>
                                        <span style="margin: 0 0.5rem;">&bull;</span>
                                        <p style="margin: 0;">{{ $upcomingReservation->number_of_people ?? 'No. of people not set.' }}</p>
                                    </span>
                                    <p>
                                        Date: 
                                        {{ \Carbon\Carbon::parse($upcomingReservation->reservation_date)->format('F j, Y') }},
                                        {{ $upcomingReservation->start_time ? \Carbon\Carbon::parse($upcomingReservation->start_time)->format('g:i A') : 'Unspecified start time' }}
                                        -
                                        {{ $upcomingReservation->end_time ? \Carbon\Carbon::parse($upcomingReservation->end_time)->format('g:i A') : 'Unspecified end time' }}
                                    </p>
                                    <span><p>Phone: {{ $upcomingReservation->number ?? 'Number not provided.'}}</p></span>
                                    <span><p>Status: {{ $upcomingReservation->status ?? 'Pending Confirmation'}}</p></span>
                                    <span><p>Payment Status: {{ $upcomingReservation->payment_status ?? 'Unpaid' }}</p></span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="list">
                        <p class="list-title">Past Reservations:</p>
                        @if($pastReservations->isEmpty())
                            <p>No past reservations.</p>
                        @else
                            @foreach($pastReservations as $pastReservation)
                                <div class="list-item">
                                    <span style="display: inline-flex; align-items: center;">
                                        <h4 style="margin: 0;">{{ $pastReservation->name }}</h4>
                                        <span style="margin: 0 0.5rem;">&bull;</span> <!-- This is the bullet -->
                                        <p style="margin: 0;">{{ $pastReservation->number_of_people ?? 'No. of people not set.' }}</p>
                                    </span>
                                    <p>
                                        Date: 
                                        {{ \Carbon\Carbon::parse($pastReservation->reservation_date)->format('F j, Y') }},
                                        {{ $pastReservation->start_time ? \Carbon\Carbon::parse($pastReservation->start_time)->format('g:i A') : 'Unspecified start time' }}
                                        -
                                        {{ $pastReservation->end_time ? \Carbon\Carbon::parse($pastReservation->end_time)->format('g:i A') : 'Unspecified end time' }}
                                    </p>
                                    <span><p>Phone: {{ $pastReservation->number ?? 'Number not provided.'}}</p></span>
                                    <span><p>Status: {{ $pastReservation->status ?? 'Pending Confirmation'}}</p></span>
                                    <span><p>Payment Status: {{ $pastReservation->payment_status ?? 'Unpaid' }}</p></span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-container')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="{{ asset('js/admin/calendar.js') }}"></script>
@endsection


