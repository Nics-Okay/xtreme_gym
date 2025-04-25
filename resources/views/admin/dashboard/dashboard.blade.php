@extends('layouts.AdminLayout')

@section('title', 'Dashboard')

@section('header-title', 'Dashboard')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>DASHBOARD</h2>
            <div class="notification" onclick="toggleNotificationContainer()">
                <i class="fa-solid fa-bell"></i>
                @if($notification_count > 0)
                    <span class="notification-count" id="notificationCount" data-count="{{ $notification_count }}">{{ $notification_count }}</span>
                @endif
            </div>
        </div>
        <div class="page-content">
            <div class="dashboard">
                @include('admin.dashboard.notifications')

                @include('admin.dashboard.membersLog')

                @include('admin.dashboard.guestLog')

                @include('admin.dashboard.revenueChart')

                @include('admin.dashboard.reservations')

                <div class="overview three">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">TOTAL MEMBERS</div>
                            <div class="menu-info">{{ $totalMembers }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><ion-icon name="people"></ion-icon></div>
                        </div>
                    </a>
                </div>
                <div class="overview four">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">ACTIVE SUBSCRIPTIONS</div>
                            <div class="menu-info">{{ $activeMembers }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><ion-icon name="accessibility"></ion-icon></div>
                        </div>
                    </a>
                </div>
                <div class="overview five">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">ATTENDEES</div>
                            <div class="menu-info">{{ $attendees ?? '0'}}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><ion-icon name="footsteps"></ion-icon></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection