@extends('layouts.AdminLayout')

@section('title', 'Facility Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('facility.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Facilities List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header">Edit Facility Information</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('facility.update', ['facility_list' => $facility_list]) }}">
                            @csrf
                            @method('put')
                            
                            <div class="form-full">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $facility_list->name) }}" placeholder="Facility Name" required>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="hourly_rate">Hourly Rate</label>
                                    <input type="number" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $facility_list->hourly_rate) }}" placeholder="Enter facility hourly rate" required>
                                </div>
                                <div class="form-content">
                                    <label for="max_capacity">Max Capacity</label>
                                    <input type="number" id="max_capacity" name="max_capacity" value="{{ old('max_capacity', $facility_list->max_capacity) }}" placeholder="Enter facility max capacity" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="open_time">Opening</label>
                                    <input type="time" id="open_time" name="open_time" value="{{ old('open_time', $facility_list->open_time) }}" placeholder="Facility opening time" required>
                                </div>
                                <div class="form-content">
                                    <label for="close_time">Closing</label>
                                    <input type="time" id="close_time" name="close_time" value="{{ old('close_time', $facility_list->close_time) }}" placeholder="Facility closing time" required>
                                </div>
                            </div>

                            <div class="form-full">
                                <label for="status">Status</label>
                                <input type="text" name="status" id="status" value="{{ old('status', $facility_list->status) }}" placeholder="Facility Status" required>
                            </div>

                            <div class="form-full">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="4" placeholder="Provide a brief description" required>{{ old('description', $facility_list->description) }}</textarea>
                            </div>
   
                            <div class="submit-button">
                                <input type="submit" value="Confirm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
