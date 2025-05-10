@extends('layouts.AdminLayout')

@section('title', 'Reservations')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reservations-test.css') }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Facility Reservations</h2>
            <div class="page-button">
                <a href="{{ route('reservation.create') }}"><ion-icon name="add-outline"></ion-icon>Add New Reservation</a>
            </div>
        </div>
        <div class="page-content">
            <div class="reservations">
                <div class="rs-section-ongoing-and-calendar">
                    @include('admin.reservations.ongoingReservation')
                    <div class="rs-section-calendar">
                        <div id="rs-main-calendar" class="calendar"></div> 
                    </div>
                </div>
                @include('admin.reservations.upcomingReservation')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('rs-main-calendar'); // Updated calendar name
            if (!calendarEl) return;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                events: {
                    url: '/admin/reservations/fetch',
                    method: 'GET',
                    failure: function () {
                        alert('Error fetching calendar events!');
                    }
                },
                eventContent: function (arg) {
                    const count = arg.event.extendedProps.count || 0;
                    const date = arg.event.startStr;
                    return {
                        html: `
                            <div class="reservation-day">
                                <h3>Reservations</h3>
                                <div class="count">${count}</div>
                                <a class="btn-view-details" href="/admin/reservations/view-details/${date}">View Details</a>
                            </div>
                        `
                    };
                }
            });

            calendar.render();
        });
    </script>

@endsection

