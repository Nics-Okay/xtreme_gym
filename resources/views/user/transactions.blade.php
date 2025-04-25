@extends('layouts.UserLayout')

@section('title', 'Transactions - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/user/user.css') }}">
@endsection

@section('main-content')
    <div class="user-content-container">
        <div class="user-content-header">
            <h3>Transactions</h3> 
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