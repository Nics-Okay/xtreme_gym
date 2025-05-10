@extends('layouts.UserDesign')

@section('title', 'Settings - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
@endsection

@section('main-content')
    <style>
        .main-section {
            height: 100%;
            width: 100%;
            padding: 0 10px 10px;
        }

        .settings-container {
            height: fit-content;
            width: 100%;
            background-color: white;
        }

        .settings-container li {
            width: 100%;
        }

        .settings-container li a {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 15px 0;
            color: black;
            font-size: medium;
            text-decoration: none;
        }

        .icon-box {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 5%;
        }

        .icon-box i {
            font-size: large;
        }

        .settings-container li:hover {
            background-color: rgb(152, 176, 214);
        }

        @media (max-width: 639px) {
            .icon-box {
                width: 15%;
            }
        }
    </style>
    <div class="user-content-container">
        <div class="user-content-header">
            <h3>Settings</h3> 
        </div>
        <div class="user-main-content">
            <div class="main-section">
                <div class="settings-container">
                    <ul>
                        <li><a href="{{ route('profileUser.show') }}" class="menu-name">
                                <div class="icon-box">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <p>Profile Settings</p>
                            </a>
                        </li>
                        <li><a href="{{ route('user.equipments') }}" class="menu-name">
                                <div class="icon-box">
                                    <i class="fa-solid fa-dumbbell"></i>    
                                </div>
                                <p>Gym Equipments</p>
                            </a>
                        </li>
                        <li><a href="{{ route('user.transactions') }}" class="menu-name">
                                <div class="icon-box">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                <p>Transactions History</p>
                            </a>
                        </li>
                        <li><a href="{{ route('review.create') }}" class="menu-name">
                                <div class="icon-box">
                                    <i class="fa-solid fa-thumbs-up"></i>
                                </div>
                                <p>Leave a Review</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection