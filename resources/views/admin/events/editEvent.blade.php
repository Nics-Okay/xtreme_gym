@extends('layouts.AdminLayout')

@section('title', 'Event Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('event.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Events List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header">Edit Event Information</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('event.update', ['event' => $event]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="form-full">
                                <label for="name">Event Name</label>
                                <input type="text" name="name" id="name" value="{{ $event->name }}" placeholder="Event Name" required autofocus>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="event_type">Event Type</label>
                                    <input type="text" id="event_type" name="event_type" maxlength="100" value="{{ $event->event_type }}" placeholder="Event Type" required>
                                </div>
                                <div class="form-content">
                                    <label for="date">Date</label>
                                    <input type="text" id="dateInput" value="{{ $event->date }}" placeholder="Select a date" min="{{ date('Y-m-d') }}"  
                                        onfocus="(this.type='date')" 
                                        onclick="this.showPicker()"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="location">Location</label>
                                    <input type="text" id="location" name="location" value="{{ $event->location }}"  placeholder="Location" maxlength="255">
                                </div>
                                <div class="form-content">
                                    <label for="organizer">Organizer</label>
                                    <input type="text" id="organizer" name="organizer" maxlength="255" value="{{ $event->organizer }}" placeholder="Organizer">
                                </div>
                            </div>

                            <div class="form-full">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4" maxlength="500" placeholder="Tell something about the event." required>{{ $event->description }}</textarea>
                            </div>

                            <div class="form-full">
                                <label for="image">Thumbnail</label>
                                <input type="file" id="image" name="image" style="border: none; padding: 2px 0 6px 0;" accept="image/*" value="{{ $event->image}}">
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