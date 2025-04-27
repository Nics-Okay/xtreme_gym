@if(session('success') || session('error') || $errors->any())
    <script>
        window.onload = function() {
            let messages = [];
            let isSuccess = false;

            if ("{{ session('success') }}") {
                messages.push({
                    type: 'success',
                    message: "{{ session('success') }}"
                });
                isSuccess = true;
            } else if ("{{ session('error') }}") {
                messages.push({
                    type: 'error',
                    message: "{{ session('error') }}"
                });
                isSuccess = false;
            }

            @foreach ($errors->all() as $error)
                messages.push({
                    type: 'error',
                    message: "{!! addslashes($error) !!}"
                });
            @endforeach

            let previousBottom = 30;

            messages.forEach(function(messageData) {
                // Create alert box
                let alertBox = document.createElement('div');
                alertBox.style.position = 'fixed';
                alertBox.style.bottom = previousBottom + 'px'; // Position alert based on previous position
                alertBox.style.right = '-350px'; // Start off-screen
                alertBox.style.width = '350px';
                alertBox.style.padding = '15px';
                alertBox.style.zIndex = '10000';
                alertBox.style.borderLeft = messageData.type === 'success' ? '3px solid green' : '3px solid red';
                alertBox.style.backgroundColor = 'white';
                alertBox.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';
                alertBox.style.borderRadius = '8px';
                alertBox.style.display = 'flex';
                alertBox.style.alignItems = 'center';
                alertBox.style.transition = 'right 0.5s ease-out, opacity 0.5s ease-in-out';
                alertBox.style.gap = '10px'; // Space between icon and text

                // Create icon container
                let iconDiv = document.createElement('div');
                iconDiv.style.display = 'flex';
                iconDiv.style.alignItems = 'center';
                iconDiv.style.justifyContent = 'center';
                iconDiv.style.width = '40px';
                iconDiv.style.height = '40px';
                iconDiv.style.borderRadius = '50%';
                iconDiv.style.backgroundColor = messageData.type === 'success' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)';

                // Icon
                let icon = document.createElement('span');
                icon.textContent = messageData.type === 'success' ? '✔' : '✖'; // Check for success, Cross for error
                icon.style.color = messageData.type === 'success' ? 'green' : 'red';
                icon.style.fontSize = '20px';

                iconDiv.appendChild(icon);

                // Create text container
                let textDiv = document.createElement('div');
                textDiv.style.display = 'flex';
                textDiv.style.flexDirection = 'column';

                // Title
                let title = document.createElement('span');
                title.textContent = messageData.type === 'success' ? 'Success' : 'Error';
                title.style.color = 'black';
                title.style.fontWeight = 'bold';
                title.style.fontSize = '16px';

                // Message
                let messageText = document.createElement('span');
                messageText.textContent = messageData.message;
                messageText.style.color = 'rgba(0, 0, 0, 0.7)';
                messageText.style.fontSize = '14px';

                textDiv.appendChild(title);
                textDiv.appendChild(messageText);

                // Assemble alert box
                alertBox.appendChild(iconDiv);
                alertBox.appendChild(textDiv);

                document.body.appendChild(alertBox);

                // Slide in animation
                setTimeout(() => {
                    alertBox.style.right = '20px';
                }, 100);

                previousBottom += 100; // Increase the bottom position by a fixed amount (adjust as needed)

                // Auto remove after 5 seconds
                setTimeout(() => {
                    alertBox.style.opacity = '0';
                    setTimeout(() => alertBox.remove(), 500);
                }, 5000);
            });
        };
    </script>
@endif