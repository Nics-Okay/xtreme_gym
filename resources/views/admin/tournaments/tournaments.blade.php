@extends('layouts.AdminLayout')

@section('title', 'Tournaments')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Tournaments List</h2>
            <div class="page-button">
                <a href="#"><ion-icon name="add-sharp"></ion-icon>Create Tournament</a>
            </div>
        </div>
        <div class="page-content">
            <div class="table-container">
                <table class="table-content">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Guest ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Payment Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tournaments as $tournament)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $tournament->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                <div class="action-button">
                                    <a href="{{route('tournament.edit', ['tournament' => $tournament])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form method="post" action="{{route('tournament.destroy', ['tournament' => $tournament])}}">
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