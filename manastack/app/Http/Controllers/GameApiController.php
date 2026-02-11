<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Http\Request;

class GameApiController extends Controller
{
    public function __construct(public GameService $gameService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return GameResource::collection($this->gameService->list());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): GameResource
    {
        $game = $this->gameService->create($request->all());

        return new GameResource($game);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game): GameResource
    {
        return new GameResource($this->gameService->find($game->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game): GameResource
    {
        $game = $this->gameService->update($game->id, $request->all());

        return new GameResource($game);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game): \Illuminate\Http\JsonResponse
    {
        $this->gameService->delete($game->id);

        return response()->json(null, 204);
    }
}
