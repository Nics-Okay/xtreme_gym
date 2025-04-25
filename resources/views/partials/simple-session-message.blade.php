@if(session('success') || session('error'))
    <script>
        window.onload = function() {
            let message = "{{ session('success') ?? session('error') }}";
            let isSuccess = "{{ session('success') ? true : false }}";

            // Create alert box
            let alertBox = document.createElement('div');
            alertBox.style.position = 'fixed';
            alertBox.style.bottom = '30px';
            alertBox.style.right = '-350px'; // Start off-screen
            alertBox.style.width = '350px';
            alertBox.style.padding = '15px';
            alertBox.style.borderLeft = isSuccess ? '3px solid green' : '3px solid red';
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
            iconDiv.style.backgroundColor = isSuccess ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)';

            // Icon
            let icon = document.createElement('span');
            icon.textContent = isSuccess ? '✔' : '✖'; // Check for success, Cross for error
            icon.style.color = isSuccess ? 'green' : 'red';
            icon.style.fontSize = '20px';

            iconDiv.appendChild(icon);

            // Create text container
            let textDiv = document.createElement('div');
            textDiv.style.display = 'flex';
            textDiv.style.flexDirection = 'column';

            // Title
            let title = document.createElement('span');
            title.textContent = isSuccess ? 'Success' : 'Error';
            title.style.color = 'black';
            title.style.fontWeight = 'bold';
            title.style.fontSize = '16px';

            // Message
            let messageText = document.createElement('span');
            messageText.textContent = message;
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

            // Auto remove after 3 seconds
            setTimeout(() => {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500);
            }, 5000);
        };
    </script>
@endif