<!DOCTYPE html>
<html>
<head>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <style>
        .reservation-day {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .reservation-day h3 {
            font-size: 1rem;
            margin: 0;
        }
        .reservation-day .count {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .reservation-day .btn-view-details {
            display: inline-block;
            padding: 5px 10px;
            margin-top: 5px;
            font-size: 0.9rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .reservation-day .btn-view-details:hover {
            background-color: #0056b3;
        }
        #reservationModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            z-index: 1000;
            width: 400px;
        }
        #reservationModal h2 {
            margin-top: 0;
        }
        #reservationModal .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #333;
            cursor: pointer;
        }
        #reservationModal .close-btn:hover {
            color: #ff0000;
        }
        #modalOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>

    <div id="calendar"></div>

    <!-- Modal -->
    <div id="modalOverlay"></div>
    <div id="reservationModal">
        <button class="close-btn" onclick="closeModal()"><i class="fas fa-times"></i></button>
        <h2>Reservation Details</h2>
        <p>Details about the reservations will go here.</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Month view as the initial view
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                events: [
                    {
                        title: 'Reservations',
                        start: '2025-04-15',
                        extendedProps: {
                            count: 14,
                        },
                    }
                ],
                eventContent: function (arg) {
                    if (arg.event.title === 'Reservations') {
                        const count = arg.event.extendedProps.count || 0;

                        return {
                            html: `
                                <div class="reservation-day">
                                    <h3>${arg.event.title}</h3>
                                    <div class="count">${count}</div>
                                    <a class="btn-view-details" onclick="openModal()">View Details</a>
                                </div>
                            `
                        };
                    }
                }
            });

            calendar.render();
        });

        function openModal() {
            document.getElementById('reservationModal').style.display = 'block';
            document.getElementById('modalOverlay').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('reservationModal').style.display = 'none';
            document.getElementById('modalOverlay').style.display = 'none';
        }
    </script>

</body>
</html>
