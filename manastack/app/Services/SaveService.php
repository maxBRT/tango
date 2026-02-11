<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Save;
use Illuminate\Database\Eloquent\Collection;

class SaveService
{
    /**
     * @return Collection<int, Save>
     */
    public function listForPlayer(Player $player): Collection
    {
        return $player->saves()->get();
    }

    public function find(Player $player, string $saveId): Save
    {
        return $player->saves()->findOrFail($saveId);
    }

    /**
     * @param  array{name: string, data: array<string, mixed>}  $data
     */
    public function create(Player $player, array $data): Save
    {
        return $player->saves()->create($data);
    }

    /**
     * @param  array{name?: string, data?: array<string, mixed>}  $data
     */
    public function update(Player $player, string $saveId, array $data): Save
    {
        $save = $player->saves()->findOrFail($saveId);
        $save->update($data);

        return $save->refresh();
    }

    public function delete(Player $player, string $saveId): void
    {
        $player->saves()->findOrFail($saveId)->delete();
    }
}
