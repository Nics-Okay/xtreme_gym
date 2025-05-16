@extends('layouts.AdminLayout')

@section('title', 'Tournaments - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/tournaments.css') }}">
@endsection

@section('main-content')
<div class="content">
    <div class="page-header">
        <h2>Tournaments List</h2>
        <div class="page-button">
            <a href="{{ route('tournaments.create') }}">
                <ion-icon name="add-sharp"></ion-icon>Create Tournament
            </a>
        </div>
    </div>
    <div class="page-content">
        <div class="tournament-container">
            @foreach($tournaments as $index => $tournament)
                <div class="tournament-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <h3>{{ $tournament->name }}</h3>
                    <p><strong>Tournament Type:</strong> {{ $tournament->type }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($tournament->tournament_date)->format('F j, Y') }}</p>
                    <p><strong>Participation Fee:</strong> ₱{{ number_format($tournament->registration_fee, 2) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($tournament->status) }}</p>
                    <p><strong>Registration Period:</strong> 
                    {{ $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') : 'N/A' }} - 
                    {{ $tournament->end_date ? \Carbon\Carbon::parse($tournament->end_date)->format('F j, Y') : 'N/A' }}</p>
                    <p><strong>Description:</strong> {{ $tournament->description }}</p>
                    <div class="prizes">
                        <p><ion-icon name="trophy-outline"></ion-icon> 1st: ₱{{ $tournament->first_prize }}</p>
                        <p><ion-icon name="medal-outline"></ion-icon> 2nd: ₱{{ $tournament->second_prize }}</p>
                        <p><ion-icon name="medal-outline"></ion-icon> 3rd: ₱{{ $tournament->third_prize }}</p>
                    </div>

                    <div class="participants-list">
                        <h4>List of Participants</h4>
                        @if($tournament->participants->isEmpty())
                            <p>No participants yet.</p>
                        @else
                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>ID</th>
                                        <th>Registration Time</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tournament->participants as $participant)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $participant->participant_name }}</td>
                                            <td>{{ $participant->user_id ? 'ID: ' . $participant->user_id : 'Guest' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($participant->created_at)->format('F j, Y g:i A') }}</td>
                                            <td>{{ $participant->contact_details }}</td>
                                            <td>
                                                <div class="action-button">
                                                    <a href="{{route('participant.edit', ['participant' => $participant])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <form method="post" action="{{route('participant.destroy', ['participant' => $participant])}}">
                                                        @csrf 
                                                        @method('delete')
                                                        <button type="submit" class="delete-button" style="background: none; border: none; cursor: pointer; margin-top: 3px;">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <div class="ts-action-button">
                        <a href="{{ route('tournaments.edit', ['tournament' => $tournament]) }}" class="ts-edit-button">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('tournaments.destroy', ['tournament' => $tournament]) }}" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ts-delete-button" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('participant.create', ['tournament' => $tournament])}}" class="ts-add-participant">
                        <i class="fa-solid fa-plus"></i> Add Participant
                    </a>
                </div>
            @endforeach
        </div>
        <div class="pagination-buttons">
            <button id="prev-button" disabled>
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button id="next-button">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const items = document.querySelectorAll('.tournament-item');
        const prevBtn = document.getElementById('prev-button');
        const nextBtn = document.getElementById('next-button');
        let currentIndex = 0;

        function updateView() {
            items.forEach((item, i) => {
                item.classList.toggle('active', i === currentIndex);
            });
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex === items.length - 1;
        }

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateView();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentIndex < items.length - 1) {
                currentIndex++;
                updateView();
            }
        });

        updateView();
    });
</script>
@endsection
