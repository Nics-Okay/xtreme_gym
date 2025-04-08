@extends('layouts.auth')

@section('title', 'GYMXTREME - Login')

@section('main-content')
    <div class="main-content">
        <h3 class="verify h3">Email Verification</h3>
        <p class="verify p">
            Your account <b>{{ $email }}</b> has been successfully registered. Please verify your email to continue.
        <p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="verify container">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div class="verify button-resend">
                    <button type="submit" id="main-button" class="primary-button">Resend Email</button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" id="main-button" class="primary-button log-out">Log out</button>
            </form>
        </div>
    </div>
@endsection
