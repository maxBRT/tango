<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaveRequest;
use App\Http\Requests\UpdateSaveRequest;
use App\Http\Resources\SaveResource;
use App\Models\Player;
use App\Services\SaveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SaveApiController extends Controller
{
    public function __construct(public SaveService $saveService) {}

    public function index(Request $request, Player $player): AnonymousResourceCollection
    {
        $game = $request->attributes->get('game');
        abort_unless($player->game_id === $game->id, 404);

        return SaveResource::collection($this->saveService->listForPlayer($player));
    }

    public function store(StoreSaveRequest $request, Player $player): SaveResource
    {
        $game = $request->attributes->get('game');
        abort_unless($player->game_id === $game->id, 404);

        $save = $this->saveService->create($player, $request->validated());

        return new SaveResource($save);
    }

    public function show(Request $request, Player $player, string $saveId): SaveResource
    {
        $game = $request->attributes->get('game');
        abort_unless($player->game_id === $game->id, 404);

        return new SaveResource($this->saveService->find($player, $saveId));
    }

    public function update(UpdateSaveRequest $request, Player $player, string $saveId): SaveResource
    {
        $game = $request->attributes->get('game');
        abort_unless($player->game_id === $game->id, 404);

        return new SaveResource($this->saveService->update($player, $saveId, $request->validated()));
    }

    public function destroy(Request $request, Player $player, string $saveId): JsonResponse
    {
        $game = $request->attributes->get('game');
        abort_unless($player->game_id === $game->id, 404);

        $this->saveService->delete($player, $saveId);

        return response()->json(null, 204);
    }
}
