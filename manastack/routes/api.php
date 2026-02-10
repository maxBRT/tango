<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Games
Route::get("/games", function (Request $request) {
    return json_encode([
        "Games" => "Ok",
    ]);
});

Route::get("/games/{game}", function (Request $request) {
    return json_encode([
        "Game" => "got one game",
    ]);
});

Route::post("/games" , function (Request $request) { 
    return json_encode([
        "Games" => "Game creates"
    ]);
});

 Route::patch("/games" , function (Request $request) {
    return json_encode([
        "Games"=> "Game Updated"
    ]);
 });

 Route::delete("/games/{games}" , function (Request $request) {
    return json_encode([
        "Games"=> "Game deleted"
    ]);
 });      

 // Players
Route::post("/players", function (Request $request) {
    // Receives: client_id
    // Creates a new anonymous player linked to the client_id
    // If a player with this client_id already exists, return the existing one
    return json_encode([
        "player" => "Player created or retrieved",
    ]);
});

Route::post("/players/{player}/account", function (Request $request) {
    // Upgrades an anonymous player to a full account
    return json_encode([
        "player" => "Account created",
    ]);
});


// Saves
Route::get("/saves/{player}", function (Request $request) {
    return json_encode([
        "Saves"=> "Player save"
    ]);
});

Route::get("/saves", function (Request $request) {
    return json_encode([
        "Saves"=> "Get all saves"
    ]);
});

Route::post("/saves", function (Request $request) {
    return json_encode([
        "Saves" => "New save"
    ]);
});

Route::put("/saves", function (Request $request) {
    return json_encode([
        "Saves" => "New save"
    ]);
});

Route::delete("/saves", function (Request $request) {
    return json_encode([
        "Saves"=> "Save deleted",
    ]);
});



