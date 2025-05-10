@extends('layouts.AdminLayout')

@section('title', 'Facilities Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/members.css') }}">
@endsection

@section('main-content')
<div class="content">
    <div class="page-header">
        <h2>Facilities List</h2>
        <div class="page-button">
            <a href="{{ route('facility.create')}}"><ion-icon name="add-sharp"></ion-icon>Add New Facility</a>
        </div>
    </div>
    <div class="page-content">
        <div class="table-container">
            <table class="table-content">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Hourly Rate</th>
                        <th>Capacity</th>
                        <th>Facility Availability</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($facility_lists->isEmpty())
                        <tr>
                            <td colspan="9" style="text-align: center;">No facilities available.</td>
                        </tr>
                    @else
                        @foreach($facility_lists as $facility_list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $facility_list->name }}</td>
                                <td>{{ $facility_list->hourly_rate }}</td>
                                <td>{{ $facility_list->max_capacity }}</td>
                                <td>{{ \Carbon\Carbon::parse($facility_list->open_time)->format('g:i A') }}
                                     - 
                                     {{ \Carbon\Carbon::parse($facility_list->close_time)->format('g:i A') }}
                                </td>
                                <td>{{ $facility_list->status }}</td>
                                <td>{{ $facility_list->description }}</td>
                                <td>
                                    <div class="action-button">
                                        <a href="{{route('facility.edit', ['facility_list' => $facility_list])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form method="post" action="{{route('facility.destroy', ['facility_list' => $facility_list])}}">
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
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection