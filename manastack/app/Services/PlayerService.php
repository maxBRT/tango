<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Player;

class PlayerService
{
    /**
     * @return array{player: Player, created: bool}
     */
    public function findOrCreate(Game $game, string $clientId): array
    {
        $player = $game->players()->where('client_id', $clientId)->first();

        if ($player) {
            return ['player' => $player, 'created' => false];
        }

        return [
            'player' => $game->players()->create(['client_id' => $clientId]),
            'created' => true,
        ];
    }

    public function find(Game $game, string $playerId): Player
    {
        return $game->players()->findOrFail($playerId);
    }
}
