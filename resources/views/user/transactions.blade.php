@extends('layouts.UserDesign')

@section('title', 'Transactions - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/transactions.css') }}">

@endsection

@section('main-content')
    <!-- Design -->
    <style>
        .main-section {
            height: 100%;
            width: 100%;
            padding: 0 10px 10px;
        }
    </style>

    <div class="user-content-container">
        <div class="user-content-header">
            <div class="custom-header">
                <a href="{{ route('user.settings')}}"><i class="fa-solid fa-arrow-left"></i></a>
                <h3>Transactions</h3> 
            </div>
        </div>
        <div class="user-main-content">
            <div class="main-section">
                <div class="transactions-container">
                    <ul>
                        @foreach($transactions as $transaction)
                            <li>
                                <div class="transactions-info-one">
                                    <p class="transactions-title">{{ $transaction->remarks }}</p>
                                    <p>{{ $transaction->rate->description ?? 'Not set' }}</p>
                                    <p class="transactions-id">Transaction ID: {{ $transaction->id }}</p>
                                    <p>Payment Method: {{ $transaction->payment_method }}</p>
                                </div>

                                <div class="transactions-info-two">
                                    <p class="transactions-amount">₱ {{ $transaction->amount }}.00</p>
                                    <p class="transactions-status">{{ $transaction->status }}</p>
                                    <p class="transactions-date">{{ \Carbon\Carbon::parse($transaction->created_at)->format('F j, Y') }}</p>
                                    <p class="transactions-date">{{ \Carbon\Carbon::parse($transaction->created_at)->format('g:i A') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection