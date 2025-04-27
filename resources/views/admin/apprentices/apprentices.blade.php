@extends('layouts.AdminLayout')

@section('title', 'Apprentices - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Personal Training Apprentices</h2>
            <div class="page-button">
                <a href="{{ route('apprentice.create') }}"><ion-icon name="add-outline"></ion-icon>Add New Apprentice</a>
            </div>
        </div>
        <div class="page-content">
            <div class="table-container">
                <table class="table-content">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Training</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Student Until</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($apprentices->isEmpty())
                            <tr>
                                <td colspan="6" style="text-align: center;">No stuedent records available.</td>
                            </tr>
                        @else
                            @foreach($apprentices as $apprentice)
                                <tr>
                                    <td>{{ ($apprentices->currentPage() - 1) * $apprentices->perPage() + $loop->iteration }}</td>
                                    <td>{{ $apprentice->training->name }}</td>
                                    <td>{{ $apprentice->user->unique_id }}</td>
                                    <td>{{ $apprentice->user->first_name ?? '' }} {{ $apprentice->user->last_name ?? '' }}</td>
                                    <td>{{ $apprentice->student_until }}</td>
                                    <td>
                                        <div class="action-button">
                                            <a href="{{route('apprentice.edit', ['apprentice' => $apprentice])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <form method="post" action="{{route('apprentice.destroy', ['apprentice' => $apprentice])}}">
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
                <div class="pagination">
                    {{ $apprentices->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection