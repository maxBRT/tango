<?php

namespace App\Livewire\Games;

use App\Services\GameService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
class Create extends Component
{
    #[Validate('required|string|max:255')]
    public string $title = '';

    public function save(GameService $gameService): void
    {
        $this->validate();

        $gameService->create([
            'title' => $this->title,
            'user_id' => auth()->id(),
        ]);

        $this->redirect(route('games.index'), navigate: true);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.games.create');
    }
}
