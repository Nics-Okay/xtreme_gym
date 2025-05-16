@extends('layouts.AdminLayout')

@section('title', 'Tournament Results Management - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/universalCRUD.css') }}">
@endsection

@section('main-content')
<style>
    .crud-content {
        height: 60%;
    }
</style>
    <div class="content">
        <div class="page-header">
            <a href="{{ route('result.show') }}">
                <ion-icon name="arrow-back-sharp"></ion-icon>
                <h2>Back to Tournament Results List</h2>
            </a>
        </div>
        <div class="page-content">
            <div class="crud-container">
                <div class="crud-content">
                    <h3 class="crud-header">Edit Tournament Result</h3>
                    <div class="crud-form">
                        <form method="post" action="{{ route('result.update', ['result' => $result]) }}">
                            @csrf
                            @method('put')

                            <div class="form-full">
                                <div class="form-content">
                                    <label for="tournament_id">Tournament</label>
                                    <select name="tournament_id" id="tournament_id" required>
                                        <option value="" disabled {{ old('tournament_id', $result->tournament_id) ? '' : 'selected' }}>- Select Tournament -</option>
                                        @foreach ($tournaments as $tournament)
                                            <option value="{{ $tournament->id }}" {{ old('tournament_id', $result->tournament_id) == $tournament->id ? 'selected' : '' }}>
                                                {{ $tournament->name }} - {{ \Carbon\Carbon::parse($tournament->tournament_date)->format('F d, Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="remarks">Game Category</label>
                                    <input type="text" id="remarks" name="remarks" value="{{ old('remarks', $result->remarks) }}"  placeholder="Ex. Game 1, Semi-Finals" maxlength="255" required>
                                </div>
                                <div class="form-content">
                                    <label for="game_date">Game Date</label>
                                    <input type="date" id="game_date" name="game_date" value="{{ old('game_date', $result->game_date) }}"  onclick="this.showPicker()" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="winner_name">Winner Participant</label>
                                    <select name="winner_name" id="winner_name" required>
                                        <option value="" disabled {{ old('winner_name', $result->winner_name) ? '' : 'selected' }}>- Select Winner -</option>
                                        @foreach ($participants as $participant)
                                            <option value="{{ $participant->participant_name }}" {{ old('winner_name', $result->winner_name) == $participant->participant_name ? 'selected' : '' }}>
                                                {{ $participant->participant_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-content">
                                    <label for="winner_score">Winner Score</label>
                                    <input type="number" id="winner_score" name="winner_score" placeholder="Enter Winner Score" value="{{ old('winner_score', $result->winner_score) }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-content">
                                    <label for="defeated_name">Defeated Participant</label>
                                    <select name="defeated_name" id="defeated_name" required>
                                        <option value="" disabled {{ old('defeated_name', $result->defeated_name) ? '' : 'selected' }}>- Select Defeated -</option>
                                        @foreach ($participants as $participant)
                                            <option value="{{ $participant->participant_name }}" {{ old('defeated_name', $result->defeated_name) == $participant->participant_name ? 'selected' : '' }}>
                                                {{ $participant->participant_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-content">
                                    <label for="defeated_score">Defeated Score</label>
                                    <input type="number" id="defeated_score" name="defeated_score" placeholder="Defeated Participant Score" value="{{ old('defeated_score', $result->defeated_score) }}" required>
                                </div>
                            </div>

                            <div class="submit-button">
                                <input type="submit" value="Confirm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const winnerSelect = document.getElementById('winner_name');
            const defeatedSelect = document.getElementById('defeated_name');

            winnerSelect.addEventListener('change', () => {
                const selectedWinner = winnerSelect.value;

                Array.from(defeatedSelect.options).forEach(option => {
                    if (option.value === selectedWinner) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });

                if (defeatedSelect.value === selectedWinner) {
                    defeatedSelect.value = '';
                }
            });
        });
    </script>
@endsection