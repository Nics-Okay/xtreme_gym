@extends('layouts.AdminLayout')

@section('title', 'Apprentice Management')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <a href="{{ route('apprentice.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Apprentice List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header" style="margin-bottom: 10px;">Edit Apprentice Information</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('apprentice.update', ['apprentice' => $apprentice]) }}">
                            @csrf
                            @method('put')

                            <div class="form-full">
                                <label for="user_id">User ID</label>
                                <input type="text" name="user_id" id="user_id" value="{{ old('user_id', $apprentice->user_id)}}" placeholder="User ID" required>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="training_id">Training</label>
                                    <select name="training_id" id="training_id" required>
                                        <option value="" disabled {{ old('training_id', $apprentice->training_id) ? '' : 'selected' }}>- Select Training -</option>
                                        @foreach ($trainings as $training)
                                            <option value="{{ $training->id }}" {{ old('training_id', $apprentice->training_id) == $training->id ? 'selected' : '' }}>
                                                {{ $training->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-content">
                                    <label for="payment_status">Payment Status</label>
                                    <input type="text" name="payment_status" id="payment_status" value="{{ old('payment_status', $apprentice->payment_status)}}" placeholder="Ex. Completed, Pending">
                                </div>
                            </div>

                            <div class="form-group payment">
                                <label for="payment_method" style="font-weight: bold;">Payment Method</label>
                                <div class="payment-options">
                                    <label>
                                        <input type="radio" name="payment_method" value="cash" {{ old('payment_method', $apprentice->payment_method) == 'cash' ? 'checked' : '' }} required> Cash
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="gcash" {{ old('payment_method', $apprentice->payment_method) == 'gcash' ? 'checked' : '' }} required> GCash
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="card" {{ old('payment_method', $apprentice->payment_method) == 'card' ? 'checked' : '' }} required> Card
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="other" id="other-payment" {{ old('payment_method', $apprentice->payment_method) == 'other' ? 'checked' : '' }} required> Other
                                    </label>

                                    <div id="other-payment-method" style="{{ old('payment_method', $apprentice->payment_method) == 'other' ? 'display:block;' : 'display:none;' }}">
                                        <input type="text" name="other_payment_method" value="{{ old('other_payment_method', $apprentice->other_payment_method) }}" placeholder="Please specify" {{ old('payment_method', $apprentice->payment_method) == 'other' ? 'required' : '' }}>
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