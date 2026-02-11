<?php

use App\Http\Controllers\GameApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Games
Route::get('/games', [GameApiController::class, 'index']);
Route::get('/games/{game}', [GameApiController::class, 'show']);
Route::post('/games', [GameApiController::class, 'store']);
Route::put('/games/{game}', [GameApiController::class, 'update']);
Route::delete('/games/{game}', [GameApiController::class, 'destroy']);

// Players
Route::post('/players', function (Request $request) {
    // Receives: client_id
    // Creates a new anonymous player linked to the client_id
    // If a player with this client_id already exists, return the existing one
    return json_encode([
        'player' => 'Player created or retrieved',
    ]);
});

Route::post('/players/{player}/account', function (Request $request) {
    // Upgrades an anonymous player to a full account
    return json_encode([
        'player' => 'Account created',
    ]);
});

// Saves
Route::get('/saves/{player}', function (Request $request) {
    return json_encode([
        'Saves' => 'Player save',
    ]);
});

Route::get('/saves', function (Request $request) {
    return json_encode([
        'Saves' => 'Get all saves',
    ]);
});

Route::post('/saves', function (Request $request) {
    return json_encode([
        'Saves' => 'New save',
    ]);
});

Route::put('/saves', function (Request $request) {
    return json_encode([
        'Saves' => 'New save',
    ]);
});

Route::delete('/saves', function (Request $request) {
    return json_encode([
        'Saves' => 'Save deleted',
    ]);
});
