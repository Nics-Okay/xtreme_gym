@extends('layouts.AdminLayout')

@section('title', 'Gym Logs')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/attendees.css') }}">
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
                <a href="javascript:void(0);" id="openModalBtn">
                    <ion-icon name="add-outline"></ion-icon>Add New Attendee
                </a>
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
                                <td>{{ \Carbon\Carbon::parse($attendee->membership_validity)->format('F j, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendee->time_in)->format('F j, Y g:i A') }}</td>
                                <td>
                                    @if ($attendee->time_out)
                                        {{ \Carbon\Carbon::parse($attendee->time_out)->format('F j, Y g:i A') }}
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

    <!-- Modal -->
    <div id="addAttendeeModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" id="closeModalBtn">&times;</button>
            <h3>Choose Attendee Type</h3>
            <div class="option-container">
                <a href="{{ route('attendee.addMemberAttendee') }}" class="option-box">
                    <i class="fa-solid fa-user"></i>
                    <p>Member</p>
                </a>
                <a href="{{ route('attendee.addGuestAttendee') }}" class="option-box">
                    <i class="fa-solid fa-user-clock"></i>
                    <p>Guest</p>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        document.addEventListener('DOMContentLoaded', () => {
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const modal = document.getElementById('addAttendeeModal');

            openModalBtn.addEventListener('click', () => {
                modal.classList.add('active');
            });

            closeModalBtn.addEventListener('click', () => {
                modal.classList.remove('active');
            });

            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });
    </script>
@endsection