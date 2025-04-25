@extends('layouts.AdminLayout')

@section('title', 'Members Management')

@section('header-title', 'Members List')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/members.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>XTREME MEMBERS</h2>
            <div class="filter-bar">
                <form method="GET" action="{{ route('member.show') }}" id="filterForm">
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
                <a href="{{ route('member.create') }}"><ion-icon name="add-outline"></ion-icon>Add New Member</a>
            </div>
        </div>
        <div class="page-content">
            <div class="table-container">
                <table class="table-content">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Photo</th>
                            <th rowspan="2">ID</th>
                            <th rowspan="2">Name</th>
                            <th rowspan="2">Email</th>
                            <th rowspan="2">Phone</th>
                            <th colspan="3">Membership</th>
                            <th rowspan="2">Visits</th>
                            <th rowspan="2">Address</th>
                            <th rowspan="2">Actions</th>
                        </tr>
                        <tr>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Validity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td>{{ ($members->currentPage() - 1) * $members->perPage() + $loop->iteration }}</td>
                                <td class="image-data">
                                    <div class="image-holder">
                                        <img src="{{ $member->image ?? asset('images/profile-placeholder.png') }}" alt="Member Image">
                                    </div>
                                </td>
                                <td>{{ $member->unique_id }}</td>
                                <td>{{ $member->first_name }} {{ $member->last_name ?? '' }}</td>
                                <td>{{ $member->email ?? 'Not Available'}}</td>
                                <td>{{ $member->phone ?? 'Unavailable' }}</td>
                                <td>{{ $member->membership_type }}</td>
                                <td>{{ $member->membership_status }}</td>
                                <td>{{ $member->membership_validity }}</td>
                                <td>{{ $member->visits }}</td>
                                <td>{{ $member->address }}</td>
                                <td>
                                <div class="action-button">
                                    <a href="{{route('member.edit', ['member' => $member])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form method="post" action="{{route('member.destroy', ['member' => $member])}}">
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
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
@endsection