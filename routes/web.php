<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\PlayerController;

Route::get('/', function () {
    return view('welcome');
});

// Simple test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

// Tournament page (list all tournaments)
Route::get('/tournaments', [TournamentController::class, 'index']);

// Player page (list all players)
Route::get('/players', [PlayerController::class, 'index']);

// Scoreboard page
Route::get('/scoreboard', [TournamentController::class, 'scoreboard']);