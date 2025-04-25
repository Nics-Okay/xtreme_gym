@extends('layouts.AdminLayout')

@section('title', 'Trainer Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/members.css') }}">
@endsection

@section('main-content')
<div class="content">
    <div class="page-header">
        <h2>Trainers List</h2>
        <div class="page-button">
            <a href="{{ route('trainer.create')}}"><ion-icon name="add-sharp"></ion-icon>Add New Trainer</a>
        </div>
    </div>
    <div class="page-content">
        <div class="table-container">
            <table class="table-content">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Phone</th>
                        <th>Availability</th>
                        <th>Students</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($trainers->isEmpty())
                        <tr>
                            <td colspan="8" style="text-align: center;">No trainer available.</td>
                        </tr>
                    @else
                        @foreach($trainers as $trainer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="image-data">
                                    <div class="image-holder">
                                        <img src="{{ $trainer->user->image ? asset('storage/' . $user->image) : asset('images/profile-placeholder.png') }}" alt="Member Image">
                                    </div>
                                </td>
                                <td>{{ $trainer->user_id }}</td>
                                <td>{{ $trainer->name }}</td>
                                <td>{{ $trainer->specialization }}</td>
                                <td>{{ $trainer->phone }}</td>
                                <td>{{ $trainer->availability }}</td>
                                <td>{{ $trainer->students }}</td>
                                <td>
                                <div class="action-button">
                                    <a href="{{route('trainer.edit', ['trainer' => $trainer])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form method="post" action="{{route('trainer.destroy', ['trainer' => $trainer])}}">
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