@extends('layouts.auth')

@section('title', 'GYMXTREME - Login')

@section('main-content')
    <div class="main-content">

        <h1 class="auth-title signup">Create an account</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="auth-fields name">
                <div class="input-field first_name">
                    <input id="register-input first-name" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required autofocus/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="input-field last_name">
                    <input id="register-input last-name" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div class="auth-fields email">
                <input id="register-input email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="auth-fields password">
                <input id="register-input password" type="password" name="password" placeholder="Create Password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="auth-fields password-confirmation">
                <input id="register-input password-confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="auth-button signup">
                <button type="submit" id="main-button" class="primary-button">Sign Up</button>
            </div>
        </form>

        <div class="auth-help x-auth">
            <p>Alredy Have an Account? <a href="{{ route('login') }}">Log in</a></p>
        </div>
    </div>
@endsection
