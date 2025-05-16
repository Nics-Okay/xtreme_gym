@extends('layouts.UserDesign')

@section('title', 'Tournament - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/tournaments.css') }}">
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
            padding: 0 10px 10px;
        }
    </style>

    <!-- Structure -->
    <div class="user-content-container">
        <div class="user-content-header">

            <h3>Tournaments</h3>

            <div class="user-content-button">
                <a href="#" id="ts-openModalButton"><i class="fa-solid fa-file-pen"></i><span>Register Now</span></a>
            </div>

            <div class="user-content-button-history">
                <a href="#" id="ts-openHistoryModalButton"><i class="fa-solid fa-clock-rotate-left"></i></a>
            </div>
        </div>
        <div class="user-main-content">
            <div class="main-section">
                @if($tournaments->isEmpty())
                    <p>No tournaments available at the moment.</p>
                @else
                    <div class="tournament-list">
                        @foreach($tournaments as $tournament)
                            <div class="tournament-item">
                                <h4 style="width: 100%; text-align: center;">{{ $tournament->name }}</h4>
                                <p style="display: flex; justify-content: space-between; align-items: center;"><strong>Tournament Type:</strong> <span style="font-size: small;">{{ $tournament->type }}</span></p>
                                <p style="display: flex; justify-content: space-between; align-items: center;"><strong>Date:</strong> <span style="font-size: small;">{{ \Carbon\Carbon::parse($tournament->tournament_date)->format('F j, Y') }}</span></p>
                                <p style="display: flex; justify-content: space-between; align-items: center;"><strong>Participation Fee:</strong> <span style="font-size: small;">₱{{ number_format($tournament->registration_fee, 2) }}</span></p>
                                <p style="display: flex; justify-content: space-between; align-items: center;"><strong>Registration:</strong> 
                                <span style="font-size: small;">{{ $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') : 'N/A' }} - 
                                {{ $tournament->end_date ? \Carbon\Carbon::parse($tournament->end_date)->format('F j, Y') : 'N/A' }}</span></p>
                                <div class="prizes">
                                    <p><ion-icon name="trophy-outline"></ion-icon> 1st Prize: ₱{{ number_format($tournament->first_prize, 2) }}</p>
                                    <p><ion-icon name="medal-outline"></ion-icon> 2nd Prize: ₱{{ number_format($tournament->second_prize, 2) }}</p>
                                    <p><ion-icon name="medal-outline"></ion-icon> 3rd Prize: ₱{{ number_format($tournament->third_prize, 2) }}</p>
                                </div>
                                <div class="us-buttons">
                                    <a href="#" class="ts-participants-btn" data-tournament-id="{{ $tournament->id }}">
                                        <i class="fa-solid fa-users"></i> Participants
                                    </a>
                                    <a href="#" class="ts-openModalButtonTwo" data-tournament-id="{{ $tournament->id }}">
                                        <i class="fa-solid fa-file-pen"></i> Register Now
                                    </a>
                                </div>
                                <p style="width: 100%; text-align: center; font-size: small; padding: 5px 0 0;"><i>{{ $tournament->description }}</i></p>
                            </div>
                        @endforeach

                        <h4>Past Tournaments</h4>

                        @if($tournaments->where('tournament_date', '<', now())->isEmpty())
                            <p>No past tournaments.</p>
                        @else
                            @foreach($tournaments->where('tournament_date', '<', now()) as $tournament)
                                <div class="tournament-item">
                                    <h4>{{ $tournament->name }}</h4>
                                    <p>{{ $tournament->description }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="ts-modal" class="ts-modal">
        <div class="ts-modal-content">
            <h3 style="width: 100%; text-align:center;">Tournament Registration</h3>
            <form action="{{ route('user.registerTournament') }}" method="POST">
                @csrf
                <div class="form-group" style="padding: 0;">
                    <div class="form-content">
                        <label for="tournament">Tournament</label>
                        <select name="tournament" id="tournament" required>
                            <option value="" disabled selected>-Select Tournament-</option>
                            @foreach( $tournaments as $tournament)
                                <option value="{{ $tournament->id }}">
                                    {{ $tournament->name }} on {{ \Carbon\Carbon::parse($tournament->tournament_date)->format('F d, Y') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group payment" style="padding: 0;">
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
                    <button type="button" class="ts-cancel" id="ts-cancelModalButton">Cancel</button>
                    <button type="submit" class="ts-submit">Register</button>
                </div>
            </form>
        </div>
    </div>

    <div id="ts-historyModal" class="ts-modal-history">
        <div class="ts-modal-history-header">
            <button id="ts-closeHistoryModalButton"><ion-icon name="arrow-back-sharp"></ion-icon>Back</button>
        </div>
        <div class="ts-modal-history-content">
            <h3>Participation History</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <th style="padding: 8px;">#</th>
                        <th style="padding: 8px;">Tournament</th>
                        <th style="padding: 8px;">Registration Date</th>
                        <th style="padding: 8px;">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($participations->isEmpty())
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 8px;">No Participation History</td>
                        </tr>
                    @else
                        @foreach($participations as $participation)
                            <tr>
                                <td style="padding: 8px;">{{ $loop->iteration }}</td>
                                <td style="padding: 8px;">
                                    {{ $tournaments->firstWhere('id', $participation->tournament_id)->name ?? 'Unknown Tournament' }}
                                </td>
                                <td style="padding: 8px;">{{ \Carbon\Carbon::parse($participation->created_at)->format('F j, Y') }}</td>
                                <td style="padding: 8px;">{{ ucfirst($participation->payment_status) }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Participants Modal -->
    <div id="ts-participants-modal" class="ts-modal" style="display:none;">
        <div class="ts-participants-modal-content">
            <h3 style="text-align:center; margin-bottom: 10px;">Participants</h3>
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <th style="text-align:left; padding: 8px;">#</th>
                        <th style="text-align:left; padding: 8px;">Name</th>
                        <th style="text-align:left; padding: 8px;">Registration Date</th>
                    </tr>
                </thead>
                <tbody id="ts-participants-tbody">
                    @foreach($tournaments as $tournament)
                        <tr>
                            <td colspan="3" style="text-align:center; font-weight:bold; background-color:#f9f9f9;">
                                {{ $tournament->name }}
                            </td>
                        </tr>
                        @if($tournament->participants->isEmpty())
                            <tr>
                                <td colspan="3" style="text-align:center;">No participants found.</td>
                            </tr>
                        @else
                            @php $counter = 1; @endphp
                            @foreach($tournament->participants as $participant)
                            <tr>
                                <td style="padding: 8px;">{{ $counter++ }}</td>
                                <td style="padding: 8px;">{{ $participant->participant_name }}</td>
                                <td style="padding: 8px;">{{ $participant->created_at }}</td>
                            </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div style="text-align:center; margin-top: 15px;">
                <button id="ts-participants-close" class="ts-participants-modal-close"><i class="fa-solid fa-xmark" style="margin-right: 5px;"></i>Close Window</button>
            </div>
        </div>
    </div>

    <!-- Structure -->
    <script>
        const openModalButton = document.getElementById('ts-openModalButton');
        const openModalButtonsTwo = document.querySelectorAll('.ts-openModalButtonTwo');
        const cancelModalButton = document.getElementById('ts-cancelModalButton');
        const modal = document.getElementById('ts-modal');

        const openHistoryModalButton = document.getElementById('ts-openHistoryModalButton');
        const closeHistoryModalButton = document.getElementById('ts-closeHistoryModalButton');
        const historyModal = document.getElementById('ts-historyModal');

        const openModal = () => modal.style.display = 'block';
        const closeModal = () => modal.style.display = 'none';
        const openHistoryModal = () => historyModal.style.display = 'block';
        const closeHistoryModal = () => historyModal.style.display = 'none';

        openModalButton.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });

        openModalButtonsTwo.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                openModal();
            });
        });

        cancelModalButton.addEventListener('click', closeModal);

        openHistoryModalButton.addEventListener('click', (e) => {
            e.preventDefault();
            openHistoryModal();
        });

        closeHistoryModalButton.addEventListener('click', closeHistoryModal);

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            } else if (e.target === historyModal) {
                closeHistoryModal();
            }
        });
    </script>

    <script>
        document.querySelectorAll('.ts-participants-btn').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();

                const tournamentId = this.dataset.tournamentId;
                const modal = document.getElementById('ts-participants-modal');
                const tbody = document.getElementById('ts-participants-tbody');
                
                tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;">Loading...</td></tr>';
                modal.style.display = 'block';

                try {
                    const response = await fetch(`/tournaments/${tournamentId}/participants`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const participants = await response.json();

                    if (participants.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;">No participants found.</td></tr>';
                    } else {
                        let counter = 1;
                        tbody.innerHTML = participants.map(p => {
                            const date = new Date(p.created_at);
                            const formattedDate = date.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            return `
                                <tr>
                                    <td style="padding: 8px;">${counter++}</td>
                                    <td style="padding: 8px;">${p.participant_name}</td>
                                    <td style="padding: 8px;">${formattedDate}</td>
                                </tr>
                            `;
                        }).join('');
                    }
                } catch (error) {
                    tbody.innerHTML = `<tr><td colspan="3" style="text-align:center; color:red;">Error loading participants.</td></tr>`;

                    console.error('Fetch error:', error);
                }
            });
        });

        document.getElementById('ts-participants-close').addEventListener('click', function() {
            document.getElementById('ts-participants-modal').style.display = 'none';
        });

        // Close modal when clicking outside content
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('ts-participants-modal');
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
@endsection

@section('js-container')
    <!-- Backup Js -->
@endsection