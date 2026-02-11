<div>
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Games</flux:heading>
        <flux:button href="{{ route('games.create') }}" variant="primary">New Game</flux:button>
    </div>

    <flux:table class="mt-6">
        <flux:table.columns>
            <flux:table.column>Title</flux:table.column>
            <flux:table.column>Created</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($games as $game)
                <flux:table.row :key="$game->id">
                    <flux:table.cell><flux:link href="{{ route('games.show', $game) }}" wire:navigate>{{ $game->title }}</flux:link></flux:table.cell>
                    <flux:table.cell>{{ $game->created_at->format('M j, Y') }}</flux:table.cell>
                    <flux:table.cell class="flex justify-end gap-2">
                        <flux:button size="sm" href="{{ route('games.edit', $game) }}">Edit</flux:button>
                        <flux:button size="sm" variant="danger" wire:click="delete('{{ $game->id }}')" wire:confirm="Are you sure you want to delete this game?">Delete</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="3">No games yet.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>
