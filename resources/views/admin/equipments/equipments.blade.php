@extends('layouts.AdminLayout')

@section('title', 'Equipments')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/equipments.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>List of Equipments</h2>
            <div class="page-button">
                <a href="{{ route('equipment.create')}}"><ion-icon name="add-sharp"></ion-icon>Add New Equipment</a>
            </div>
        </div>
        <div class="page-content">
            <div class="list-container">
                @foreach ($equipments as $equipment)
                    <div class="list-content">
                        <div class="equipment-info-header">
                            <p>{{ $loop->iteration }}. {{ $equipment->name }} x{{ $equipment->available_number }}</p>
                        </div>
                        <div class="equipment-info-container">
                            <div class="equipment-image">
                                <img src="{{ asset('storage/' . $equipment->image) }}" alt="Equipment Image">
                            </div>
                            <div class="equipment-info">
                                <p><b>Description:</b> {{ $equipment->description ?? 'No description' }}</p>
                                <p><b>Guide:</b> {{ $equipment->guide ?? 'No guide available' }}</p>
                            </div>
                        </div>
                        <div class="action-buttons equipments">
                            <a href="{{route('equipment.edit', ['equipment' => $equipment])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i><p>Edit</p></a>
                            <form method="post" action="{{route('equipment.destroy', ['equipment' => $equipment])}}">
                                @csrf 
                                @method('delete')
                                <button type="submit" class="delete-button">
                                    <i class="fa-solid fa-trash"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection