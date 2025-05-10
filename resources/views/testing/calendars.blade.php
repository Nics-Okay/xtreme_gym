<!DOCTYPE html>
<html>
<head>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
</head>
<body>

    <style>
        .fc-list-event-time {
            font-family: Arial, sans-serif; /* Change to system font (Arial) */
            font-size: 14px;  /* Adjust font size */
            color: #333;  /* Adjust color */
        }
        
        .fc-event-title,
        .fc-event-time {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px; /* Adjust the font size if needed */
        }

        .fc-event-description {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 14px; /* Description font size */
        }

        .fc-event-name {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 15px; /* Name font size */
            font-style: italic; /* Optional: Italicize the name */
        }
    </style>

    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'listDay', // List view for a single day
                initialDate: '2025-04-30', // Replace with the date you want to display
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                events: [
                    {
                        id: '1',
                        title: 'Morning Meeting',
                        name: 'Team Sync-up',
                        description: 'Discussion on project updates and tasks for the day.',
                        start: '2025-04-30T09:00:00',
                        end: '2025-04-30T10:00:00'
                    },
                    {
                        id: '2',
                        title: 'Project Deadline',
                        name: 'Final Submission',
                        description: 'Submit the final report for the project.',
                        start: '2025-04-30T14:00:00'
                    }
                ],

                eventContent: function (arg) {
                    let eventDetails = document.createElement('div');
                    eventDetails.innerHTML = `
                        <div class="fc-event-title"><b>${arg.event.title}</b></div>
                        <div class="fc-event-name"><i>${arg.event.extendedProps.name}</i></div>
                        <div class="fc-event-description">${arg.event.extendedProps.description}</div>
                    `;
                    return { domNodes: [eventDetails] };
                }
            });

            calendar.render();
        });
    </script>
</body>
</html>
