@extends('layouts.AdminLayout')

@section('title', 'Notifications')

@section('head-access')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/notifications.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/modal.css') }}">
@endsection

@section('main-content')
    <style>
        .page-content {
            overflow-y: auto;
        }
    </style>
    <div class="content">
        <div class="page-header">
            <h2>Notifications</h2>
        </div>
        <div class="page-content">
            @foreach($notifications as $notification)
                <div class="notification-item">
                    <div class="list-item {{ $notification->is_read ? 'read' : 'unread' }}" onclick="showNotificationModal({{ $notification->id }})">
                        <p id="title">{{ $notification->title }}<span style="margin: 0 0.5rem;">&bull;</span>
                        <span style="font-weight: normal">{{ \Carbon\Carbon::parse($notification->submitted_at)->format('F j, Y g:i A') }}  </span></p>
                        <p id="context">{{ $notification->message }}</p>
                    </div>
                    <div class="action-buttons notifications">
                        <form method="post" action="{{route('notification.destroy', ['notification' => $notification])}}">
                            @csrf 
                            @method('delete')
                            <button type="submit" class="delete-button">
                                <i class="fa-solid fa-trash"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
                <div id="confirmationModal" class="modal-overlay" aria-hidden="true">
                    <div class="modal-box">
                        <i class="fa-solid fa-xmark" onclick="closeNotificationModal()"></i>
                        <h3>{{ $notification->title }}</h3>
                        <div class="notification-content">
                            <div class="content-value"><h4>Date: </h4><p>{{ \Carbon\Carbon::parse($notification->submitted_at)->format('F j, Y g:i A') }}</p></div>
                            <div class="content-value"><h4>User ID: </h4><p>{{ $notification->user_id }}</p></div>
                            <div class="content-value"><h4>Name: </h4><p>{{ $notification->user_name }}</p></div>
                            <div class="content-value"><h4>Email: </h4><p>{{ $notification->user_email }}</p></div>
                            <div class="content-value"><h4>Contact Number: </h4><p>{{ $notification->user_contact ?? 'Not provided'}}</p></div>
                            <div class="content-value"><h4>Payment Method: </h4><p>{{ $notification->payment_method ?? 'Unavailable'}}</p></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function showNotificationModal(notificationId) {
            // Show the modal
            const modal = document.getElementById('confirmationModal');
            if (modal) {
                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden', 'false');
            }

            // Send AJAX request to mark notification as read
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ id: notificationId })
            })
            .then(response => {
                if (response.ok) {
                    // Optionally update the UI (e.g., change the background to "read" style)
                    document.querySelector(`[onclick="showModal(${notificationId})"]`).classList.remove('unread');
                    document.querySelector(`[onclick="showModal(${notificationId})"]`).classList.add('read');
                } else {
                    console.error('Failed to mark notification as read');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function closeNotificationModal() {
            const modal = document.getElementById('confirmationModal');
            if (modal) {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
            }
        }
    </script>
@endsection