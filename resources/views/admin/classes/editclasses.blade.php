@extends('layouts.AdminLayout')

@section('title', 'Class Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('classList.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Class List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header">Edit Class Information</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('classList.update', ['classList' => $classList]) }}">
                            @csrf
                            @method('put')

                            <div class="form-full">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ $classList->name }}" placeholder="Name" required autofocus>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="trainer">Trainer</label>
                                    <input type="text" id="trainer" name="trainer" value="{{ $classList->trainer }}" placeholder="Trainer" maxlength="255">
                                </div>
                                <div class="form-content">
                                    <label for="schedule">Schedule</label>
                                    <input type="text" id="schedule" name="schedule" maxlength="255" value="{{ $classList->schedule }}" placeholder="Ex. 8:00 AM - 11:00 AM">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="start">Start Date</label>
                                    <input type="date" id="start" name="start" onclick="this.showPicker()" maxlength="255" value="{{ $classList->class_start }}">
                                </div>
                                <div class="form-content">
                                    <label for="end">End Date</label>
                                    <input type="date" id="end" name="end" maxlength="255" onclick="this.showPicker()" value="{{ $classList->class_end }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="price">Price</label>
                                    <input type="text" id="price" name="price" value="{{ $classList->price }}" placeholder="Price" maxlength="255" required>
                                </div>
                                <div class="form-content">
                                    <label for="duration">Duration</label>
                                    <input type="text" id="duration" name="duration" maxlength="255" value="{{ $classList->duration }}" placeholder="Duration" required>
                                </div>
                            </div>

                            <div class="form-full">
                                <label for="status">Status</label>
                                <input type="text" name="status" id="status" value="{{ $classList->status }}" placeholder="Ex. Enrollment Ongoing, Coming Soon" required>
                            </div>

                            <div class="form-full">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4" maxlength="500" placeholder="Tell something about the class." required>{{ $classList->description }}</textarea>
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