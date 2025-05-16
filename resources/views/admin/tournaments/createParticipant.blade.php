@extends('layouts.AdminLayout')

@section('title', 'Participant Management - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
<style>
    .crud-content {
        height: 50%;
    }

    #user_id.error {
        border: 2px solid red;
    }
</style>
    <div class="content">
        <div class="page-header">
            <a href="{{ route('tournaments.index') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Tournaments List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header">Add Participant</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('participant.store') }}">
                            @csrf

                            <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">

                            <div class="form-full">
                                <label for="user_id">User ID</label>
                                <input type="text" name="user_id" id="user_id" minlength="14" maxlength="14" value="{{ old('user_id') }}" placeholder="Enter User ID or leave empty" autofocus>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const userIdInput = document.getElementById('user_id');
                                    const nameInput = document.getElementById('name');
                                    const phoneNumberInput = document.getElementById('contact_details');
                                    let lastFetchedId = '';

                                    userIdInput.addEventListener('input', function () {
                                        const userId = userIdInput.value;

                                        if (userId.length === 14 && userId !== lastFetchedId) {
                                            lastFetchedId = userId;

                                            fetch(`/users/${userId}`)
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        userIdInput.classList.remove('error');
                                                        nameInput.value = data.data.name;
                                                        phoneNumberInput.value = data.data.phone_number;
                                                    } else {
                                                        userIdInput.classList.add('error');
                                                        nameInput.value = '';
                                                        phoneNumberInput.value = '';
                                                        alert(data.message);
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error fetching user data:', error);
                                                    alert('An error occurred while fetching user data.');
                                                });

                                        }

                                        if (userId.length < 14) {
                                            lastFetchedId = '';
                                        }
                                    });
                                });
                            </script>

                            <div class="form-full">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter Full Name" required>
                            </div>

                            <div class="form-full">
                                <label for="contact_details">Contact Number</label>
                                <input type="text" name="contact_details" id="contact_details" value="{{ old('contact_details') }}" placeholder="Enter Contact Number" required>
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