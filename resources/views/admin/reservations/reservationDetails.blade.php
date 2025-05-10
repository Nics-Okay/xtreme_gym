@extends('layouts.AdminLayout')

@section('title', 'Reservation Details')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reservationDetails.css') }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('reservation.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Reservations List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="reservations">
                <h2>Reservation Details for {{ $date }}</h2>
                <div class="rs-section-calendar">
                    <div id="rs-list-day-calendar" class="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('rs-list-day-calendar');
            if (!calendarEl) return;

            const reservations = @json($reservations);
            const date = '{{ $date }}';

            function convertTo12Hour(time) {
                const [hour, minute] = time.split(':');
                const period = hour >= 12 ? 'PM' : 'AM';
                const adjustedHour = hour % 12 || 12;
                return `${adjustedHour}:${minute} ${period}`;
            }

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'listDay',
                initialDate: date,
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                events: reservations.map(event => {
                    const start12Hour = convertTo12Hour(event.start_time);
                    const end12Hour = convertTo12Hour(event.end_time);
                    return {
                        title: event.name,
                        start: event.reservation_date + 'T' + event.start_time,
                        end: event.reservation_date + 'T' + event.end_time,
                        extendedProps: {
                            time: `${start12Hour} - ${end12Hour}`,
                            description: event.reservation_type
                        }
                    };
                }),
                eventContent: function (arg) {
                    let eventDetails = document.createElement('div');
                    eventDetails.style.position = 'relative';
                    eventDetails.innerHTML = `
                        <div>
                            <div class="fc-list-event-title">${arg.event.title}</div>
                            <div class="fc-list-event-time">${arg.event.extendedProps.time || ''}</div>
                            <div class="fc-list-event-description">${arg.event.extendedProps.description || ''}</div>
                            <div class="fc-event-actions">
                                <a href="/reservation/edit/${arg.event.id}" class="edit-button">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="/admin/reservations/${arg.event.id}/cancel" method="post">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="cancel-button">
                                        <i class="fa-solid fa-xmark"></i> Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    `;
                    return { domNodes: [eventDetails] };
                }
            });

            calendar.render();
        });
    </script>
@endsection
