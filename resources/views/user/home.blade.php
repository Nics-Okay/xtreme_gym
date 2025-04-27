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
                <h3 class="custom-header-title">Module Title</h3> 
            </div>
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