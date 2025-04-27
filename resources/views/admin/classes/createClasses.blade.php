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
                    <h3 class="crud-header">Add New Class</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('classList.store') }}">
                            @csrf

                            <div class="form-full">
                                <label for="name">Title</label>
                                <input type="text" name="name" id="name" placeholder="Class Title" required autofocus>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="trainer">Trainer</label>
                                    <select name="trainer" id="trainer" required>
                                        <option value="" disabled selected>-Choose Trainer-</option>
                                        @foreach( $trainers as $trainer)
                                            <option value="{{ $trainer->id }}">Coach {{ $trainer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-content">
                                    <label for="schedule">Schedule</label>
                                    <input type="text" id="schedule" name="schedule" maxlength="255" placeholder="Ex. 8:00 AM - 11:00 AM" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="start">Start Date</label>
                                    <input type="date" id="start" name="start" onclick="this.showPicker()" required>
                                </div>
                                <div class="form-content">
                                    <label for="end">End Date</label>
                                    <input type="date" id="end" name="end" onclick="this.showPicker()" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="price">Price</label>
                                    <input type="text" id="price" name="price" placeholder="Price" required>
                                </div>
                                <div class="form-content">
                                    <label for="duration">Duration</label>
                                    <input type="text" id="duration" name="duration" placeholder="Ex. 200 Hours, 20 Days" required>
                                </div>
                            </div>

                            <div class="form-full">
                                <label for="status">Status</label>
                                <input type="text" name="status" id="status" placeholder="Ex. Enrollment Ongoing, Coming Soon" required>
                            </div>

                            <div class="form-full">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4" maxlength="500" placeholder="Tell something about the class." required></textarea>
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