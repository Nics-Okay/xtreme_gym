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
                <div class="report-box">
                    <p>MEMBERSHIP REVENUE</p>
                    <h2>₱ {{ $membershipRevenue }}</h2>
                </div>
                <div class="report-box">
                    <p>GUEST REVENUE</p>
                    <h2>₱ {{ $guestRevenue }}</h2>
                </div>
                <div class="report-box">

                </div>
            </div>
        </div>
    </div>
@endsection