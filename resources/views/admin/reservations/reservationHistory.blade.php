@extends('layouts.AdminLayout')

@section('title', 'Reservations History - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>RESERVATIONS HISTORY</h2>
            <div class="filter-bar">
                <form method="GET" action="{{ route('reservation.history') }}" id="filterForm">
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
                </form>
            </div>
            <div class="page-button">
                <a href="{{ route('reservation.create') }}"><ion-icon name="add-outline"></ion-icon>Create New Reservation</a>
            </div>
        </div>
        <div class="table-container">
            <table class="table-content">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Date</th>
                    <th>Time Duration</th>
                    <th>No. of People</th>
                    <th>Facility</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
                @foreach($pastReservations as $pastReservation)
                <tr>
                    <td>{{ ($pastReservations->currentPage() - 1) * $pastReservations->perPage() + $loop->iteration }}</td>
                    <td>{{ $pastReservation->name }}</td>
                    <td>{{ $pastReservation->number }}</td>
                    <td>{{ \Carbon\Carbon::parse($pastReservation->reservation_date)->format('F j, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($pastReservation->start_time)->format('g:i A') . ' - ' . \Carbon\Carbon::parse($pastReservation->end_time)->format('g:i A') }}</td>
                    <td>{{ $pastReservation->number_of_people }}</td>
                    <td>{{ $pastReservation->reservation_type }}</td>
                    <td>{{ $pastReservation->amount }}</td>
                    <td>{{ $pastReservation->payment_status }}</td>
                    <td>
                        <div class="action-button">
                            <a href="{{route('reservation.edit', ['reservation' => $pastReservation])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form method="post" action="{{route('reservation.cancel', ['reservation' => $pastReservation])}}">
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
                {{ $pastReservations->links() }}
            </div>
        </div>
    </div>
    <script>
    function applyFilter() {
        document.getElementById('filterForm').submit();
    }
    </script>
@endsection