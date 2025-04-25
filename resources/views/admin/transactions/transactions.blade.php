@extends('layouts.AdminLayout')

@section('title', 'Transactions')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>TRANSACTIONS HISTORY</h2>
            <div class="filter-bar">
                <form method="GET" action="{{ route('transaction.show') }}" id="filterForm">
                    <div class="search-container">
                        <input 
                            type="text" 
                            id="searchInput"
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search transactions..."
                            />
                        <button type="submit" id="searchIcon">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <select name="status" id="statusFilter" onchange="applyFilter()">
                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </form>
            </div>
            <div class="page-button">
                <a href="#"><ion-icon name="add-outline"></ion-icon>Add New Transaction</a>
            </div>
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
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Amount</th>
                    <th>Transaction Type</th>
                    <th>Payment Date</th>
                    <th>Action</th>
                </tr>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                    <td>{{ $transaction->name }}</td>
                    <td>{{ $transaction->name }}</td>
                    <td>{{ $transaction->name }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->remarks }}</td>
                    <td>{{ $transaction->updated_at->format('F j, Y g:i A') }}</td>
                    <td>
                        <div class="action-button">
                            <a href="{{route('transaction.edit', ['transaction' => $transaction])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form method="post" action="{{route('transaction.destroy', ['transaction' => $transaction])}}">
                                @csrf 
                                @method('delete')
                                <button type="submit" class="delete-button" style="background: none; border: none; cursor: pointer;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="pagination-links">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
    <script>
    function applyFilter() {
        document.getElementById('filterForm').submit();
    }
    </script>
@endsection