@extends('layouts.AdminLayout')

@section('title', 'Gym Logs')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>ATTENDEE MONITORING</h2>
            <div class="filter-bar">
                <form method="GET" action="{{ route('attendee.show') }}" id="filterForm">
                    <div class="search-container">
                        <input 
                            type="text" 
                            id="searchInput"
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search members..."
                            />
                        <button type="submit" id="searchIcon">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="page-button">
                <a href="#"><ion-icon name="add-outline"></ion-icon>Add New Attendee</a>
            </div>
        </div>
        <div class="page-content">
            <div class="table-container">
                <table class="table-content">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Plan Availed</th>
                            <th>Membership Status</th>
                            <th>Membership Validity</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendees as $attendee)
                            <tr>
                                <td>{{ ($attendees->currentPage() - 1) * $attendees->perPage() + $loop->iteration }}</td>
                                <td>{{ $attendee->name }}</td>
                                <td>{{ $attendee->membership_type }}</td>
                                <td>{{ $attendee->membership_status }}</td>
                                <td>{{ $attendee->membership_validity }}</td>
                                <td>{{ $attendee->time_in }}</td>
                                <td>
                                    @if ($attendee->time_out)
                                        {{ $attendee->time_out }}
                                    @elseif (\Carbon\Carbon::parse($attendee->time_in)->isBefore(\Carbon\Carbon::today()))
                                        Did not time-out
                                    @else
                                        No time-out recorded yet.
                                    @endif
                                </td>
                                <td>
                                    <div class="action-button">
                                        <form method="post" action="{{route('attendee.destroy', ['attendee' => $attendee])}}">
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
                    </tbody>
                </table>
                <div class="pagination-links">
                    {{ $attendees->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection