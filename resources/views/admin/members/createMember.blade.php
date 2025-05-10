@extends('layouts.AdminLayout')

@section('title', 'Members Management - Xtreme Gym World')

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
                    <h3 class="crud-header">Add New Member</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('member.store') }}">
                            @csrf

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="first_name">First name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Client's first name" maxlength="255" autofocus required>
                                </div>
                                <div class="form-content">
                                    <label for="last_name">Last name</label>
                                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Client's last name" maxlength="255" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter a valid email address" maxlength="255">
                                </div>
                                <div class="form-content">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" minlength="11" maxlength="13" value="{{ old('phone') }}" placeholder="Enter an valid phone number" required>
                                </div>
                            </div>

                            <p>Address</p>
                            <div class="form-group">
                                <div class="form-content">
                                    <input type="text" name="city" id="city" value="{{ old('city') }}" placeholder="City" required>
                                </div>
                                <div class="form-content">
                                    <input type="text" name="province" id="province" value="{{ old('province') }}" placeholder="Province" required>
                                </div>
                            </div>

                            <p>In Case of Emergency</p>
                            <div class="form-group">
                                <div class="form-content">
                                    <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ old('emergency_contact_name') }}" placeholder="Emergency contact name">
                                </div>
                                <div class="form-content">
                                    <input type="text" name="emergency_contact_number" id="emergency_contact_number" minlength="11" maxlength="13" value="{{ old('emergency_contact_number') }}" placeholder="Emergency contact number">
                                </div>
                            </div>

                            <div class="form-full rate">
                                <label for="rate_id">Membership Validity:</label>
                                <select name="rate_id" id="rate_id" required>
                                    <option value="" disabled {{ old('rate_id') ? '' : 'selected' }}>- Select Membership -</option>
                                    @foreach($rates as $rate)
                                        <option value="{{ $rate->id }}" {{ old('rate_id') == $rate->id ? 'selected' : '' }}>
                                            {{ $rate->validity_value }} {{ $rate->validity_unit }} (s) for ₱{{ $rate->price }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group payment">
                                <label for="payment_method" style="font-weight: bold;">Payment Method</label>
                                <div class="payment-options">
                                    <label>
                                        <input type="radio" name="payment_method" value="cash" required 
                                        {{ old('payment_method') == 'cash' || old('payment_method') == '' ? 'checked' : '' }}> Cash
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="gcash" required 
                                            {{ old('payment_method') == 'gcash' ? 'checked' : '' }}> GCash
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="card" required 
                                            {{ old('payment_method') == 'card' ? 'checked' : '' }}> Card
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="other" id="other-payment" 
                                            {{ old('payment_method') == 'other' ? 'checked' : '' }}> Other
                                    </label>

                                    <div id="other-payment-method" style="display: {{ old('payment_method') == 'other' ? 'block' : 'none' }};">
                                        <input type="text" name="other_payment_method" placeholder="Please specify" value="{{ old('other_payment_method') }}">
                                    </div>
                                </div>
                            </div>

                            <script>
                                // Show/Hide "Other" field based on user selection
                                document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
                                    radio.addEventListener('change', function() {
                                        if (document.getElementById('other-payment').checked) {
                                            // Show the "Other" payment method input and make it required
                                            document.getElementById('other-payment-method').style.display = 'block';
                                            document.querySelector('input[name="other_payment_method"]').setAttribute('required', 'required');
                                        } else {
                                            // Hide the "Other" payment method input and remove the required attribute
                                            document.getElementById('other-payment-method').style.display = 'none';
                                            document.querySelector('input[name="other_payment_method"]').removeAttribute('required');
                                        }
                                    });
                                });
                            </script>

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