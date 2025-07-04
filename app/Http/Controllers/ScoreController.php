<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\User;
use App\Models\Tournament;

class ScoreController extends Controller
{
    // Update a player's score
    public function updatePlayerScore(Request $request, $player_id)
    {
        $request->validate([
            'score' => 'required|integer',
            'tour_id' => 'required|integer',
        ]);

        $score = Score::where('UserID', $player_id)
                      ->where('TourID', $request->input('tour_id'))
                      ->first();

        if (!$score) {
            return response()->json(['message' => 'Score not found'], 404);
        }

        $score->ScoreValue = $request->input('score');
        $score->save();

        return response()->json(['message' => 'Score updated successfully']);
    }

    // Submit a new score
    public function storeScore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'tour_id' => 'required|integer',
            'score' => 'required|integer',
        ]);

        $score = new Score();
        $score->UserID = $request->input('user_id');
        $score->TourID = $request->input('tour_id');
        $score->ScoreValue = $request->input('score');
        $score->save();

        return response()->json(['message' => 'Score submitted successfully']);
    }
}
