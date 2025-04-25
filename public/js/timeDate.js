function updateClockAndDate() {
    const clockElement = document.getElementById('clock');
    const dateElement = document.getElementById('date');

    const now = new Date();

    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
    const day = String(now.getDate()).padStart(2, '0');


    // Format time as 00:00:00 AM/PM
    let hours = now.getHours();
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const amPm = hours >= 12 ? 'PM' : 'AM';

    // Convert to 12-hour format
    hours = hours % 12 || 12;
    
    // Update visible clock
    if (clockElement) {
        clockElement.textContent = `${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${amPm}`;
    }

    // Update visible date
    if (dateElement) {
        // Format date as Month Day, Year
        const options = { month: 'long', day: 'numeric', year: 'numeric' };
        const formattedDate = now.toLocaleDateString(undefined, options);
        dateElement.textContent = formattedDate;
    }
}

// Update clock and date every second
setInterval(updateClockAndDate, 1000);

// Initialize the clock and date on page load
updateClockAndDate();