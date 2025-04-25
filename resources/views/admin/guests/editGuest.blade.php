@extends('layouts.AdminLayout')

@section('title', 'Guest')

@section('header-title', 'Manage Guest')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/admin/rates.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('guest.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Guest List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header" style="margin-bottom: 10px;">Edit Guest Information</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('guest.update', [ 'guest' => $guest ]) }}">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ $guest->first_name }}" placeholder="First Name" required/>
                                </div>
                                <div class="form-content">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" value="{{ $guest->last_name }}" placeholder="Last Name"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="{{ $guest->email }}" placeholder="Email Address"/>
                                </div>
                                <div class="form-content">
                                    <label for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ $guest->phone }}" placeholder="Phone Number" required/>
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
                                    <input type="text" id="city" name="city" value="{{ $city }}" placeholder="City"/>

                                </div>
                                <div class="form-content">
                                    <input type="text" id="province" name="province" value="{{ $province }}" placeholder="Province"/>
                                </div>
                            </div>

                            <div class="form-group payment">
                                <label for="payment_method" style="font-weight: bold;">Payment Method</label>
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

                                    <div id="other-payment-method" style="display:none;">
                                        <input type="text" rowspan="3" name="other_payment_method" placeholder="Please specify">
                                    </div>
                                </div>
                            </div>

                            <div class="submit-button">
                                <input type="submit" value="Confirm">
                            </div>
                        </form>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection