<?php

namespace App\Livewire\Games;

use App\Services\GameService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
class Index extends Component
{
    public function delete(GameService $gameService, string $id): void
    {
        $game = $gameService->find($id);

        abort_unless($game->user_id === auth()->id(), 403);

        $gameService->delete($id);
    }

    public function render(): \Illuminate\View\View
    {
        $games = app(GameService::class)->list(auth()->id());

        return view('livewire.games.index', compact('games'));
    }
}
