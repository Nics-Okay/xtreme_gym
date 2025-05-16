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
                            id: event.id, 
                            payment_status: event.payment_status,
                            time: `${start12Hour} - ${end12Hour}`,
                            description: event.reservation_type
                        }
                    };
                }),
                eventContent: function (arg) {
                    let eventDetails = document.createElement('div');
                    eventDetails.style.position = 'relative';

                    const editUrl = `{{ route('reservation.edit', ['reservation' => ':id']) }}`.replace(':id', arg.event.extendedProps.id);
                    const markAsPaidUrl = `{{ route('reservation.paid', ['reservation' => ':id']) }}`.replace(':id', arg.event.extendedProps.id);
                    const cancelUrl = `{{ route('reservation.cancel', ['reservation' => ':id']) }}`.replace(':id', arg.event.extendedProps.id);

                    let actionsHtml = '';

                    if (arg.event.extendedProps.payment_status !== 'paid') {
                        actionsHtml += `
                            <form action="${markAsPaidUrl}" method="post" style="display: inline;">
                                @csrf
                                @method('patch')
                                <button type="submit" class="mark-paid-button">
                                    <i class="fa-solid fa-wallet"></i> Pay
                                </button>
                            </form>
                        `;
                    } else {
                        actionsHtml += `
                            <button type="button" class="mark-paid-button" disabled style="background-color: #aaa; cursor: not-allowed;">
                                <i class="fa-solid fa-check-circle"></i> Paid
                            </button>
                        `;
                    }

                    actionsHtml += `
                        <a href="${editUrl}" class="edit-button">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <form action="${cancelUrl}" method="post" style="display: inline;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="cancel-button">
                                <i class="fa-solid fa-xmark"></i> Cancel
                            </button>
                        </form>
                    `;

                    eventDetails.innerHTML = `
                        <div>
                            <div class="fc-list-event-title">${arg.event.title}</div>
                            <div class="fc-list-event-time">${arg.event.extendedProps.time || ''}</div>
                            <div class="fc-list-event-description">${arg.event.extendedProps.description || ''}</div>
                            <div class="fc-event-actions">
                                ${actionsHtml}
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
