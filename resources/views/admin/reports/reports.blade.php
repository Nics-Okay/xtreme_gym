@extends('layouts.AdminLayout')

@section('title', 'Reports - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reports.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>REVENUE REPORTS</h2> 
        </div>
        <div class="table-container">
            <div class="section-content">
                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">TOTAL REVENUE</div>
                            <div class="menu-info">₱ {{ number_format($totalRevenue, 0, '.', ',') }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        </div>
                    </a>
                </div>

                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">MEMBERSHIP REVENUE</div>
                            <div class="menu-info">₱ {{ number_format($membershipRevenue, 0, '.', ',') }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        </div>
                    </a>
                </div>

                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">GUEST REVENUE</div>
                            <div class="menu-info">₱ {{ number_format($guestRevenue, 0, '.', ',') }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="section-content">
                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">RESERVATIONS REVENUE</div>
                            <div class="menu-info">₱ {{ number_format($reservationsRevenue, 0, '.', ',') }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        </div>
                    </a>
                </div>

                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">STUDENTS REVENUE</div>
                            <div class="menu-info">₱ {{ number_format($studentsRevenue, 0, '.', ',') }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        </div>
                    </a>
                </div>

                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">APPRENTICES REVENUE</div>
                            <div class="menu-info">₱ {{ number_format($apprenticesRevenue, 0, '.', ',') }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection