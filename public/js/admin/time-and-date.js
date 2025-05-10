document.addEventListener('DOMContentLoaded', function () {
    function initClock() {
        function updateClockAndDate() {
            const clockElement = document.getElementById('clock');
            const dateElement = document.getElementById('date');
            const now = new Date();

            // Time formatting
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const amPm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;

            // Date formatting
            const options = { month: 'long', day: 'numeric', year: 'numeric' };
            const formattedDate = now.toLocaleDateString(undefined, options);

            // Update elements if they exist
            if (clockElement) {
                clockElement.textContent = `${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${amPm}`;
            }
            if (dateElement) {
                dateElement.textContent = formattedDate;
            }
        }

        setInterval(updateClockAndDate, 1000);
        updateClockAndDate();
    }

    initClock();
});