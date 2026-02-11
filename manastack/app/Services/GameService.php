<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

class GameService
{
    /**
     * @return Collection<int, Game>
     */
    public function list(): Collection
    {
        return Game::all();
    }

    public function find(string $id): Game
    {
        return Game::findOrFail($id);
    }

    /**
     * @param  array{title: string, user_id: string}  $data
     */
    public function create(array $data): Game
    {
        return Game::create($data);
    }

    /**
     * @param  array{title?: string}  $data
     */
    public function update(string $id, array $data): Game
    {
        $game = Game::findOrFail($id);
        $game->update($data);

        return $game->refresh();
    }

    public function delete(string $id): void
    {
        Game::findOrFail($id)->delete();
    }
}
