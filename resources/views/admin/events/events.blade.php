@extends('layouts.AdminLayout')

@section('title', 'Event Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/events.css') }}">
@endsection

@section('main-content')
<div class="content">
    <div class="page-header">
        <h2>Events List</h2>
        <div class="page-button">
            <a href="{{ route('event.create')}}"><ion-icon name="add-sharp"></ion-icon>Add New Event</a>
        </div>
    </div>
    <div class="page-content">
        <div class="list-container">
            <h2>Upcoming Events</h2>
            @foreach($upcomingEvents as $upcomingEvent)
                <div class="list-content">
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $upcomingEvent->image) }}" alt="Event Image">
                    </div>
                    <div class="list-info">
                        <h3>{{ $upcomingEvent->name }}</h3>
                        <p><strong>What:</strong> {{ $upcomingEvent->event_type }}</p>
                        <p><strong>When:</strong> {{ $upcomingEvent->date  ?? 'TBA'}}</p>
                        <p><strong>Where:</strong> {{ $upcomingEvent->location  ?? 'TBA'}}</p>
                        <p><strong>Event Status:</strong> {{ $upcomingEvent->status  ?? 'Ongoing'}}</p>
                        <p><strong>Organizer:</strong> {{ $upcomingEvent->organizer  ?? 'Xtreme Management'}}</p>
                        <p><strong>No. of people going:</strong> {{ $upcomingEvent->going }}</p>
                        <p><strong>Description:</strong> {{ $upcomingEvent->description }}</p>
                    </div>
                    <div class="action-buttons events">
                        <a href="{{route('event.edit', ['event' => $upcomingEvent])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i><p>Edit</p></a>
                        <form method="post" action="{{route('event.destroy', ['event' => $upcomingEvent])}}">
                            @csrf 
                            @method('delete')
                            <button type="submit" class="delete-button">
                                <i class="fa-solid fa-trash"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            <h2>Past Events</h2>
            @foreach($completedEvents as $completedEvent)
                <div class="list-content">
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $upcomingEvent->image) }}" alt="Event Image">
                    </div>
                    <div class="list-info">
                        <p>{{ $completedEvent->name }}</p>
                        <p>{{ $completedEvent->event_type }}</p>
                        <p>{{ $completedEvent->date  ?? 'Not Available'}}</p>
                        <p>{{ $completedEvent->location  ?? 'Not Available'}}</p>
                        <p>{{ $completedEvent->status  ?? 'Completed'}}</p>
                        <p>{{ $completedEvent->organizer  ?? 'Xtreme Management'}}</p>
                        <p>{{ $completedEvent->going }}</p>
                        <p>{{ $completedEvent->description }}</p>
                    </div>
                    <div class="action-buttons events">
                        <a href="{{route('event.edit', ['event' => $completedEvent])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i><p>Edit</p></a>
                        <form method="post" action="{{route('event.destroy', ['event' => $completedEvent])}}">
                            @csrf 
                            @method('delete')
                            <button type="submit" class="delete-button">
                                <i class="fa-solid fa-trash"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif
@endsection