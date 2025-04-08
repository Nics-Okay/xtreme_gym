@extends('layouts.AdminLayout')

@section('title', 'Equipments')

@section('header-title', 'Membership Plans')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/admin/rates.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="crud-container">
        <div class="crud-section return">
            <a href="{{ route('equipment.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <p>Back</p>
            </a>
        </div>
        <div class="universal-div">
            <div class="universal-div-main">
                <h3 class="universal-div-header">Add New Equipment</h3>
                <div>
                    @if(session()->has('success'))
                        <div>
                            {{session('success')}}
                        </div>
                    @endif
                </div>
                <div class="universal-div-content">
                    <form method="post" action="{{ route('equipment.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="label">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Name" required autofocus>
                        </div>
                        <div class="label">
                            <label for="available_number">Available Number:</label>
                            <input type="number" name="available_number" id="available_number" min="1" value="1" required>
                        </div>
                        <div class="label">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="label">
                            <label for="guide">Guide:</label>
                            <textarea name="guide" id="guide">{{ old('guide') }}</textarea>
                        </div>

                        <div class="label">
                            <label for="image">Upload Image:</label>
                            <input type="file" name="image" id="image" accept="image/*">
                        </div>
                        <div class="submit-button">
                            <input type="submit" value="Confirm">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection