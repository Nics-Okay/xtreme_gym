@extends('layouts.AdminLayout')

@section('title', 'Attendee Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('attendee.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Attendee List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content" style="height: fit-content; width: 35%; padding: 25px 0;">
                    <h3 class="crud-header" style="margin-bottom: 10px;">Add Member Attendee</h3>
                    <div class="crud-form">
                        <form action="{{ route('attendee.store') }}" method="post">
                            @csrf
                            <div class="form-full">
                                <label for="identification">User Identification</label>
                                <input type="text" id="identification" name="identification" value="{{ old('identification') }}" placeholder="Enter name or ID" required>
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