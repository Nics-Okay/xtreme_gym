@extends('layouts.AdminLayout')

@section('title', 'Trainer Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/modal.css') }}">
@endsection

@section('main-content')
<div class="content">
    <div class="page-header">
        <h2>Trainers List</h2>
        <div class="page-button">
            <!-- Updated to toggle modal -->
            <button type="button" onclick="showModal()">
                <ion-icon name="add-sharp"></ion-icon>Add New Trainer
            </button>
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
                    @foreach($trainers as $trainer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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
                </tbody>
            </table>
        </div>
    </div>
    <!-- Scoped Modal Overlay -->
    <div id="confirmationModal" class="modal-overlay" aria-hidden="true">
        <div class="modal-box">
            <h3>Add New Trainer</h3>
            <!-- Sample form -->
            <form id="confirmForm" method="post" action="">
                @csrf
                <label for="trainerName">Trainer Name:</label>
                <input type="text" id="trainerName" name="trainerName" required>

                <label for="trainerEmail">Trainer Email:</label>
                <input type="email" id="trainerEmail" name="trainerEmail" required>
                
                <div class="modal-buttons">
                    <button type="button" onclick="closeModal()">Cancel</button>
                    <button type="submit">Confirm</button>
                </div>
            </form>
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