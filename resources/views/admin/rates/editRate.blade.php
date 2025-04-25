@extends('layouts.AdminLayout')

@section('title', 'Rates')

@section('header-title', 'Membership Plans')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/admin/rates.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('rate.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Available Plans</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header">Edit Membership Plan</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('rate.update', ['rate' => $rate]) }}">
                            @csrf
                            @method('put')

                            <div class="form-full">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{$rate->name}}" placeholder="Name" required autofocus>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" value="{{$rate->price}}" placeholder="Price" required>
                                </div>
                                <div class="form-content">
                                    <label for="color">Choose a color</label>
                                    <input type="color" id="color" name="color" value="{{$rate->color}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="validity_value">Validity Value</label>
                                    <input type="number" name="validity_value" id="validity_value" value="{{$rate->validity_value}}" required min="1">
                                    <p id="validity_error" style="color: red; font-size: 14px;"></p>
                                </div>
                                <div class="form-content">
                                    <label for="validity_unit">Validity Unit</label>
                                    <select name="validity_unit" id="validity_unit" required>
                                        <option value="" disabled selected>-Validity Unit-</option>
                                        <option value="day" {{ ($rate->validity_unit == 'day') ? 'selected' : '' }}>Day(s)</option>
                                        <option value="month" {{ ($rate->validity_unit == 'month') ? 'selected' : '' }}>Month(s)</option>
                                        <option value="year" {{ ($rate->validity_unit == 'year') ? 'selected' : '' }}>Year(s)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-full">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" maxlength="500" placeholder="Provide a brief description.">{{ $rate->description }}</textarea>
                            </div>

                            <div class="form-full">
                                <label for="perks">Perks</label>
                                <textarea name="perks" id="perks" rows="3" placeholder="Perks for availing the plan.">{{ $rate->perks }}</textarea>
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

@section('js-container')
    <script>
        document.getElementById('validity_unit').addEventListener('change', function() {
            let validityInput = document.getElementById('validity_value');
            let unit = this.value;
            let errorMessage = document.getElementById('validity_error');

            if (unit === '') {
                validityInput.disabled = true; // Disable input if no unit is selected
                errorMessage.textContent = '';
                validityInput.style.borderColor = '';
                return;
            } else {
                validityInput.disabled = false; // Enable input once unit is selected
            }

            if (unit === 'day') {
                validityInput.min = 1;
                validityInput.max = 31;
            } else if (unit === 'month') {
                validityInput.min = 1;
                validityInput.max = 12;
            } else if (unit === 'year') {
                validityInput.min = 1;
                validityInput.max = 3;
            }

            // validityInput.value = ''; Reset value on unit change
            errorMessage.textContent = ''; // Clear error message
            validityInput.style.borderColor = ''; // Reset border color
        });

        document.getElementById('validity_value').addEventListener('input', function() {
            let unit = document.getElementById('validity_unit').value;
            let errorMessage = document.getElementById('validity_error');
            let min = parseInt(this.min);
            let max = parseInt(this.max);
            let value = parseInt(this.value);

            if (unit === '') {
                return; // Don't validate if no unit is selected
            }

            if (value < min || value > max || isNaN(value)) {
                errorMessage.textContent = `Value must be between ${min} and ${max}.`;
                this.style.borderColor = 'red';
            } else {
                errorMessage.textContent = '';
                this.style.borderColor = ''; // Reset border if valid
            }
        });
    </script>
@endsection