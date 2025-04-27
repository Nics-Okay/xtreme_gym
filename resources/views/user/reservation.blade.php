@extends('layouts.UserDesign')

@section('title', 'Reservation - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/reservation.css') }}">
@endsection

@section('main-content')
    <!-- Design -->
    <style>
        .main-section {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
            row-gap: 10px;
            padding: 0 10px 10px;
        }
    </style>
    
    <div class="user-content-container">
        <div class="user-content-header">
            <!--
            <div class="custom-header">
                <a href="{{ route('user.home')}}"><i class="fa-solid fa-arrow-left"></i></a>
                <h3>Module Title</h3> 
            </div>
            -->

            <h3>My Reservations</h3>

            <div class="user-content-button">
                <a href="#" id="openModalButton"><i class="fa-solid fa-plus"></i><span>New</span></a>
            </div>

            <div class="user-content-button-history">
                <a href="#" id="openHistoryModalButton"><i class="fa-solid fa-clock-rotate-left"></i></a>
            </div>
        </div>
        <div class="user-main-content">
            <div class="main-section">
                <div class="ongoing">
                    <p>Current Reservation</p>
                    <div class="ongoing-reservation">
                        @if(!$ongoingReservations)
                            <p>No ongoing reservation.</p>
                        @else
                            <div class="reservation-info on">
                                <h4>ID:</h4>
                                <p>{{ $ongoingReservations->id }}</p>
                            </div>
                            <div class="reservation-info on">
                                <h4>Name:</h4>
                                <p>{{ $ongoingReservations->name }}</p>
                            </div>
                            <div class="reservation-info on">
                                <h4>Facility:</h4>
                                <p>{{ $ongoingReservations->reservation_type ?? 'Not Provided' }}</p>
                            </div>
                            <div class="reservation-info on">
                                <h4>Date:</h4>
                                <p>{{ \Carbon\Carbon::parse($ongoingReservations->reservation_date)->format('F j, Y') }}</p>
                            </div>
                            <div class="reservation-info on">
                                <h4>Time:</h4>
                                <p>{{ $ongoingReservations->start_time ? \Carbon\Carbon::parse($ongoingReservations->start_time)->format('g:i A') : 'Not set' }}
                                    -
                                    {{ $ongoingReservations->end_time ? \Carbon\Carbon::parse($ongoingReservations->end_time)->format('g:i A') : 'Not set' }}</p>
                            </div>
                            <div class="reservation-info on">
                                <h4>Status:</h4>
                                <p>{{ $ongoingReservations->status ?? 'Unconfirmed' }}</p>
                            </div>
                            <div class="reservation-info on">
                                <h4>Payment Status:</h4>
                                <p>{{ $ongoingReservations->payment_status ?? 'Unpaid' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="scheduled">
                    <p>Scheduled Reservations</p>
                    <div class="upcoming-reservation">
                    @if($upcomingReservations->isEmpty())
                        <p>No upcoming reservation.</p>
                    @else
                        @foreach($upcomingReservations as $upcomingReservation)
                            <div class="upcoming-item">
                                <div class="reservation-info">
                                    <h4>ID:</h4>
                                    <p>{{ $upcomingReservation->id }}</p>
                                </div>
                                <div class="reservation-info">
                                    <h4>Name:</h4>
                                    <p>{{ $upcomingReservation->name }}</p>
                                </div>
                                <div class="reservation-info">
                                    <h4>Facility:</h4>
                                    <p>{{ $upcomingReservation->reservation_type ?? 'Not Provided' }}</p>
                                </div>
                                <div class="reservation-info">
                                    <h4>Date:</h4>
                                    <p>{{ \Carbon\Carbon::parse($upcomingReservation->reservation_date)->format('F j, Y') }}, 
                                        {{ $upcomingReservation->start_time ? \Carbon\Carbon::parse($upcomingReservation->start_time)->format('g:i A') : 'Not set' }}
                                        -
                                        {{ $upcomingReservation->end_time ? \Carbon\Carbon::parse($upcomingReservation->end_time)->format('g:i A') : 'Not set' }}
                                    </p>
                                </div>
                                <div class="reservation-info">
                                    <h4>Status:</h4>
                                    <p>{{ $upcomingReservation->status ?? 'Unconfirmed' }}</p>
                                </div>
                                <div class="reservation-info">
                                    <h4>Payment Status:</h4>
                                    <p>{{ $upcomingReservation->payment_status ?? 'Unpaid' }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="reservationModal" class="modal">
        <div class="modal-content">
            <h3>Create New Reservation</h3>
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <div class="form-control">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-control">
                    <label for="reservation_date">Reservation Date</label>
                    <input type="date" id="reservation_date" name="reservation_date" required>
                </div>
                <div class="form-control">
                    <label for="start_time">Start Time</label>
                    <input type="time" id="start_time" name="start_time">
                </div>
                <div class="form-control">
                    <label for="end_time">End Time</label>
                    <input type="time" id="end_time" name="end_time">
                </div>
                <div class="form-buttons">
                    <button type="button" class="cancel" id="cancelModalButton">Cancel</button>
                    <button type="submit" class="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="historyModal" class="modal-history">
        <div class="modal-history-header">
            <button id="closeHistoryModalButton"><ion-icon name="arrow-back-sharp"></ion-icon>Back</button>
        </div>
        <div class="modal-history-content">
            <h3>Past Reservations</h3>
            @foreach($pastReservations as $pastReservation)
                <div class="past-item">
                    <div class="reservation-info past">
                        <h4>ID:</h4>
                        <p>{{ $pastReservation->id }}</p>
                    </div>

                    <div class="reservation-info past">
                        <h4>Name:</h4>
                        <p>{{ $pastReservation->name }}</p>
                    </div>

                    <div class="reservation-info past">
                        <h4>Facility:</h4>
                        <p>{{ $pastReservation->reservation_type ?? 'Not Provided' }}</p>
                    </div>

                    <div class="reservation-info past">
                        <h4>Date:</h4>
                        <p>{{ \Carbon\Carbon::parse($upcomingReservation->reservation_date)->format('F j, Y') }}, 
                            {{ $upcomingReservation->start_time ? \Carbon\Carbon::parse($upcomingReservation->start_time)->format('g:i A') : 'Not set' }}
                            -
                            {{ $upcomingReservation->end_time ? \Carbon\Carbon::parse($upcomingReservation->end_time)->format('g:i A') : 'Not set' }}
                        </p>
                    </div>

                    <div class="reservation-info past">
                        <h4>Status:</h4>
                        <p>{{ $pastReservation->status ?? 'Unconfirmed' }}</p>
                    </div>

                    <div class="reservation-info past">
                        <h4>Payment Status:</h4>
                        <p>{{ $pastReservation->payment_status ?? 'Unpaid' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const openModalButton = document.getElementById('openModalButton');
        const cancelModalButton = document.getElementById('cancelModalButton');
        const reservationModal = document.getElementById('reservationModal');

        const openHistoryModalButton = document.getElementById('openHistoryModalButton');
        const closeHistoryModalButton = document.getElementById('closeHistoryModalButton');
        const historyModal = document.getElementById('historyModal');

        const openModal = () => reservationModal.style.display = 'block';
        const closeModal = () => reservationModal.style.display = 'none';
        const openHistoryModal = () => historyModal.style.display = 'block';
        const closeHistoryModal = () => historyModal.style.display = 'none';

        openModalButton.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });

        cancelModalButton.addEventListener('click', closeModal);

        openHistoryModalButton.addEventListener('click', (e) => {
            e.preventDefault();
            openHistoryModal();
        });

        closeHistoryModalButton.addEventListener('click', closeHistoryModal);

        window.addEventListener('click', (e) => {
            if (e.target === reservationModal) {
                closeModal();
            } else if (e.target === historyModal) {
                closeHistoryModal();
            }
        });
    </script>
@endsection
