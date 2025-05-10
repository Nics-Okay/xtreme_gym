@extends('layouts.AdminLayout')

@section('title', 'Reservations')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/final-reservation.css') }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Facilitey Reservations</h2>
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

    <div id="rs-modal-overlay" style="display: none;"></div>
    <div id="rs-view-details-modal" style="display: none;">
        <button class="close-btn" onclick="closeRsViewDetailsModal()"><i class="fas fa-times"></i></button>
        <div class="modal-content">
            <div id="rs-list-day-calendar"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('rs-main-calendar');
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
                    return {
                        html: `
                            <div class="reservation-day">
                                <h3>Reservations</h3>
                                <div class="count">${count}</div>
                                <a class="btn-view-details" onclick="openRsViewDetailsModal('${arg.event.start}')">View Details</a>
                            </div>
                        `
                    };
                }
            });

            calendar.render();

            window.openRsViewDetailsModal = function (date) {
                if (!date) {
                    alert('Invalid date passed to modal!');
                    return;
                }
                const formattedDate = new Date(date).toISOString().split('T')[0];
                const modal = document.getElementById('rs-view-details-modal');
                const overlay = document.getElementById('rs-modal-overlay');
                const listDayEl = document.getElementById('rs-list-day-calendar');

                while (listDayEl.firstChild) listDayEl.removeChild(listDayEl.firstChild);

                const listDayCalendar = new FullCalendar.Calendar(listDayEl, {
                    initialView: 'listDay',
                    initialDate: formattedDate,
                    headerToolbar: {
                        left: 'prev',
                        center: 'title',
                        right: 'next'
                    },
                    events: {
                        url: `/admin/reservations/get-events-by-date?date=${formattedDate}`,
                        method: 'GET',
                        failure: function () {
                            alert('Error fetching reservations for this day!');
                        }
                    },
                    eventContent: function (arg) {
                        let eventDetails = document.createElement('div');
                        eventDetails.innerHTML = `
                                <div>
                                    <div class="fc-list-event-title">${arg.event.title}</div>
                                    <div class="fc-list-event-time">${arg.event.extendedProps.time || ''}</div>
                                    <div class="fc-list-event-description">${arg.event.extendedProps.description || ''}</div>
                                </div>
                            `;
                            return { domNodes: [eventDetails] };
                    }
                });

                listDayCalendar.render();

                modal.style.display = 'block';
                overlay.style.display = 'block';
            };

            window.closeRsViewDetailsModal = function () {
                document.getElementById('rs-view-details-modal').style.display = 'none';
                document.getElementById('rs-modal-overlay').style.display = 'none';
            };
        });
    </script>

@endsection