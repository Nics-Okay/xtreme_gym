<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Participant;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::all();
        return view('admin.tournaments.tournaments', compact('tournaments'));
    }

    public function create()
    {
        return view('admin.tournaments.createtournament');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'tournament_date' => 'nullable|date|after_or_equal:today',
            'semi_finals' => 'nullable|date',
            'finals' => 'nullable|date',
            'registration_fee' => 'nullable|numeric|min:0',
            'first_prize' => 'nullable|numeric|min:0',
            'second_prize' => 'nullable|numeric|min:0',
            'third_prize' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|string|in:Registration,Ongoing,Completed',
        ]);

        Tournament::create($validated);

        return redirect()->route('tournaments.index')->with('success', 'Tournament created successfully.');
    }

    public function show(Tournament $tournament)
    {
        $participants = $tournament->participants;
        return view('tournaments.show', compact('tournament', 'participants'));
    }

    public function registerParticipant(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email,NULL,id,tournament_id,' . $tournament->id,
            'team_name' => 'nullable|string|max:255',
        ]);

        $tournament->participants()->create($validated);

        return back()->with('success', 'Registration successful.');
    }

    public function showResults(Tournament $tournament)
    {
        $results = $tournament->results;
        return view('tournaments.results', compact('tournament', 'results'));
    }
}
