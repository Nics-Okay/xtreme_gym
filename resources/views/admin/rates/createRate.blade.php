@extends('layouts.AdminLayout')

@section('title', 'Rates')

@section('header-title', 'Membership Plans')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/admin/rates.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="crud-container">
        <div class="crud-section return">
            <a href="{{ route('rate.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <p>Back</p>
            </a>
        </div>
        <div>
            @if(session()->has('success'))
                <div>
                    {{session('success')}}
                </div>
            @endif
        </div>

        <div class="universal-div">
            <div class="universal-div-main">
                <h3 class="universal-div-header">New Membership Plan</h3>
                <div>
                    @if(session()->has('success'))
                        <div>
                            {{session('success')}}
                        </div>
                    @endif
                </div>
                <div class="universal-div-content">
                    <form method="post" action="{{ route('rate.store') }}">
                        @csrf
                        @method('post')
                        <div class="label">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" required autofocus>
                        </div>
                        <div class="label">
                            <label for="color">Choose color:</label>
                            <input type="color" id="color" name="color">
                        </div>
                        <div class="label">
                            <label for="validity_value">Validity:</label>
                            <input type="number" name="validity_value" id="validity_value" required min="1">
                            <p id="validity_error" style="color: red; font-size: 14px;"></p>

                            <select name="validity_unit" id="validity_unit" required>
                                <option value="" disabled selected>-Validity Unit-</option>
                                <option value="day">Day(s)</option>
                                <option value="month">Month(s)</option>
                                <option value="year">Year(s)</option>
                            </select>
                            <p>
                                <!-- Instruction -->
                            </p>
                        </div>
                        <div class="label">
                            <label for="price">Price:</label>
                            <input type="text" name="price" id="price" required>
                        </div>
                        <div class="label">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" rows="3"></textarea>
                        </div>
                        <div class="label">
                            <label for="perks">Perks:</label>
                            <textarea name="perks" id="perks" rows="3"></textarea>
                        </div>
                        <div class="submit-button">
                            <input type="submit" value="Confirm">
                        </div>
                    </form>
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