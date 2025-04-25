@extends('layouts.auth')

@section('title', 'Xtreme Gym World - Forgot Password')

@section('main-content')
    <div class="main-content">

        <h1 class="auth-title forgot">Reset Password</h1>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="auth-fields forgot">
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus/>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="auth-button forgot">
                <button type="submit" id="main-button" class="primary-button">Send Reset Link</button>
            </div>
        </form>
    </div>
@endsection
