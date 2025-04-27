@extends('layouts.UserDesign')

@section('title', 'Training - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/class.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
    <!-- Design -->
    <style>
        .main-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            padding: 0 0 10px;
        }

        .form-group {
            padding: 0;
        }
    </style>

    <!-- Structure -->
    <div class="user-content-container">
        <div class="user-content-header">

            <h3>Personal Trainings</h3>

            <div class="user-content-button">
                <a href="#" id="openModalButton"><i class="fa-solid fa-file-pen"></i><span>Enroll Now</span></a>
            </div>

            <div class="user-content-button-history">
                <a href="#" id="openHistoryModalButton"><i class="fa-solid fa-clock-rotate-left"></i></a>
            </div>
        </div>
        <div class="user-main-content">
            <div class="main-section">
                @if($apprentices->isEmpty())
                    @if($trainings->isEmpty())
                        <p>No personal training available.</p>
                    @else
                        <div class="class-list">
                            @foreach($trainings as $training)
                                <div class="class-item">
                                    <div class="section-upper">
                                        <div class="section-upper-left">
                                            <h3>Coach {{ $training->trainer }}</h3>
                                            <p>Instructor</p>
                                        </div>
                                        <div class="section-upper-right">
                                            <h3>{{ $training->name }}</h3>
                                        </div>
                                    </div>
                                    <div class="section-middle">
                                        <h2>₱ {{ $training->price }}.00</h2>
                                        <p>{{ $training->description }}</p>
                                        <p>{{ $training->schedule }}</p>
                                    </div>
                                    <div class="section-bottom">
                                        <p>Status: {{ $training->status }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="students-list">
                        @foreach($apprentices as $apprentice)
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <h3>Training Enrollment</h3>
            <form action="{{ route('user.availTraining') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="form-content">
                        <label for="training">Training Name</label>
                        <select name="training" id="training" required>
                            <option value="" disabled selected>-Select Training-</option>
                            @foreach( $trainings as $training)
                                <option value="{{ $training->id }}">{{ $training->name }} Class for {{ $training->price  }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group payment">
                    <label for="payment_method" style="font-weight: bold;">Payment Method</label>
                    <div class="payment-options">
                        <label>
                            <input type="radio" name="payment_method" value="cash" required checked> Cash
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="gcash" required> GCash
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="card" required> Card
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="other" id="other-payment"> Other
                        </label>

                        <div id="other-payment-method" style="display:none;">
                            <input type="text" name="other_payment_method" placeholder="Please specify">
                        </div>
                    </div>
                </div>

                <script>
                    document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
                        radio.addEventListener('change', function() {
                            if (document.getElementById('other-payment').checked) {
                                document.getElementById('other-payment-method').style.display = 'block';
                                document.querySelector('input[name="other_payment_method"]').setAttribute('required', 'required');
                            } else {
                                document.getElementById('other-payment-method').style.display = 'none';
                                document.querySelector('input[name="other_payment_method"]').removeAttribute('required');
                            }
                        });
                    });
                </script>

                <div class="form-buttons">
                    <button type="button" class="cancel" id="cancelModalButton">Cancel</button>
                    <button type="submit" class="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="historyModal" class="modal-history">
        <div class="modal-history-header">
            <button id="closeHistoryModalButton"><ion-icon name="arrow-back-sharp"></ion-icon>Back</button>
        </div>
        <div class="modal-history-content">
            <h3>Training History</h3>
        </div>
    </div>

    <!-- Structure -->
    <script>
        const openModalButton = document.getElementById('openModalButton');
        const cancelModalButton = document.getElementById('cancelModalButton');
        const modal = document.getElementById('modal');

        const openHistoryModalButton = document.getElementById('openHistoryModalButton');
        const closeHistoryModalButton = document.getElementById('closeHistoryModalButton');
        const historyModal = document.getElementById('historyModal');

        const openModal = () => modal.style.display = 'block';
        const closeModal = () => modal.style.display = 'none';
        const openHistoryModal = () => historyModal.style.display = 'block';
        const closeHistoryModal = () => historyModal.style.display = 'none';

        openModalButton.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });

        cancelModalButton.addEventListener('click', closeModal);

        openHistoryModalButton.addEventListener('click', (e) => {
            e.preventDefault();
            openHistoryModal();
        });

        closeHistoryModalButton.addEventListener('click', closeHistoryModal);

        window.addEventListener('click', (e) => {
            if (e.target === reservationModal) {
                closeModal();
            } else if (e.target === historyModal) {
                closeHistoryModal();
            }
        });
    </script>
@endsection

@section('js-container')
    <!-- Backup Js -->
@endsection