@extends('layouts.AdminLayout')

@section('title', 'Edit Member - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('member.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Members List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header" style="margin-bottom: 20px;">Edit Member Information</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('member.update',  ['member' => $member]) }}">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="first_name">First name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ $member->first_name }}" placeholder="First name" maxlength="255" autofocus required>
                                </div>
                                <div class="form-content">
                                    <label for="last_name">Last name</label>
                                    <input type="text" id="last_name" name="last_name" value="{{ $member->last_name }}" placeholder="Last name" maxlength="255" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="{{ $member->email }}" placeholder="Email" maxlength="255">
                                </div>
                                <div class="form-content">
                                    <label for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ $member->phone }}" placeholder="Phone" required>
                                </div>
                            </div>

                            @php
                                $addressParts = explode(', ', $member->address ?? '');
                                $city = $addressParts[0] ?? ''; // Extract city
                                $province = $addressParts[1] ?? ''; // Extract province
                            @endphp

                            <p>Address</p>
                            <div class="form-group">
                                <div class="form-content">
                                    <input type="text" name="city" id="city" value="{{ old('city', $city) }}" placeholder="City" required>
                                </div>
                                <div class="form-content">
                                    <input type="text" name="province" id="province" value="{{ old('province', $province) }}" placeholder="Province" required>
                                </div>
                            </div>

                            <p>In Case of Emergency</p>
                            <div class="form-group">
                                <div class="form-content">
                                    <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ $member->emergency_contact_name }}" placeholder="Emergency Contact Name">
                                </div>
                                <div class="form-content">
                                    <input type="text" name="emergency_contact_number" id="emergency_contact_number" value="{{ $member->emergency_contact_number }}" placeholder="Emergency Contact #">
                                </div>
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