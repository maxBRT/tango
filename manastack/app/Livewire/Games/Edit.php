<?php

namespace App\Livewire\Games;

use App\Models\Game;
use App\Services\GameService;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
class Edit extends Component
{
    public Game $game;

    #[Validate('required|string|max:255')]
    public string $title = '';

    public function mount(Game $game): void
    {
        abort_unless($game->user_id === auth()->id(), 403);

        $this->game = $game;
        $this->title = $game->title;
    }

    public function save(GameService $gameService): void
    {
        $this->validate();

        $gameService->update($this->game->id, [
            'title' => $this->title,
        ]);

        $this->redirect(route('games.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.games.edit');
    }
}
