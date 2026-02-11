<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

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

    public function create(array $data): Game
    {
        $validated = Validator::make($data, [
            'title' => 'required|string',
            'user_id' => 'required|uuid|exists:users,id',
        ])->validate();

        return Game::create($validated);
    }

    public function update(string $id, array $data): Game
    {
        $validated = Validator::make($data, [
            'title' => 'required|string',
        ])->validate();

        $game = Game::findOrFail($id);
        $game->update($validated);

        return $game->refresh();
    }

    public function delete(string $id): void
    {
        Game::findOrFail($id)->delete();
    }
}
