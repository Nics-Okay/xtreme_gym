@extends('layouts.AdminLayout')

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
                <div class="profile-content">
                    <div class="image-container">
                        <p>Admin Profile</p>

                        <div class="image-holder">
                            <div class="image-content">
                                <img id="profile-image-preview" src="{{ asset('storage/' . $user->image) }}" alt="Profile Image">
                            </div>

                            <button id="openModalThreeBtn" class="edit-button"><i class="fa-solid fa-pencil"></i></button>
                        </div>

                        <h3>{{ $user->first_name ?? ''}} {{ $user->last_name ?? ''}}</h3>
                    </div>
                    <div class="profile-info">
                        <p>Profile Information
                            <button id="openModalFourBtn" class="edit-profile-button">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </p>
                        <div class="form-group" style="padding: 0;">
                            <div class="form-content">
                                <label>ID</label>
                                <input value="{{ $user->unique_id }}" disabled>
                            </div>
                            <div class="form-content">
                                <label>Email</label>
                                <input value="{{ $user->email }}" disabled>
                            </div>
                        </div>

                        <div class="form-group" style="padding: 0;">
                            <div class="form-content">
                                <label>First Name</label>
                                <input value="{{ $user->first_name }}">
                            </div>
                            <div class="form-content">
                                <label>Last Name</label>
                                <input value="{{ $user->last_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="pe-buttons">
                        <p>Admin Settings</p>
                        <button id="openModalOneBtn"><i class="fa-solid fa-lock"></i>Change Password</button>
                        <button id="openModalTwoBtn"><i class="fa-solid fa-trash-can"></i>Account Deletion</button>
                    </div>

                    <p style="font-size: small;"><i>Xtreme Gym World Baliuag</i></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="pe-modal-one">
        <div class="modal-content">
            <h3>Change Password</h3>
            <form method="post" action="{{ route('profileNew.updatePassword') }}">
                @csrf
                @method('put')

                <div class="form-full" style="width: 100%;">
                    <label for="update_password_current_password">Current Password</label>
                    <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" placeholder="Enter current password" required>
                    @if ($errors->updatePassword->has('current_password'))
                        <div>
                            <strong>{{ $errors->updatePassword->first('current_password') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-full" style="width: 100%;">
                    <label for="update_password_password">New Password</label>
                    <input id="update_password_password" name="password" type="password" autocomplete="new-password" placeholder="Enter new password" required>
                    @if ($errors->updatePassword->has('password'))
                        <div>
                            <strong>{{ $errors->updatePassword->first('password') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-full" style="width: 100%;">
                    <label for="update_password_password_confirmation">Confirm Password</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="Confirm new password" required>
                    @if ($errors->updatePassword->has('password_confirmation'))
                        <div>
                            <strong>{{ $errors->updatePassword->first('password_confirmation') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="modal-actions">
                    <button type="button" id="closeModalOneBtn" class="pe-cancel-button">Close</button>
                    <button type="submit" class="pe-submit-button">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="pe-modal-two">
        <div class="modal-content pe-two">
            <h3>Account Deletion</h3>
            <p style="align-self: center;">Deleting your account will permanently erase all data.</p>
            <form method="post" action="/profile/delete">
                <input type="password" name="password" placeholder="Enter password to continue..." required>
                <div class="modal-actions">
                    <button type="button" id="closeModalTwoBtn" class="pe-cancel-button">Close</button>
                    <button type="submit" class="delete-button">Delete Account</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="pe-modal-three">
        <div class="modal-content pe-profile-image-modal">

            <button type="button" class="pe-modal-three-close-button" onclick="closeModalThreeBtn()">
                <i class="fas fa-times"></i>
            </button>

            <h3>Change Profile Image</h3>
            <div class="pe-preview-image-holder">
                <img 
                    id="pe-modal-profile-image-preview"
                    src="{{ asset('storage/' . $user->image) }}"
                    alt="Profile Image">
            </div>

            <form method="POST" action="{{ route('profileNew.updateImage') }}" enctype="multipart/form-data">
                @csrf
                <input 
                    type="file" 
                    name="profile_image" 
                    style="display: none;" 
                    id="profile-image-upload" 
                    onchange="previewSelectedImage(event)">
                <div class="modal-actions">
                    <button type="button" onclick="document.getElementById('profile-image-upload').click()">Upload New Image</button>
                    <button type="submit" class="pe-submit-button">Save</button>
                </div>
            </form>

            <script>
                function previewSelectedImage(event) {
                    const file = event.target.files[0]; // Get the selected file
                    const preview = document.getElementById('pe-modal-profile-image-preview');

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
    </div>

    <div class="modal" id="pe-modal-four">
        <div class="modal-content">
            <h3>Change Account Information</h3>

            <form method="post" action="{{ route('profileNew.update') }}">
                @csrf
                @method('patch')

                <div class="form-full" style="width: 100%;">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" placeholder="Enter new email address" required autofocus>
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

                <div class="form-group" style="padding: 0;">
                    <div class="form-content">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Enter First Name" required>
                    </div>
                    <div class="form-content">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Enter Last Name" required>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" id="closeModalFourBtn" class="pe-cancel-button">Close</button>
                    <button type="submit" class="pe-submit-button">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openModalOneBtn = document.getElementById('openModalOneBtn');
            const closeModalOneBtn = document.getElementById('closeModalOneBtn');
            const modalOne = document.getElementById('pe-modal-one');

            const openModalTwoBtn = document.getElementById('openModalTwoBtn');
            const closeModalTwoBtn = document.getElementById('closeModalTwoBtn');
            const modalTwo = document.getElementById('pe-modal-two');

            const openModalThreeBtn = document.getElementById('openModalThreeBtn');
            const closeModalThreeBtn = document.getElementById('closeModalThreeBtn');
            const modalThree = document.getElementById('pe-modal-three');

            const openModalFourBtn = document.getElementById('openModalFourBtn');
            const closeModalFourBtn = document.getElementById('closeModalFourBtn');
            const modalFour = document.getElementById('pe-modal-four');

            openModalOneBtn.addEventListener('click', () => {
                modalOne.classList.add('active');
            });

            closeModalOneBtn.addEventListener('click', () => {
                modalOne.classList.remove('active');
            });

            openModalTwoBtn.addEventListener('click', () => {
                modalTwo.classList.add('active');
            });

            closeModalTwoBtn.addEventListener('click', () => {
                modalTwo.classList.remove('active');
            });

            openModalThreeBtn.addEventListener('click', () => {
                modalThree.classList.add('active');
            });

            closeModalThreeBtn.addEventListener('click', () => {
                modalThree.classList.remove('active');
            });

            openModalFourBtn.addEventListener('click', () => {
                modalFour.classList.add('active');
            });

            closeModalFourBtn.addEventListener('click', () => {
                modalFour.classList.remove('active');
            });

            window.addEventListener('click', (event) => {
                if (event.target === modalOne) {
                    modalOne.classList.remove('active');
                }
                if (event.target === modalTwo) {
                    modalTwo.classList.remove('active');
                }
                if (event.target === modalThree) {
                    modalThree.classList.remove('active');
                }
                if (event.target === modalFour) {
                    modalFour.classList.remove('active');
                }
            });
        });
    </script>
@endsection