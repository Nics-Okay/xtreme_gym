document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        eventDisplay: 'block', // Makes events appear as solid blocks
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        events: {
            url: document.querySelector('meta[name="calendar-events-route"]')?.content || "/calendar/events",
            method: 'GET',
            failure: function () {
                alert('Error fetching calendar events!');
            }
        },
        editable: true,
        selectable: true,
        eventClick: function (info) {
            alert('Reservation Details: ' + info.event.title + "\n" + (info.event.extendedProps.description || ''));
            // You could open a modal or redirect to a reservation details page
        },
        dateClick: function (info) {
            // Handle date clicks (for creating new reservations)
            alert('Clicked on: ' + info.dateStr);
        },
    });

    calendar.render();
});