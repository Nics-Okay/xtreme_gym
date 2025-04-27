<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewport Height Fix</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <style>
        body, html {
            margin: 0;
            padding: 0;
        }

        .container {
            /* Dynamically set height using the calculated --vh variable */
            height: calc(var(--vh, 1vh) * 100);
            width: 100%;
            background-color: lightblue;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: orchid;
        }

        .content {
            width: 90%;
            height: 90%; /* Ensure content stays within view */
            overflow-y: auto; /* Enable scrolling if content exceeds available space */
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            background-color: greenyellow;
        }
    </style>
    <div class="container">
        <div class="content">
            <p>Resize the browser or test on a mobile device to see this work!</p>
        </div>
    </div>

    <script src="{{ asset('js/mobile-sizing.js') }}"></script>
    
</body>
</html>
