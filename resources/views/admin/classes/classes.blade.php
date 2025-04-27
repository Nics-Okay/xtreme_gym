@extends('layouts.AdminLayout')

@section('title', 'Classes')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Gym Classes</h2>
            <div class="page-button">
                <a href="{{ route('classList.create') }}"><ion-icon name="add-outline"></ion-icon>Add New Class</a>
            </div>
        </div>
        <div class="page-content">
            <div class="table-container">
                <table class="table-content">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Trainer</th>
                            <th>Schedule</th>
                            <th>Duration</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                            <th>Students</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($classLists->isEmpty())
                            <tr>
                                <td colspan="12" style="text-align: center;">No classes available.</td>
                            </tr>
                        @else
                            @foreach($classLists as $classList)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $classList->name }}</td>
                                    <td>Coach {{ $classList->trainer ?? 'Unassigned' }}</td>
                                    <td>{{ $classList->schedule ?? 'TBA'}}</td>
                                    <td>{{ $classList->duration ?? 'TBA' }}</td>
                                    <td>{{ $classList->class_start ?? 'TBA' }}</td>
                                    <td>{{ $classList->class_end ?? 'TBA' }}</td>
                                    <td>{{ $classList->status }}</td>
                                    <td>{{ $classList->number_of_students }}</td>
                                    <td>{{ $classList->price }}</td>
                                    <td>{{ $classList->description }}</td>
                                    <td>
                                    <div class="action-button">
                                        <a href="{{route('classList.edit', ['classList' => $classList])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form method="post" action="{{route('classList.destroy', ['classList' => $classList])}}">
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
    </div>
@endsection