@extends('layouts.AdminLayout')

@section('title', 'Students')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Class Students</h2>
            <div class="page-button">
                <a href="{{ route('student.create') }}"><ion-icon name="add-outline"></ion-icon>Add New Student</a>
            </div>
        </div>
        <div class="page-content">
            <div class="table-container">
                <table class="table-content">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Attended</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($students->isEmpty())
                            <tr>
                                <td colspan="8" style="text-align: center;">No stuedent records available.</td>
                            </tr>
                        @else
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                                    <td>{{ $student->classList->name }}</td>
                                    <td>{{ $student->user->unique_id }}</td>
                                    <td>{{ $student->user->first_name ?? '' }} {{ $student->user->last_name ?? '' }}</td>
                                    <td>{{ $student->status }}</td>
                                    <td>{{ $student->attended }}</td>
                                    <td>{{ $student->payment_status }}</td>
                                    <td>
                                    <div class="action-button">
                                        <a href="{{route('student.edit', ['student' => $student])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form method="post" action="{{route('student.destroy', ['student' => $student])}}">
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
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection