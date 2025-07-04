<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{
    /**
     * GET /api/players - Retrieves a list of all registered players in the system
     */
    public function index(): JsonResponse
    {
        try {
            $players = User::players()
                          ->get();
            
            return response()->json([
                'success' => true,
                'data' => $players,
                'message' => 'Players retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve players',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/players/{id} - Fetches the profile of a specific player based on their unique ID
     */
    public function show($id): JsonResponse
    {
        try {
            $player = User::players()
                         ->where('UserID', $id)
                         ->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => $player,
                'message' => 'Player retrieved successfully'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Player not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve player',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/players - Register new players for tournament
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'Name' => 'required|string|max:255',
                'Email' => 'required|email|unique:users,Email',
                'Password' => 'required|string|min:8',
            ]);

            // Set default role as player and hash password
            $validatedData['Role'] = 'player';
            $validatedData['Password'] = Hash::make($validatedData['Password']);
            $validatedData['RegistrationDate'] = now();

            $player = User::create($validatedData);

            // Hide password in response
            $player->makeHidden(['Password']);

            return response()->json([
                'success' => true,
                'data' => $player,
                'message' => 'Player registered successfully'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register player',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PUT /api/players/{id} - Update player information
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $player = User::where('Role', 'player')
                         ->where('UserID', $id)
                         ->firstOrFail();

            $validatedData = $request->validate([
                'Name' => 'sometimes|string|max:255',
                'Email' => 'sometimes|email|unique:users,Email,' . $id . ',UserID',
                'Password' => 'sometimes|string|min:8',
            ]);

            // Hash password if provided
            if (isset($validatedData['Password'])) {
                $validatedData['Password'] = Hash::make($validatedData['Password']);
            }

            $player->update($validatedData);

            // Hide password in response
            $player->makeHidden(['Password']);

            return response()->json([
                'success' => true,
                'data' => $player,
                'message' => 'Player updated successfully'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Player not found'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update player',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/players/{id} - Deletes a specific player account from the system
     */
    public function destroy($id): JsonResponse
    {
        try {
            $player = User::where('Role', 'player')
                         ->where('UserID', $id)
                         ->firstOrFail();
            
            $player->delete();

            return response()->json([
                'success' => true,
                'message' => 'Player deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Player not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete player',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
