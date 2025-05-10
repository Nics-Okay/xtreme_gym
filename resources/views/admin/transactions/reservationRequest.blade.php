@extends('layouts.AdminLayout')

@section('title', 'Reservation Request - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>RESERVATION PAYMENTS</h2> 
        </div>
        <div class="table-container">
            <table class="table-content">
                <thead>
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Date</th>
                        <th rowspan="2">ID</th>
                        <th rowspan="2">Name</th>
                        <th rowspan="2">Facility</th>
                        <th colspan="3">Payment</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('F j, Y g:i A') }}</td>
                            <td>{{ $transaction->user_id ?? 'Guest'}}</td>
                            <td>{{ $transaction->name }}</td>
                            <td>{{ $transaction->reservation_type }}</td>
                            <td>{{ $transaction->amount ?? 'Not Available' }}</td>
                            <td>{{ $transaction->payment_method }}</td>
                            <td>{{ $transaction->payment_status }}</td>
                            <td>
                                <div class="action-button">
                                    @if(is_null($transaction->status) || strtolower($transaction->status) === 'pending')
                                        <form method="post" action="{{ route('transactions.reservationRequestApprove', $transaction) }}">
                                            @csrf
                                            @method('put')
                                            <button class="btn-approve">Approve</button>
                                        </form>
                                        <form method="post" action="{{ route('transactions.reservationRequestCancel', $transaction) }}">
                                            @csrf
                                            @method('put')
                                            <button class="btn-cancel">Cancel</button>
                                        </form>
                                    @else
                                        <span>No Action Required</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-links">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection