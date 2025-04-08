@extends('layouts.UserLayout')

@section('title', 'Membership Plans')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/user/membership.css') }}">
@endsection

@section('main-content')
    <div class="global-content-container confirmation">
        <div class="global-container-header">
            <h2>Confirm Membership Request</h2>
        </div>
        <div class="global-container-subheader">
            <h4>New Payment Request</h4>
            <div class="payment-for" style="background-color: {{ $rates->color }};">
                <div class="payment-for-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                <p>{{ $rates->name }} Membership Plan</p>
                <h3>₱{{ $rates->price }}</h3>
            </div>
        </div>
        <div class="global-container-content">
            <h4>Plan Details</h4>
            <p class="plan-info">
                <span>Plan Type</span>
                <span>{{ $rates->name }} Membership Plan</span>
            </p>
            <p class="plan-info">
                <span>Plan Validity</span>
                <span>{{ $rates->validity_value }} {{ $rates->validity_unit . ($rates->validity_value > 1 ? 's' : '') }}</span>
            </p>
        </div>
        <div class="global-container-form">
            <h4>Your Information</h4>
            <form action="{{ route('membership.availStore') }}" method="post">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}" placeholder="First Name" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" placeholder="Phone Number">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}">
                    </div>
                </div>

                <!-- Address -->
                <p>Address</p>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="city" id="city" placeholder="City" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="province" id="province" placeholder="Province" required>
                    </div>
                </div>

                <p>In Case of Emergency</p>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="emergency_contact_name" id="emergency_contact_name" placeholder="Emergency Contact Name">
                    </div>

                    <div class="form-group">
                        <input type="text" name="emergency_contact_number" id="emergency_contact_number" placeholder="Emergency Contact #">
                    </div>
                </div>

                <input type="hidden" name="rate_id" value="{{ $rates->id }}">

                <!-- Payment Method -->
                <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <div class="payment-options">
                        <label>
                            <input type="radio" name="payment_method" value="cash" required checked> Cash
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="gcash" required> GCash
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="card" required> Card
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="other" id="other-payment"> Other
                        </label>

                        <!-- "Other" Payment Method Input Field -->
                        <div id="other-payment-method" style="display:none;">
                            <input type="text" name="other_payment_method" placeholder="Please specify">
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

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection