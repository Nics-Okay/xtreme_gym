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
        @if(session('success'))
            <script>
                window.onload = function() {
                    let message = "{{ session('success') }}";
                    let alertBox = document.createElement('div');
                    alertBox.textContent = message;
                    
                    // Styling
                    alertBox.style.position = 'fixed';
                    alertBox.style.bottom = '30px'; /* Position near bottom */
                    alertBox.style.right = '-300px'; /* Start off-screen */
                    alertBox.style.backgroundColor = '#4CAF50';
                    alertBox.style.color = 'white';
                    alertBox.style.padding = '15px 20px';
                    alertBox.style.borderRadius = '8px';
                    alertBox.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';
                    alertBox.style.zIndex = '1000';
                    alertBox.style.fontSize = '14px';
                    alertBox.style.fontWeight = 'bold';
                    alertBox.style.textAlign = 'center';
                    alertBox.style.minWidth = '220px';
                    alertBox.style.maxWidth = '300px';
                    alertBox.style.transition = 'right 0.5s ease-out, opacity 0.5s ease-in-out';

                    document.body.appendChild(alertBox);

                    // Slide in animation
                    setTimeout(() => {
                        alertBox.style.right = '10px';
                    }, 100);

                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        alertBox.style.opacity = '0';
                        setTimeout(() => alertBox.remove(), 500);
                    }, 3000);
                };
            </script>
        @endif

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