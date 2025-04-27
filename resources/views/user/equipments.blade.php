@extends('layouts.UserDesign')

@section('title', 'Gym Equipments - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
@endsection

@section('main-content')
    <style>
        .equipments-container {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            gap: 20px;
            row-gap: 30px;
            height: 100%;
            width: 100%;
            padding-bottom: 20px;
            overflow-y: auto;
        }

        .equipments-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            row-gap: 15px;
            height: fit-content;
            width: 20%;
            padding: 20px 10px;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            background-color: white;
        }

        .equipments-image-holder {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
            aspect-ratio: 1/1;
            overflow: hidden;
        }

        .equipments-image-holder img {
            height: 100%;
            aspect-ratio: 1/1;
        }

        .equipments-item button {
            padding: 8px 15px;
            color: white;
            border: none;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            background-color: rgba(28, 37, 54);
        }

        .equipment-modal-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 5000;
        }

        .equipment-modal-background.hidden {
            display: none;
        }

        .equipment-modal {
            background: white;
            border-radius: 8px;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .equipment-modal h4 {
            margin-top: 5px;
        }

        .equipment-modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        @media (max-width: 639px) {
            .equipments-container {
                display: flex;
                justify-content: space-evenly;
                flex-wrap: wrap;
                gap: 0px;
                row-gap: 30px;
            }

            .equipments-item {
                width: 40%;
                border-radius: 8px;
            }

            .equipments-item button {
                padding: 4px 10px;
            }
        }
    </style>
    <div class="user-content-container">
        <div class="user-content-header">
            <div class="custom-header">
                <a href="{{ route('user.settings')}}"><i class="fa-solid fa-arrow-left"></i></a>
                <h3>Gym Equipments</h3> 
            </div>
        </div>
        <div class="user-main-content">
            <div class="main-section">
                <div class="equipments-container">
                    @foreach ($equipments as $equipment)
                        <div class="equipments-item">
                            <div class="equipments-image-holder">
                                <img src="{{ asset('storage/' . $equipment->image) }}" alt="Equipment Image">
                            </div>
                            <button class="equipment-view-details-btn" data-id="{{ $equipment->id }}">View Details</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="equipment-modal-background" class="equipment-modal-background hidden">
        <div class="equipment-modal">
            <button class="equipment-modal-close">
                <i class="fas fa-times"></i>
            </button>
            <h2 id="modal-equipment-name"></h2>
            <h4>Description:</h4>
            <p id="modal-equipment-description"></p>
            <h4>Guide:</h4>
            <p id="modal-equipment-guide"></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalBackground = document.getElementById('equipment-modal-background');
            const modalCloseButton = document.querySelector('.equipment-modal-close');
            const modalName = document.getElementById('modal-equipment-name');
            const modalDescription = document.getElementById('modal-equipment-description');
            const modalGuide = document.getElementById('modal-equipment-guide');

            const viewDetailsButtons = document.querySelectorAll('.equipment-view-details-btn');

            viewDetailsButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const equipmentId = button.dataset.id;
                    const equipment = @json($equipments).find(item => item.id == equipmentId);

                    // Set modal content dynamically
                    modalName.textContent = equipment.name;
                    modalDescription.textContent = equipment.description ?? 'No description';
                    modalGuide.textContent = equipment.guide ?? 'No guide available';

                    // Show modal
                    modalBackground.style.display = 'flex';
                });
            });

            modalCloseButton.addEventListener('click', () => {
                modalBackground.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === modalBackground) {
                    modalBackground.style.display = 'none';
                }
            });
        });
    </script>
@endsection