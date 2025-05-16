@extends('layouts.UserDesign')

@section('title', 'Profile - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/profile.css') }}">
@endsection

@section('main-content')
    <!-- Design -->
    <style>
        .main-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            row-gap: 15px;
            height: 100%;
            width: 100%;
            padding: 0 10px 10px;
        }
    </style>

    <!-- Structure -->
    <div class="user-content-container">
        <div class="user-content-header">
            <div class="custom-header">
                <a href="{{ route('user.settings')}}"><i class="fa-solid fa-arrow-left"></i></a>
                <h3>Profile Management</h3> 
            </div>
        </div>
        <div class="user-main-content">
            <div class="main-section">
                <div class="profile-section-one">
                    <div class="image-holder">
                        <img 
                            id="profile-image-preview"
                            src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/profile-placeholder.png') }}" 
                            alt="Profile Image">
                    </div>
                    <h3>{{ $user->first_name ?? ' '}} {{ $user->last_name ?? ' '}}</h3>
                    <p style="font-size: small;">ID: {{ $user->unique_id}}</p>
                    <button id="openModalThreeBtn" class="edit-profile"><i class="fa-solid fa-user-edit"></i> Update Profile</button>
                </div>
                <div class="profile-section-two">
                    <button id="openModalOneBtn"><i class="fa-solid fa-lock"></i> Change Password</button>
                    <button id="openModalTwoBtn"><i class="fa-solid fa-trash-can"></i> Delete Account</button>
                    @if ($errors->userDeletion->has('password'))
                        <div class="error-message" style="color: red;">
                            {{ $errors->userDeletion->first('password') }}
                        </div>
                    @endif
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
                    <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" minlength="8" placeholder="Enter current password" required>
                </div>

                <div class="form-full" style="width: 100%;">
                    <label for="update_password_password">New Password</label>
                    <input id="update_password_password" name="password" type="password" autocomplete="new-password" minlength="8" placeholder="Enter new password" required>
                </div>

                <div class="form-full" style="width: 100%;">
                    <label for="update_password_password_confirmation">Confirm Password</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" placeholder="Confirm new password" required>
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
            <form method="post" action="{{ route('profileNew.destroy') }}">
                @csrf 
                @method('delete')
                <input type="password" name="password" minlength="8" placeholder="Enter password to continue..." required>
                <div class="modal-actions">
                    <button type="button" id="closeModalTwoBtn" class="pe-cancel-button">Close</button>
                    <button type="submit" class="delete-button">Delete Account</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="pe-modal-three">
        <div class="modal-content pe-profile-image-modal">

            <button type="button" id="closeModalThreeBtn" class="pe-modal-three-close-button">
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
            });
        });
    </script>
@endsection

@section('js-container')
    <!-- Backup Js -->
@endsection