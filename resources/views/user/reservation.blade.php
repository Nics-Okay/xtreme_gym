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
                        @if(!$ongoingReservations || $ongoingReservations->isEmpty())
                            <p>No ongoing reservation. Create new reservation <a href="" id="openModalButtonTwo">here. </a></p>
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
                <div class="form-group">
                    <div class="form-content">
                        <label for="number">Phone Number</label>
                        <input type="text" name="number" id="number" value="{{ old('number', $user->number ?? '') }}" placeholder="Enter Phone Number" required>
                    </div>
                    <div class="form-content">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $user->address ?? '') }}" placeholder="Enter Your Address" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-content">
                        <label for="facility_id">Facility</label>
                        <select name="facility_id" id="facility_id" required>
                            <option value="" disabled {{ old('facility_id') ? '' : 'selected' }}>- Select Facility -</option>
                            @foreach ($facility_lists as $facility_list)
                                <option value="{{ $facility_list->id }}" data-max-capacity="{{ $facility_list->max_capacity }}" {{ old('facility_id') == $facility_list->id ? 'selected' : '' }}>
                                    {{ $facility_list->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-content">
                        <label for="reservation_date">Reservation Date</label>
                        <input type="date" id="reservation_date" name="reservation_date" value="{{ old('reservation_date') }}" required>
                    </div>
                </div>

                <div class="section-create-reservation-right">
                    <h4 style="text-align: center;">Select Reservation Time</h4>

                    <div class="time-grid" id="timeGrid">
                        <!-- Time slots dynamically generated by JavaScript -->
                    </div>

                    <div class="reservation-start-end-time">
                        <div class="feedback" id="feedback">Select consecutive hours.</div>
                    </div>

                    <!-- Hidden input fields for start_time and end_time -->
                    <input type="hidden" name="start_time" id="start_time" required>
                    <input type="hidden" name="end_time" id="end_time" required>
                </div>

                <div class="form-group payment">
                    <label for="payment_method" style="font-weight: bold;">Payment Method</label>
                    <div class="payment-options">
                        <label>
                            <input type="radio" name="payment_method" value="cash" required 
                            {{ old('payment_method') == 'cash' || old('payment_method') == '' ? 'checked' : '' }}> Cash
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="gcash" required 
                                {{ old('payment_method') == 'gcash' ? 'checked' : '' }}> GCash
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="card" required 
                                {{ old('payment_method') == 'card' ? 'checked' : '' }}> Card
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="other" id="other-payment" 
                                {{ old('payment_method') == 'other' ? 'checked' : '' }}> Other
                        </label>

                        <div id="other-payment-method" style="display: {{ old('payment_method') == 'other' ? 'block' : 'none' }};">
                            <input type="text" name="other_payment_method" placeholder="Please specify" value="{{ old('other_payment_method') }}">
                        </div>
                    </div>
                </div>

                <script>
                    document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
                        radio.addEventListener('change', function() {
                            if (document.getElementById('other-payment').checked) {
                                document.getElementById('other-payment-method').style.display = 'block';
                                document.querySelector('input[name="other_payment_method"]').setAttribute('required', 'required');
                            } else {
                                document.getElementById('other-payment-method').style.display = 'none';
                                document.querySelector('input[name="other_payment_method"]').removeAttribute('required');
                            }
                        });
                    });
                </script>

                <div class="form-buttons">
                    <button type="button" class="cancel" id="cancelModalButton">Cancel</button>
                    <button type="submit" class="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timeGrid = document.getElementById('timeGrid');
            const feedback = document.getElementById('feedback');
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            const hours = Array.from({ length: 16 }, (_, i) => i + 6);
            let reserved = [];
            let selected = [];

            const reservationDateInput = document.getElementById('reservation_date');
            reservationDateInput.addEventListener('change', function () {
                const reservationDate = reservationDateInput.value;
                fetchReservedSlots(reservationDate);
            });

            function fetchReservedSlots(date) {
                fetch(`/reservations/fetchReservedSlots?date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            reserved = data.reservedSlots;
                            updateTimeSlots();
                        } else {
                            alert('Error fetching reserved time slots');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while fetching reserved time slots.');
                    });
            }

            function updateTimeSlots() {
                const timeGrid = document.getElementById('timeGrid');
                timeGrid.innerHTML = ''; // Clear previous time slots

                hours.forEach(hour => {
                    const slot = document.createElement('div');
                    slot.classList.add('time-slot');
                    slot.textContent = formatTimeRange(hour, hour + 1);
                    slot.dataset.hour = hour;

                    // Mark as unavailable if reserved
                    if (reserved.includes(hour)) {
                        slot.classList.add('unavailable');
                    }

                    slot.addEventListener('click', function () {
                        handleSlotClick(slot);
                    });

                    timeGrid.appendChild(slot);
                });
            }

            function formatHiddenTime(hour) {
                return `${hour.toString().padStart(2, '0')}:00`;
            }

            function formatTimeRange(startHour, endHour) {
                const format = hour => {
                    const period = hour >= 12 ? 'PM' : 'AM';
                    const hour12 = hour % 12 || 12;
                    return `${hour12}:00 ${period}`;
                };
                return `${format(startHour)} - ${format(endHour)}`;
            }

            // Function to update feedback based on selected times
            function updateFeedback(selectedHours) {
                if (selectedHours.length === 0) {
                    feedback.textContent = 'Select consecutive hours.';
                    startTimeInput.value = '';
                    endTimeInput.value = '';
                    return;
                }

                selectedHours.sort((a, b) => a - b);
                feedback.textContent = `Selected Time: ${formatTimeRange(selectedHours[0], selectedHours[selectedHours.length - 1] + 1)}`;
                startTimeInput.value = formatHiddenTime(selectedHours[0]);
                endTimeInput.value = formatHiddenTime(selectedHours[selectedHours.length - 1] + 1);
            }

            function handleSlotClick(slot) {
                const hour = parseInt(slot.dataset.hour);

                if (slot.classList.contains('unavailable')) return;

                if (selected.length === 0) {
                    // Start selection
                    selected.push(hour);
                    slot.classList.add('selected');
                } else {
                    const min = Math.min(...selected);
                    const max = Math.max(...selected);

                    if (hour < min || hour > max) {
                        // Attempting to set an end time
                        const range = [...Array(Math.abs(hour - min) + 1).keys()].map(i =>
                            hour < min ? min - i : min + i
                        );

                        // Check for unavailable slots
                        const unavailable = range.some(h => reserved.includes(h));
                        if (unavailable) {
                            alert('Cannot select range with unavailable hours.');
                            return;
                        }

                        // Select all hours in the range
                        selected = range;
                        document.querySelectorAll('.time-slot').forEach(s => {
                            if (range.includes(parseInt(s.dataset.hour))) {
                                s.classList.add('selected');
                            } else {
                                s.classList.remove('selected');
                            }
                        });
                    } else {
                        // Clear selection if clicked within range
                        selected = [];
                        document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                    }
                }

                updateFeedback(selected);
            }
        });
    </script>

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
                    <!-- Fix: Changed to use pastReservation -->
                    <div class="reservation-info past">
                        <h4>Date:</h4>
                        <p>{{ \Carbon\Carbon::parse($pastReservation->reservation_date)->format('F j, Y') }}, 
                            {{ $pastReservation->start_time ? \Carbon\Carbon::parse($pastReservation->start_time)->format('g:i A') : 'Not set' }}
                            -
                            {{ $pastReservation->end_time ? \Carbon\Carbon::parse($pastReservation->end_time)->format('g:i A') : 'Not set' }}
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
        const openModalButtonTwo = document.getElementById('openModalButtonTwo');
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

        openModalButtonTwo.addEventListener('click', (e) => {
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
