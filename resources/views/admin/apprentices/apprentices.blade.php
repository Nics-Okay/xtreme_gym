@extends('layouts.AdminLayout')

@section('title', 'Apprentices - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Personal Training Apprentices</h2>
            <div class="page-button">
                <a href="{{ route('apprentice.create') }}"><ion-icon name="add-outline"></ion-icon>Add New Apprentice</a>
            </div>
        </div>
        <div class="page-content">
            
        </div>
    </div>
@endsection