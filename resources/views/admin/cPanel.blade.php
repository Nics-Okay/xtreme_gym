<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    
<body class="body-bg">
    <div class="container">
        <h4 class="title">Welcome to control panel!</h4>
            
        <form method="POST" action="{{ route('admin.update-lock-code') }}">
            @csrf
            <input type="password" name="current_pin" placeholder="Current PIN" nullable>
            <input type="password" name="new_pin" placeholder="New PIN" required>
            <input type="password" name="new_pin_confirmation" placeholder="Confirm New PIN" required>
            <button type="submit">Update Lock Code</button>
        </form>
        @if ($errors->any())
            <div class="errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif
    </div>
</body>
</html>