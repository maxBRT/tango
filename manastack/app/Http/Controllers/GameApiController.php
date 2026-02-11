<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GameApiController extends Controller
{
    public function __construct(public GameService $gameService) {}

    public function index(): AnonymousResourceCollection
    {
        return GameResource::collection($this->gameService->list());
    }

    public function store(StoreGameRequest $request): GameResource
    {
        $game = $this->gameService->create($request->validated());

        return new GameResource($game);
    }

    public function show(Game $game): GameResource
    {
        return new GameResource($this->gameService->find($game->id));
    }

    public function update(UpdateGameRequest $request, Game $game): GameResource
    {
        $game = $this->gameService->update($game->id, $request->validated());

        return new GameResource($game);
    }

    public function destroy(Game $game): JsonResponse
    {
        $this->gameService->delete($game->id);

        return response()->json(null, 204);
    }
}
