<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Participant;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function show()
    {
        $tournaments = Tournament::with('participants')->get();

        return view('admin.tournaments.tournaments', compact('tournaments'));
    }

    public function resultShow()
    {
        $results = Result::with('tournament.participants')->paginate(10);

        return view('admin.tournaments.results', compact('results'));
    }

    public function create()
    {
        return view('admin.tournaments.createTournament');
    }

    public function participantCreate(Tournament $tournament)
    {
        return view('admin.tournaments.createParticipant', compact('tournament'));
    }

    public function resultCreate()
    {
        $tournaments = Tournament::where('tournament_date', '>=', Carbon::now()->subMonth())
            ->orderBy('tournament_date', 'desc')
            ->get();

        $tournamentIds = $tournaments->pluck('id');
        $participants = Participant::with('tournament')
            ->whereIn('tournament_id', $tournamentIds)
            ->get();

        return view('admin.tournaments.createResult', compact('tournaments', 'participants'));
    }

    public function participantEdit(Participant $participant)
    {
        return view('admin.tournaments.editParticipant', compact('participant'));
    }

    public function edit(Tournament $tournament)
    {
        return view('admin.tournaments.editTournament', ['tournament' => $tournament]);
    }

    public function resultEdit(Result $result)
    {
        $tournaments = Tournament::orderBy('tournament_date', 'desc')->get();

        $tournamentIds = $tournaments->pluck('id');
        $participants = Participant::with('tournament')
            ->whereIn('tournament_id', $tournamentIds)
            ->get();

        return view('admin.tournaments.editResult', compact('result', 'tournaments', 'participants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'tournament_date' => 'nullable|date|after_or_equal:today',
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

    public function participantStore(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|string|min:14|max:14|exists:users,id',
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string|max:255',
            'contact_details' => 'required|string|min:11|max:11',
        ], [
            'user_id.exists' => 'The provided User ID does not exist.',
            'tournament_id.exists' => 'The selected tournament does not exist.',
        ]);

        $existingParticipant = Participant::whereNotNull('user_id')
            ->where('user_id', $validated['user_id'])
            ->where('tournament_id', $validated['tournament_id'])
            ->first();

        if ($existingParticipant) {
            return redirect()->back()->withErrors([
                'user_id' => 'This user is already registered for the selected tournament.',
            ])->withInput();
        }

        Participant::create([
            'user_id' => $validated['user_id'] ?? null, // Handle nullable user_id
            'tournament_id' => $validated['tournament_id'],
            'participant_name' => $validated['name'],
            'contact_details' => $validated['contact_details'],
        ]);

        return redirect()->route('tournaments.index')->with('success', 'Participant added successfully.');
    }

    public function resultStore(Request $request)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'winner_name' => 'required|exists:participants,participant_name',
            'defeated_name' => 'required|exists:participants,participant_name|different:winner_name',
            'winner_score' => 'required|numeric|min:0',
            'defeated_score' => 'required|numeric|min:0',
            'game_date' => 'required|date',
            'remarks' => 'required|string|max:255',
        ]);

        Result::create($validated);

        return redirect()->route('result.show')->with('success', 'Tournament result added successfully.');
    }

    public function resultUpdate(Request $request, Result $result)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'winner_name' => 'required|exists:participants,participant_name',
            'defeated_name' => 'required|exists:participants,participant_name|different:winner_name',
            'winner_score' => 'required|numeric|min:0',
            'defeated_score' => 'required|numeric|min:0',
            'game_date' => 'required|date',
            'remarks' => 'required|string|max:255',
        ]);

        $result->update($validated);

        return redirect()->route('result.show')->with('success', 'Tournament result updated successfully.');
    }

    public function participantUpdate(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|string|min:14|max:14|exists:users,id',
            'name' => 'required|string|max:255',
            'contact_details' => 'required|string|min:11|max:11',
        ], [
            'user_id.exists' => 'The provided User ID does not exist.',
        ]);

        if ($validated['user_id']) {
            $existingParticipant = Participant::where('user_id', $validated['user_id'])
                ->where('tournament_id', $participant->tournament_id)
                ->where('id', '!=', $participant->id)
                ->first();

            if ($existingParticipant) {
                return redirect()->back()->withErrors([
                    'user_id' => 'This user is already registered for the selected tournament.',
                ])->withInput();
            }
        }

        $participant->update([
            'user_id' => $validated['user_id'] ?? null,
            'participant_name' => $validated['name'],
            'contact_details' => $validated['contact_details'],
        ]);

        return redirect()->route('tournaments.index')->with('success', 'Participant updated successfully.');
    }


    public function update(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'tournament_date' => 'required|date|after_or_equal:today',
            'registration_fee' => 'required|numeric|min:0',
            'first_prize' => 'nullable|numeric|min:0',
            'second_prize' => 'nullable|numeric|min:0',
            'third_prize' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|string|in:Registration,Ongoing,Completed',
        ]);
    
        $tournament->update($validated);
    
        return redirect()->route('tournaments.index')->with('success', 'Tournament updated successfully.');
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

    public function destroy(Tournament $tournament)
    {
        $tournament->delete();

        return redirect()->route('tournaments.index')->with('success', 'Tournament Deleted Successfully');
    }

    public function resultDestroy(Result $result)
    {
        $result->delete();

        return redirect()->route('result.show')->with('success', 'Result Deleted Successfully');
    }
}
