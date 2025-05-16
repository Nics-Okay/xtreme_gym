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

        const initialStartTime = startTimeInput.value;
        const initialEndTime = endTimeInput.value;
        if (initialStartTime) {
            startTimeInput.value = initialStartTime;
        }
        if (initialEndTime) {
            endTimeInput.value = initialEndTime;
        }

        if (reservationDateInput.value) {
            fetchReservedSlots(reservationDateInput.value);
        }

        reservationDateInput.addEventListener('change', function () {
            const reservationDate = reservationDateInput.value;
            fetchReservedSlots(reservationDate);
        });

        function fetchReservedSlots(date) {
            if (!date) return;

            fetch(`/reservations/fetchReservedSlots?date=${date}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        reserved = data.reservedSlots;
                        selected = [];
                        
                        currentReservation = {
                            startHour: parseInt(startTimeInput.value.split(':')[0]),
                            endHour: parseInt(endTimeInput.value.split(':')[0]),
                        };
                        updateTimeSlots();
                        updateFeedback(selected);
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
            timeGrid.innerHTML = '';

            hours.forEach(hour => {
                const slot = document.createElement('div');
                slot.classList.add('time-slot');
                slot.textContent = formatTimeRange(hour, hour + 1);
                slot.dataset.hour = hour;

                if (reserved.includes(hour) && !(hour >= parseInt(initialStartTime.split(':')[0]) && hour < parseInt(initialEndTime.split(':')[0]))) {
                    slot.classList.add('unavailable');
                }

                if (hour >= parseInt(initialStartTime.split(':')[0]) && hour < parseInt(initialEndTime.split(':')[0])) {
                    slot.classList.add('selected');
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

        let currentReservation = {
            startHour: parseInt(initialStartTime.split(':')[0]),
            endHour: parseInt(initialEndTime.split(':')[0]),
        };

        function handleSlotClick(slot) {
            const hour = parseInt(slot.dataset.hour);

            if (slot.classList.contains('unavailable') &&
                (hour < currentReservation.startHour || hour >= currentReservation.endHour)) {
                return;
            }

            if (selected.length === 0) {
                selected.push(hour);
                slot.classList.add('selected');
            } else {
                const min = Math.min(...selected);
                const max = Math.max(...selected);

                if (hour >= min && hour <= max) {
                    selected = selected.filter(h => h !== hour); // Remove hour from selection
                    slot.classList.remove('selected');
                } else {
                    const range = [...Array(Math.abs(hour - min) + 1).keys()].map(i =>
                        hour < min ? min - i : min + i
                    );

                    // Validate unavailable slots, excluding the current reservation
                    const unavailable = range.some(h =>
                        reserved.includes(h) &&
                        (h < currentReservation.startHour || h >= currentReservation.endHour)
                    );

                    if (unavailable) {
                        alert('Cannot select range with unavailable hours (except current reservation).');
                        return;
                    }

                    selected = range;
                    document.querySelectorAll('.time-slot').forEach(s => {
                        if (range.includes(parseInt(s.dataset.hour))) {
                            s.classList.add('selected');
                        } else {
                            s.classList.remove('selected');
                        }
                    });
                }
            }

            updateFeedback(selected);
        }

        function resetSelections() {
            selected = [];
            document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
            updateFeedback([]);
        }

        resetButton.addEventListener('click', resetSelections);

    });
</script>


LGT
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

        if (reservationDateInput.value) {
            fetchReservedSlots(reservationDateInput.value);
        }

        reservationDateInput.addEventListener('change', function () {
            const reservationDate = reservationDateInput.value;
            fetchReservedSlots(reservationDate);
        });

        function fetchReservedSlots(date) {
            if (!date) return;

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
            timeGrid.innerHTML = '';

            hours.forEach(hour => {
                const slot = document.createElement('div');
                slot.classList.add('time-slot');
                slot.textContent = formatTimeRange(hour, hour + 1);
                slot.dataset.hour = hour;

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
                selected.push(hour);
                slot.classList.add('selected');
            } else {
                const min = Math.min(...selected);
                const max = Math.max(...selected);

                if (hour < min || hour > max) {
                    const range = [...Array(Math.abs(hour - min) + 1).keys()].map(i =>
                        hour < min ? min - i : min + i
                    );

                    const unavailable = range.some(h => reserved.includes(h));
                    if (unavailable) {
                        alert('Cannot select range with unavailable hours.');
                        return;
                    }

                    selected = range;
                    document.querySelectorAll('.time-slot').forEach(s => {
                        if (range.includes(parseInt(s.dataset.hour))) {
                            s.classList.add('selected');
                        } else {
                            s.classList.remove('selected');
                        }
                    });
                } else {
                    selected = [];
                    document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                }
            }

            updateFeedback(selected);
        }

        function resetSelections() {
            selected = [];
            document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
            updateFeedback([]);
        }

        resetButton.addEventListener('click', resetSelections);

    });
</script>