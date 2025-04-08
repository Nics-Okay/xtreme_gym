@extends('layouts.auth')

@section('title', 'GYMXTREME - Login')

@section('main-content')
<style>
    .header {
        display: flex;
    }
</style>
<div class="main-content">
    <div class="otp-container">
        <div class="otp-title">Check your email</div>
        <p>We sent a 6-digit authentication code to your email address. This code is valid for the next 5 minutes.</p>

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            
            <div class="otp-inputs">
                <input type="text" maxlength="1" class="otp-box" oninput="moveNext(this, 1)" onkeydown="moveBack(event, this, 0)">
                <input type="text" maxlength="1" class="otp-box" oninput="moveNext(this, 2)" onkeydown="moveBack(event, this, 1)">
                <input type="text" maxlength="1" class="otp-box" oninput="moveNext(this, 3)" onkeydown="moveBack(event, this, 2)">
                <input type="text" maxlength="1" class="otp-box" oninput="moveNext(this, 4)" onkeydown="moveBack(event, this, 3)">
                <input type="text" maxlength="1" class="otp-box" oninput="moveNext(this, 5)" onkeydown="moveBack(event, this, 4)">
                <input type="text" maxlength="1" class="otp-box" oninput="combineOTP()" onkeydown="moveBack(event, this, 5)">
            </div>

            <input type="hidden" name="otp_code" id="otp_code">
            <x-input-error :messages="$errors->get('otp_code')" class="mt-2" />

            <div class="otp-button verify">
                <button type="submit" class="btn btn-primary">Verify</button>
            </div>
        </form>

        <div class="otp-button resend">
            <a href="{{ route('otp.resend') }}" class="btn btn-link">Resend OTP</a>
        </div>
    </div>
</div>

<script>
    function moveNext(input, index) {
        if (input.value.length === 1) {
            let nextInput = document.getElementsByClassName('otp-box')[index];
            if (nextInput) nextInput.focus();
        }
        combineOTP();
    }

    function moveBack(event, input, index) {
        if (event.key === "Backspace" && input.value === "") {
            let prevInput = document.getElementsByClassName('otp-box')[index - 1];
            if (prevInput) {
                prevInput.focus();
                prevInput.value = ""; // Clear previous input
            }
            combineOTP();
        }
    }

    function combineOTP() {
        let otp = "";
        let inputs = document.getElementsByClassName('otp-box');
        for (let input of inputs) {
            otp += input.value;
        }
        document.getElementById('otp_code').value = otp;
    }
</script>
@endsection