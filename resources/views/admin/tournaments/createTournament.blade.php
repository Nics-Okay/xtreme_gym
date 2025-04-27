@extends('layouts.AdminLayout')

@section('title', 'Tournaments')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
<style>
    .crud-content {
        height: 80%;
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
                    <h3 class="crud-header">Create Tournament</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('tournaments.store') }}">
                            @csrf

                            <div class="form-full">
                                <label for="name">Tournament Name</label>
                                <input type="text" name="name" id="name" placeholder="Name" required autofocus>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="type">Type</label>
                                    <input type="text" id="type" name="type" placeholder="Type" maxlength="255" required>
                                </div>
                                <div class="form-content">
                                    <label for="tournament_date">Date</label>
                                    <input type="date" id="tournament_date" name="tournament_date" onclick="this.showPicker()" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="semi_finals">Semi Finals</label>
                                    <input type="date" id="semi_finals" name="semi_finals" onclick="this.showPicker()">
                                </div>
                                <div class="form-content">
                                    <label for="finals">Finals</label>
                                    <input type="date" id="finals" name="finals" onclick="this.showPicker()">
                                </div>
                            </div>

                            <h5 style="justify-self: normal; width: 100%; padding-left: 10px;">Registration Details</h5>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="start">Registration Start</label>
                                    <input type="date" id="start" name="start" onclick="this.showPicker()">
                                </div>
                                <div class="form-content">
                                    <label for="end">Registration End</label>
                                    <input type="date" id="end" name="end" onclick="this.showPicker()">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="registration_fee">Registration Fee</label>
                                    <input type="number" id="registration_fee" name="registration_fee" placeholder="Registration Fee" required>
                                </div>
                                <div class="form-content">
                                    <label for="status">Tournament Status</label>
                                    <input type="text" id="status" name="status" maxlength="255" placeholder="Ex. Registration, Ongoing" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="first_prize">1st Prize</label>
                                    <input type="number" id="first_prize" name="first_prize" placeholder="1st">
                                </div>
                                <div class="form-content">
                                    <label for="second_prize">2nd Prize</label>
                                    <input type="number" id="second_prize" name="second_prize" placeholder="2nd">
                                </div>
                                <div class="form-content">
                                    <label for="third_prize">3rd Prize</label>
                                    <input type="number" id="third_prize" name="third_prize" placeholder="3rd">
                                </div>
                            </div>

                            <div class="form-full">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="3" maxlength="500" placeholder="Tell something about the tournament." required></textarea>
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