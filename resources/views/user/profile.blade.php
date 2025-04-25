@extends('layouts.UserLayout')

@section('title', 'Profile - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Profile Management</h2>
        </div>
        <div class="page-content">
            <div class="profile-container">
                <div class="profile-content" style="width: 75%; height: 90%;">
                    <div class="image-container">
                        <p>Profile Picture</p>
                        <div class="image-holder">
                            <img 
                                id="profile-image-preview"
                                src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/profile-placeholder.png') }}" 
                                alt="Profile Image">
                        </div>

                        <form method="POST" action="{{ route('profileNew.updateImage') }}" enctype="multipart/form-data">
                            @csrf
                            <input 
                                type="file" 
                                name="profile_image" 
                                accept="image/*" 
                                style="display: none;" 
                                id="profile-image-upload" 
                                onchange="previewSelectedImage(event)">
                            <button type="button" onclick="document.getElementById('profile-image-upload').click()">Upload New Image</button>
                            <button type="submit">Save</button>
                        </form>

                        <script>
                            function previewSelectedImage(event) {
                                const file = event.target.files[0]; // Get the selected file
                                const preview = document.getElementById('profile-image-preview');

                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function (e) {
                                        // Update the `src` of the image with the selected file's data URL
                                        preview.src = e.target.result;
                                    };
                                    reader.readAsDataURL(file); // Read the file as a data URL
                                }
                            }
                        </script>
                    </div>
                    <div class="profile-info">
                        <p>Profile Information</p>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profileNew.update') }}">
                            @csrf
                            @method('patch')

                            <div class="form-group" style="margin-right : -10px;">
                                <div class="form-content">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autofocus autocomplete="first_name">
                                    @if ($errors->has('first_name'))
                                        <div>
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-content">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                    @if ($errors->has('email'))
                                        <div>
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div>
                                            <p>Your email address is unverified.</p>

                                            <button form="send-verification">
                                                Click here to re-send the verification email.
                                            </button>

                                            @if (session('status') === 'verification-link-sent')
                                                <p>A new verification link has been sent to your email address.</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="save-button">Save</button>

                                @if (session('status') === 'profile-updated')
                                    <p>Saved.</p>
                                @endif
                            </div>
                        </form>

                        <header>
                            <p>Update Password</p>
                            <p>Use a strong, random password to keep your account secure.</p>
                        </header>

                        <form method="post" action="{{ route('profileNew.updatePassword') }}">
                            @csrf
                            @method('put')

                            <div class="form-full">
                                <label for="update_password_current_password">Current Password</label>
                                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
                                @if ($errors->updatePassword->has('current_password'))
                                    <div>
                                        <strong>{{ $errors->updatePassword->first('current_password') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-full">
                                <label for="update_password_password">New Password</label>
                                <input id="update_password_password" name="password" type="password" autocomplete="new-password">
                                @if ($errors->updatePassword->has('password'))
                                    <div>
                                        <strong>{{ $errors->updatePassword->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-full">
                                <label for="update_password_password_confirmation">Confirm Password</label>
                                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                                @if ($errors->updatePassword->has('password_confirmation'))
                                    <div>
                                        <strong>{{ $errors->updatePassword->first('password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <button type="submit" class="save-button">Save</button>
                                @if (session('status') === 'password-updated')
                                    <p>Saved.</p>
                                @endif
                            </div>
                        </form>

                        <header>
                            <p>Delete Account</p>
                            <p style="padding: 0 0 5px;">
                                Deleting your account will permanently erase all data. Download any needed information first.
                            </p>
                        </header>
                        
                        <button id="openModalButton" class="delete-button">
                            Delete Account
                        </button>

                        <div id="modal" class="modal hidden">
                            <div class="modal-content">
                                <h2>Are you sure you want to delete your account?</h2>
                                <p>
                                    Once deleted, all your account data will be permanently removed. Enter your password to confirm.
                                </p>

                                <form method="post" action="/profile/delete">
                                    <input type="password" name="password" placeholder="Password" required>
                                    <div class="modal-actions">
                                        <button type="button" id="cancelButton" class="cancel-button">Cancel</button>
                                        <button type="submit" class="delete-button">Delete Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            const openModalButton = document.getElementById('openModalButton');
                            const modal = document.getElementById('modal');
                            const cancelButton = document.getElementById('cancelButton');

                            openModalButton.addEventListener('click', () => {
                                modal.classList.remove('hidden');
                            });

                            cancelButton.addEventListener('click', () => {
                                modal.classList.add('hidden');
                            });

                            window.addEventListener('keydown', (event) => {
                                if (event.key === 'Escape') {
                                    modal.classList.add('hidden');
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection