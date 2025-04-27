@extends('layouts.UserDesign')

@section('title', 'Module - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
@endsection

@section('main-content')
    <!-- Design -->
    <style>
        .main-section {
            height: 100%;
            width: 100%;
            padding: 0 10px 10px;
            background-color: seagreen;
        }
    </style>

    <!-- Structure -->
    <div class="user-content-container">
        <div class="user-content-header">
            <div class="custom-header">
                <a href="{{ route('user.home')}}"><i class="fa-solid fa-arrow-left"></i></a>
                <h3>Module Title</h3> 
            </div>

            <!--
            <h3>My Reservations</h3>

            <div class="user-content-button">
                <a href="#" id="openModalButton"><i class="fa-solid fa-plus"></i><span>New</span></a>
            </div>

            <div class="user-content-button-history">
                <a href="#" id="openHistoryModalButton"><i class="fa-solid fa-clock-rotate-left"></i></a>
            </div>
            -->
        </div>
        <div class="user-main-content">
            <div class="main-section">
            </div>
        </div>
    </div>

    <!-- Structure -->
    <script>
    </script>
@endsection

@section('js-container')
    <!-- Backup Js -->
@endsection