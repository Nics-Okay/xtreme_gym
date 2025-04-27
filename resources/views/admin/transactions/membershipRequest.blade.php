@extends('layouts.AdminLayout')

@section('title', 'Member Request - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>MEMBERSHIP PAYMENTS</h2> 
        </div>
        <div class="table-container">
            <table class="table-content">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Class Enrolled</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                            <td>{{ $transaction->user_id }}</td>
                            <td>{{ $transaction->name }}</td>
                            <td>{{ $transaction->rate->name ?? 'Rate not found' }}</td>
                            <td>{{ $transaction->rate->price ?? 'Rate not found' }}</td>
                            <td>{{ $transaction->payment_method }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('F j, Y g:i A') }}</td>
                            <td>{{ $transaction->transaction_type == 'membership_renew' ? 'Renewal' : 'New Membership' }}</td>
                            <td>
                                <div class="action-button">
                                    @if(strtolower($transaction->status) === 'pending')
                                        <form method="post" action="{{ route('transactions.membershipRequestApprove', $transaction) }}">
                                            @csrf
                                            @method('put')
                                            <button class="btn-approve">Approve</button>
                                        </form>
                                        <form method="post" action="{{ route('transactions.membershipRequestCancel', $transaction) }}">
                                            @csrf
                                            @method('put')
                                            <button class="btn-cancel">Cancel</button>
                                        </form>
                                    @else
                                        <p>All Done!</p>
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