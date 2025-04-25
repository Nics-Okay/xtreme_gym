@extends('layouts.AdminLayout')

@section('title', 'Trainer Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('trainer.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Trainers List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header">Add New Trainer</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('trainer.store') }}">
                            @csrf

                            <div class="form-full">
                                <label for="name">User ID</label>
                                <input type="text" name="user_id" id="user_id" placeholder="User ID" autofocus>
                            </div>

                            <div class="form-full">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="Name" required>
                            </div>

                            <div class="form-full">
                                <label for="specialization">Specialization</label>
                                <input type="text" name="specialization" id="specialization" placeholder="Specialization" required>
                            </div>

                            <div class="form-full">
                                <label for="description">Phone</label>
                                <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
                            </div>

                            <div class="form-full">
                                <label for="description">Availability</label>
                                <input type="text" name="availability" id="availability" placeholder="Available Hours">
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