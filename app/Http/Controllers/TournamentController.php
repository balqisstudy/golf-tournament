<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\User;

class TournamentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('TourID')) {
            $tournament = Tournament::find($request->TourID);
            
            if (!$tournament) {
                return response()->json(['error' => 'Tournament not found'], 404);
            }
            
            return response()->json($tournament);
        }
        
        return response()->json(Tournament::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'required|string',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date|after_or_equal:StartDate',
            'Location' => 'required|string|max:255',
            'ParticipantLimit' => 'required|integer|min:1',
            'PrizePool' => 'nullable|decimal:2',
            'Status' => 'nullable|string',
        ]);

        $tournament = Tournament::create($validatedData);

        return response()->json($tournament, 201);
    }

    public function update(Request $request, $id)
    {
        $tournament = Tournament::find($id);

        if (!$tournament) {
            return response()->json(['error' => 'Tournament not found'], 404);
        }

        $validated = $request->validate([
            'Name' => 'required|string|max:100',
            'Description' => 'nullable|string',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date|after_or_equal:StartDate',
            'Location' => 'nullable|string|max:255',
            'ParticipantLimit' => 'nullable|integer|min:1',
            'PrizePool' => 'nullable|decimal:2',
            'Status' => 'nullable|string',
        ]);

        $tournament->update($validated);

        return response()->json($tournament, 200);
    }

    public function scoreboard($id)
    {
        $tournament = Tournament::findOrFail($id);
        
        $players = User::where('Role', 'player')
            ->with(['scores' => function($query) use ($id) {
                $query->where('TourID', $id);
            }])
            ->get();
        
        $players = $players->sortBy(function($player) use ($id) {
            return $player->getScoreForTournament($id) ?: 999;
        });
        
        return view('scoreboard', compact('tournament', 'players'));
    }
}
