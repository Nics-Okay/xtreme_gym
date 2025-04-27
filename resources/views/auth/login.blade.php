@extends('layouts.auth')

@section('title', 'Login- Xtreme Gym World')

@section('main-content')
    <div class="main-content">
        <h1 class="auth-title login">Sign in to Xtreme</h1>

        <form method="post" action="{{ route('login') }}">
            @csrf
            @method('post')

            <div class="auth-fields email" id="login-email">
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus/>
                <x-input-error :messages="$errors->get('email')" class="error email" />
            </div>

            <div class="auth-fields password" id="login-pass">
                <input id="password" type="password" name="password" placeholder="Password" required/>
                <button type="button" id="toggle-password" class="toggle-password">
                    <i class="fas fa-eye-slash" id="toggle-password-icon"></i>
                </button>
                <x-input-error :messages="$errors->get('password')" class="error password" />
            </div>

            <div class="auth-fields remember" id="login-remember">
                <label for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                <div class="auth-help forgot">
                    <a href="{{ route('password.request') }}" id="auth-help ref">Forgot Password?</a>
                </div>
            </div>

            <div class="auth-button login">
                <button type="submit" id="main-button" class="primary-button">Sign In</button>
            </div>
        </form>

        <div class="auth-help x-auth">
            <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
        </div>
    </div>
    <script src="{{ asset('js/password.js') }}"></script>
@endsection
