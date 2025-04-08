@extends('layouts.AdminLayout')

@section('title', 'Dashboard')

@section('header-title', 'Dashboard')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endsection

@section('main-content')
    <div class="dashboard">
        <div class="logs member">
            Member Time-in
        </div>
        <div class="logs guest">
            Guest Time-in
        </div>
        <div class="calendar reservations">
            Reservations Calendar
        </div>
        <div class="overview one">
            Report 1
        </div>
        <div class="overview two">
            Report 2
        </div>
        <div class="overview three">
            Report 3
        </div>
        <div class="overview four">
            Report 4
        </div>
        <div class="overview five">
            Report 5
        </div>
    </div>
@endsection