@extends('layouts.AdminLayout')

@section('title', 'Tournaments - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Tournaments List</h2>
            <div class="page-button">
                <a href="{{ route('tournaments.create') }}"><ion-icon name="add-sharp"></ion-icon>Create Tournament</a>
            </div>
        </div>
        <div class="page-content">
            <div class="table-container">
                <table class="table-content">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Date</th>
                            <th rowspan="2">Name</th>
                            <th rowspan="2">Type</th>
                            <th rowspan="2">Fee</th>
                            <th rowspan="2">Status</th>

                            <th colspan="2">Registration Date</th>
                            <th colspan="3">Prizes</th>
                            <th rowspan="2">Description</th>
                            <th rowspan="2">Actions</th>
                        </tr>
                        <tr>
                            <th>Start</th>
                            <th>End</th>
                            <th>1st</th>
                            <th>2nd</th>
                            <th>3rd</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tournaments as $tournament)
                            <tr>
                                <td>{{ $tournament->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($tournament->tournament_date)->format('F j, Y') }}</td>
                                <td>{{ $tournament->name }}</td>
                                <td>{{ $tournament->type }}</td>
                                <td>{{ $tournament->registration_fee }}</td>
                                <td>{{ $tournament->status }}</td>
                                <td>{{ $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') : 'N/A' }}</td>
                                <td>{{ $tournament->end_date ? \Carbon\Carbon::parse($tournament->end_date)->format('F j, Y') : 'N/A' }}</td>
                                <td>{{ $tournament->first_prize }}</td>
                                <td>{{ $tournament->second_prize }}</td>
                                <td>{{ $tournament->third_prize }}</td>
                                <td>{{ $tournament->description }}</td>
                                <td>
                                <div class="action-button">
                                    <a href="{{route('tournaments.edit', ['tournament' => $tournament])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form method="post" action="{{route('tournaments.destroy', ['tournament' => $tournament])}}">
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
@endsection