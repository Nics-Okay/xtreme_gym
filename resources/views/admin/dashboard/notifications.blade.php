<style>
    .notification {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        padding-right: 10px;
        cursor: pointer;
    }

    .notification i {
        font-size: 22px;
        color: #328bcf;
    }

    .notification-count {
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0;
        right: 0;
        height: 20px;
        width: 20px;
        color: white;
        font-size: 12px;
        font-weight: bold;
        border-radius: 50%;
        background-color: red;
    }

    /* Dynamic sizing for larger notification numbers */
    .notification-count.large {
        font-size: 14px;
        width: 24px;
        height: 24px;
    }

    /* Notification container (hidden by default) */
    .notification-container {
        position: absolute;
        display: none;
        top: -5px;
        right: 0;
        width: 300px;
        max-height: 70%;
        padding: 10px;
        z-index: 1000;
        opacity: 0;
        border: 1px solid rgba(3, 159, 180, 0.5);
        box-shadow: 0 4px 8px rgba(3, 159, 180, 0.2);
        overflow-y: auto;
        background-color: white;
        transition: opacity 0.3s ease; /* Smooth transition */
    }

    .notification-container.show {
        display: block;
        opacity: 1;
    }

    .notification-container h3 {
        margin: 0 0 10px;
        font-size: medium;
    }

    .notification-container ul {
        list-style-type: none;
        padding: 0;
    }

    .notification-container ul li {
        padding: 5px 10px 10px;
        border-bottom: 1px solid rgb(190, 190, 190);
        background-color:rgb(227, 243, 255);
        transition: background-color 0.3s ease;
    }

    .notification-container ul li:hover {
        background-color:rgb(190, 227, 255);
    }

    .notification-item {
        color: black;
        font-size: small;
        text-decoration: none;
    }

    .notification-item p {
        color:rgb(48, 48, 48);
    }
</style>

<div class="notification-container" id="notificationContainer">
    <h3>Notifications</h3>
    <ul id="notificationList">
        @if($notifications->isEmpty())
            <li>No new notifications.</li>
        @else
            @foreach($notifications as $notification)
                <a href="{{ route('notification.read', ['notification' => $notification])}}" class="notification-item">
                    <li>
                        <h4>{{ $notification->title }}</h4>
                        <p>{{ $notification->message }}</p>
                    </li>
                </a>
            @endforeach
        @endif
    </ul>
</div>

<audio id="notificationSound" src="{{ asset('sound/notification-sound.wav') }}" preload="auto"></audio>
                    
<script>
    function toggleNotificationContainer() {
        const container = document.getElementById("notificationContainer");

        if (container) {
            if (container.style.display === "none" || container.style.display === "") {
                container.style.display = "block";
                setTimeout(() => {
                    container.style.opacity = 1;
                }, 10);

                // Add event listener to detect clicks outside the container
                document.addEventListener("click", closeOnClickOutside);
            } else {
                closeNotification(container);
            }
        } else {
            console.error("Notification container not found!");
        }
    }

    function closeNotification(container) {
        container.style.opacity = 0;
        setTimeout(() => {
            container.style.display = "none";
        }, 300); // Wait for opacity transition

        // Remove the event listener when the container is closed
        document.removeEventListener("click", closeOnClickOutside);
    }

    function closeOnClickOutside(event) {
        const container = document.getElementById("notificationContainer");
        const notificationIcon = document.querySelector(".notification");

        if (
            container &&
            notificationIcon &&
            !container.contains(event.target) &&
            !notificationIcon.contains(event.target)
        ) {
            closeNotification(container);
        }
    }

    // Track notification count
    const notificationCountElement = document.getElementById('notificationCount');
    let currentCount = parseInt(notificationCountElement.getAttribute('data-count'));

    // Function to play sound
    function playNotificationSound() {
        const sound = document.getElementById('notificationSound');
        sound.play();
    }

    // Periodically check for new notifications
    setInterval(function() {
        fetch('/get-new-notifications-count')
            .then(response => response.json())
            .then(data => {
                console.log('New notification count:', data.new_notifications);
                const newCount = data.new_notifications;
                if (newCount > currentCount) {
                    const newNotifications = newCount - currentCount;

                    // Play sound for each new notification
                    for (let i = 0; i < newNotifications; i++) {
                        playNotificationSound();
                    }
                }
                currentCount = newCount;
                const notificationCountElement = document.getElementById('notificationCount');
                notificationCountElement.innerText = `${currentCount}`;
                notificationCountElement.setAttribute('data-count', currentCount);
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }, 5000);  // Check every 5 seconds
</script>