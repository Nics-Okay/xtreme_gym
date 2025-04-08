@extends('layouts.AdminLayout')

@section('title', 'Rates')

@section('header-title', 'Membership Payments')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="section-style">
        <div class="table-main">
            <div class="member-table-header">
                <h3 class="table-header-info">Membership Payments Request</h3>
            </div>
            <div class="table-container">
                <div>
                    @if(session()->has('success'))
                        <div>
                            {{session('success')}}
                        </div>
                    @endif
                </div>
                <table class="table-content">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Membership Plan</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Valid Until</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td id="center-align">{{ $transaction->user_id }}</td>
                                <td>{{ $transaction->name }}</td>
                                <td id="center-align">{{ $transaction->rate->name ?? 'Rate not found' }}</td>
                                <td id="center-align">{{ $transaction->rate->price ?? 'Rate not found' }}</td>
                                <td id="center-align">{{ $transaction->payment_method }}</td>
                                <td id="center-align">{{ $transaction->created_at }}</td>
                                <td id="center-align"></td>
                                <td class="action-button">
                                    @if($transaction->status === 'pending')
                                        <form method="POST" action="#">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn-approve">Approve</button>
                                        </form>
                                        <form method="POST" action="#">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn-cancel">Cancel</button>
                                        </form>
                                    @else
                                        <span>N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection