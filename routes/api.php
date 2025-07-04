<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\ScoreController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

// Player API Routes
Route::get('/players', [PlayerController::class, 'index']);
Route::get('/players/{id}', [PlayerController::class, 'show']);
Route::post('/players', [PlayerController::class, 'store']);
Route::put('/players/{id}', [PlayerController::class, 'update']);
Route::delete('/players/{id}', [PlayerController::class, 'destroy']);

// Tournament API Routes  
Route::put('/tournament/{id}', [TournamentController::class, 'update']);
Route::get('/tournament/{id}/scoreboard', [TournamentController::class, 'scoreboard']);
Route::post('/tournament', [TournamentController::class, 'store']);

// Score API Routes
Route::put('/players/{player_id}/scores', [ScoreController::class, 'updatePlayerScore']);
Route::post('/scores', [ScoreController::class, 'storeScore']);
