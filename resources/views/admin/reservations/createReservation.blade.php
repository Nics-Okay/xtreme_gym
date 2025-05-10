@extends('layouts.AdminLayout')

@section('title', 'Reservation Management - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/admin/createReservation.css') }}">
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
            <div class="crud-container">
                <div class="crud-content">
                    <h3>Add New Reservation</h3>

                    <form method="post" action="{{ route('reservation.store') }}">
                        @csrf

                        <div class="section-create-reservation-left">
                            <h3 style="text-align: center;">Client Information</h3>
                            <div class="crud-form">
                                
                                <div class="form-full">
                                    <label for="user_id">User ID</label>
                                    <input type="text" name="user_id" id="user_id" minlength="14" maxlength="14" value="{{ old('user_id') }}" placeholder="User ID">
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const userIdInput = document.getElementById('user_id');
                                        const nameInput = document.getElementById('name');
                                        const phoneNumberInput = document.getElementById('number');
                                        const addressInput = document.getElementById('address');
                                        let lastFetchedId = '';

                                        userIdInput.addEventListener('input', function () {
                                            const userId = userIdInput.value;

                                            if (userId.length === 14 && userId !== lastFetchedId) {
                                                lastFetchedId = userId;

                                                fetch(`/users/${userId}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.success) {
                                                            userIdInput.classList.remove('error');
                                                            nameInput.value = data.data.name;
                                                            phoneNumberInput.value = data.data.phone_number;
                                                            addressInput.value = data.data.address;
                                                        } else {
                                                            userIdInput.classList.add('error');
                                                            nameInput.value = '';
                                                            phoneNumberInput.value = '';
                                                            addressInput.value = '';
                                                            alert(data.message);
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error('Error fetching user data:', error);
                                                        alert('An error occurred while fetching user data.');
                                                    });

                                            }

                                            if (userId.length < 14) {
                                                lastFetchedId = '';
                                            }
                                        });
                                    });
                                </script>

                                <div class="form-full">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter Full Name" required>
                                </div>

                                <div class="form-group">
                                    <div class="form-content">
                                        <label for="number">Phone Number</label>
                                        <input type="text" name="number" id="number" value="{{ old('number') }}" placeholder="Enter Phone Number" required>
                                    </div>
                                    <div class="form-content">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="Customer Address" required>
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
                                        <label for="number_of_people">Number of People</label>
                                        <input type="number" name="number_of_people" id="number_of_people" value="{{ old('number_of_people') }}" placeholder="Enter Number of People">
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const facilitySelect = document.getElementById('facility_id');
                                        const numberOfPeopleInput = document.getElementById('number_of_people');

                                        facilitySelect.addEventListener('change', function () {
                                            const selectedFacility = facilitySelect.options[facilitySelect.selectedIndex];
                                            const maxCapacity = selectedFacility.getAttribute('data-max-capacity');

                                            if (maxCapacity) {
                                                numberOfPeopleInput.setAttribute('max', maxCapacity); // Set max capacity
                                            }
                                        });
                                    });
                                </script>

                                <div class="form-group">
                                    <div class="form-content">
                                        <label for="reservation_date">Reservation Date</label>
                                        <input type="date" id="reservation_date" name="reservation_date" value="{{ old('reservation_date') }}" required>
                                    </div>
                                    <div class="form-content">
                                        <label for="payment_status">Payment Status</label>
                                        <input type="text" name="payment_status" id="payment_status" value="{{ old('payment_status') }}" placeholder="Ex. Completed, Pending" required>
                                    </div>
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
                            </div>
                        </div>

                        <div class="section-create-reservation-right">

                            <h3 style="text-align: center;">Select Reservation Time</h3>

                            <div class="time-grid" id="timeGrid">
                                <!-- Time slots dynamically generated by JavaScript -->
                            </div>

                            <div class="reservation-start-end-time">
                                <div class="feedback" id="feedback">Select consecutive hours.</div>
                            </div>

                            <!-- Hidden input fields for start_time and end_time -->
                            <input type="hidden" name="start_time" id="start_time" required>
                            <input type="hidden" name="end_time" id="end_time" required>

                            <div class="cn-reservation-button-container">
                                <button class="reset-button" id="resetButton">Reset Time</button>
                                <div class="submit-button">
                                    <input type="submit" value="Confirm">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timeGrid = document.getElementById('timeGrid');
            const feedback = document.getElementById('feedback');
            const resetButton = document.getElementById('resetButton');
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

            // Reset all selections
            function resetSelections() {
                selected = [];
                document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
                updateFeedback([]);
            }

            // Add event listener to reset button
            resetButton.addEventListener('click', resetSelections);

        });
    </script>
@endsection