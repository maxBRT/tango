<?php

namespace App\Livewire\Games;

use App\Models\Game;
use App\Services\ApiKeyService;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
class Show extends Component
{
    public Game $game;

    #[Validate('required|string|max:255')]
    public string $keyName = '';

    public ?string $newPlainTextKey = null;

    public function mount(Game $game): void
    {
        abort_unless($game->user_id === auth()->id(), 403);

        $this->game = $game;
    }

    public function createKey(ApiKeyService $apiKeyService): void
    {
        $this->validate();

        $result = $apiKeyService->create($this->game, $this->keyName);

        $this->newPlainTextKey = $result['plain_text_key'];
        $this->keyName = '';
        $this->game->refresh();
    }

    public function deleteKey(string $id): void
    {
        $this->game->apiKeys()->where('id', $id)->delete();
        $this->game->refresh();
    }

    public function render(): View
    {
        return view('livewire.games.show', [
            'apiKeys' => $this->game->apiKeys()->latest()->get(),
        ]);
    }
}
