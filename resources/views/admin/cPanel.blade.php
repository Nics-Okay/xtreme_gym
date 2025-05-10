@extends('layouts.AdminLayout')

@section('title', 'Control Panel - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/cpanel.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Welcome to Control Panel</h2> 
        </div>
        <div class="page-content">
            <div class="admin-lock-section">
                <form method="POST" action="{{ route('admin.update-lock-code') }}">
                    @csrf
                    <input type="password" name="current_pin" placeholder="Current PIN" nullable>
                    <input type="password" name="new_pin" placeholder="New PIN" required>
                    <input type="password" name="new_pin_confirmation" placeholder="Confirm New PIN" required>
                    <button type="submit">Update Lock Code</button>
                </form>
            </div>
            <div class="carousel-settings-section">
                <h3>Carousel Image Management</h3>
                <form method="POST" action="{{ route('admin.carousel.store') }}" enctype="multipart/form-data">
                    @csrf
                    <label for="carousel_image">Upload Carousel Image:</label>
                    <input type="file" name="carousel_image" id="carousel_image" required>
                    <button type="submit">Upload</button>
                </form>

                <h4>Uploaded Images</h4>
                <ul id="carousel-images-list">
                    @forelse ($carouselImages as $image)
                        <li>
                            <img src="{{ asset('storage/carousel/' . $image->filename) }}" alt="Carousel Image" width="100">
                            <form method="POST" action="{{ route('admin.carousel.delete', $image->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </li>
                    @empty
                        <li>No images uploaded yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection