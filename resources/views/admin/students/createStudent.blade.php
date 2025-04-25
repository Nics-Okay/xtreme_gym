@extends('layouts.AdminLayout')

@section('title', 'Student Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('student.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Students List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header" style="margin-bottom: 10px;">Add New Student</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('student.store') }}">
                            @csrf

                            <div class="form-full">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="Name" required autofocus>
                            </div>

                            <div class="form-full">
                                <label for="user_id">User ID</label>
                                <input type="text" name="user_id" id="user_id" placeholder="User ID">
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="class_id">Class</label>
                                    <select name="class_id" id="class_id" required>
                                        <option value="" disabled selected>-Select Class-</option>
                                        @foreach( $classLists as $classList)
                                            <option value="{{ $classList->id }}">{{ $classList->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-content">
                                    <label for="payment_status">Payment Status</label>
                                    <input type="text" name="payment_status" id="payment_status" placeholder="Ex. Completed, Pending">
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