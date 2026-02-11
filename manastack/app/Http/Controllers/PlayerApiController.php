<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerApiController extends Controller
{
    public function __construct(public PlayerService $playerService) {}

    public function store(Request $request): PlayerResource|JsonResponse
    {
        $request->validate([
            'client_id' => 'required|string|max:255',
        ]);

        $game = $request->attributes->get('game');
        ['player' => $player, 'created' => $created] = $this->playerService->findOrCreate($game, $request->input('client_id'));

        $resource = new PlayerResource($player);

        return $created
            ? $resource->response()->setStatusCode(201)
            : $resource->response()->setStatusCode(200);
    }

    public function show(Request $request, Player $player): PlayerResource
    {
        $game = $request->attributes->get('game');

        abort_unless($player->game_id === $game->id, 404);

        return new PlayerResource($player);
    }
}
