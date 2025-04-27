@extends('layouts.UserDesign')

@section('title', 'Profile - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <!-- Design -->
    <style>
        .main-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            row-gap: 15px;
            height: 100%;
            width: 100%;
            padding: 0 10px 10px;
        }
    </style>

    <!-- Structure -->
    <div class="user-content-container">
        <div class="user-content-header">
            <div class="custom-header">
                <a href="{{ route('user.settings')}}"><i class="fa-solid fa-arrow-left"></i></a>
                <h3>Profile Management</h3> 
            </div>
        </div>
        <div class="user-main-content">
            <div class="main-section">
                <div class="profile-section-one">
                    <div class="image-holder">
                        <img 
                            id="profile-image-preview"
                            src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/profile-placeholder.png') }}" 
                            alt="Profile Image">
                    </div>
                    <h3>{{ $user->first_name ?? ' '}} {{ $user->last_name ?? ' '}}</h3>
                    <p style="font-size: small;">ID: {{ $user->unique_id}}</p>
                    <a href="" class="edit-profile">Update Profile</a>
                </div>
                <div class="profile-section-two">
                    <a href=""><i class="fa-solid fa-lock"></i> Change Password</a>
                </div>
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