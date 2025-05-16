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
                <div class="crud-content">
                    <h3 class="crud-header" style="margin-bottom: 10px;">Add Guest Attendee</h3>
                    <div class="crud-form">
                        <form action="{{ route('guest.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" placeholder="Enter Guest Firstname" required/>
                                </div>
                                <div class="form-content">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" placeholder="Enter Guest Lastname"/>
                                </div>
                            </div> 

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" placeholder="Guest Email Address"/>
                                </div>
                                <div class="form-content">
                                    <label for="phone">Contact Number</label>
                                    <input type="text" id="phone" name="phone" placeholder="Guest Phone Number" required/>
                                </div>
                            </div> 

                            <p>Address</p>
                            <div class="form-group">
                                <div class="form-content">
                                    <input type="text" id="city" name="city" placeholder="City"/>

                                </div>
                                <div class="form-content">
                                    <input type="text" id="province" name="province" placeholder="Province"/>
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
                                        <input type="text" name="other_payment_method" placeholder="Please specify">
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
                                    radio.addEventListener('change', function() {
                                        if (document.getElementById('other-payment').checked) {
                                            document.getElementById('other-payment-method').style.display = 'block';
                                            document.querySelector('input[name="other_payment_method"]').setAttribute('required', 'required');
                                        } else {
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