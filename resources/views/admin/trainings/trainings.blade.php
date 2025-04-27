@extends('layouts.AdminLayout')

@section('title', 'Trainings - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Personal Trainings</h2>
            <div class="page-button">
                <a href="{{ route('training.create') }}"><ion-icon name="add-outline"></ion-icon>Add New Training</a>
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
                            <th>Status</th>
                            <th>Students</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($trainings->isEmpty())
                            <tr>
                                <td colspan="9" style="text-align: center;">No personal trainings available.</td>
                            </tr>
                        @else
                            @foreach($trainings as $training)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $training->name }}</td>
                                    <td>Coach {{ $training->trainer ?? 'Unassigned' }}</td>
                                    <td>{{ $training->schedule ?? 'TBA'}}</td>
                                    <td>{{ $training->status }}</td>
                                    <td>{{ $training->number_of_students }}</td>
                                    <td>{{ $training->price }}</td>
                                    <td>{{ $training->description }}</td>
                                    <td>
                                    <div class="action-button">
                                        <a href="{{route('training.edit', ['training' => $training])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form method="post" action="{{route('training.destroy', ['training' => $training])}}">
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