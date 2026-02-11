<div>
    <div class="flex items-center justify-between">
        <flux:heading size="xl">{{ $game->title }}</flux:heading>
        <div class="flex gap-2">
            <flux:button href="{{ route('games.edit', $game) }}" size="sm">Edit</flux:button>
            <flux:button href="{{ route('games.index') }}" size="sm">Back to Games</flux:button>
        </div>
    </div>

    <flux:separator class="my-6" />

    <flux:heading size="lg">API Keys</flux:heading>

    @if ($newPlainTextKey)
    <div class="mt-4 rounded-lg border border-accent bg-accent/10 p-4">
        <p class="font-medium text-accent">Your new API key. Copy it now, it won't be shown again:</p>
        <code class="mt-2 block break-all rounded bg-accent/20 p-2 text-sm">{{ $newPlainTextKey }}</code>
        <flux:button size="sm" class="mt-2" wire:click="$set('newPlainTextKey', null)">Dismiss</flux:button>
    </div>
    @endif

    <form wire:submit="createKey" class="mt-4 flex max-w-md items-end gap-2">
        <flux:input label="Key Name" wire:model="keyName" placeholder="e.g. Production" class="flex-1" />
        <flux:button type="submit" variant="primary">Create Key</flux:button>
    </form>

    <flux:table class="mt-6">
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Created</flux:table.column>
            <flux:table.column>Last Used</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($apiKeys as $apiKey)
            <flux:table.row :key="$apiKey->id">
                <flux:table.cell>{{ $apiKey->name }}</flux:table.cell>
                <flux:table.cell>{{ $apiKey->created_at->format('M j, Y') }}</flux:table.cell>
                <flux:table.cell>{{ $apiKey->last_used_at?->format('M j, Y') ?? 'Never' }}</flux:table.cell>
                <flux:table.cell class="flex justify-end">
                    <flux:button size="sm" variant="danger" wire:click="deleteKey('{{ $apiKey->id }}')"
                        wire:confirm="Are you sure you want to revoke this API key?">Revoke</flux:button>
                </flux:table.cell>
            </flux:table.row>
            @empty
            <flux:table.row>
                <flux:table.cell colspan="4">No API keys yet.</flux:table.cell>
            </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>
