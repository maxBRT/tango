<div>
    <flux:heading size="xl">New Game</flux:heading>

    <form wire:submit="save" class="mt-6 max-w-md space-y-6">
        <flux:input label="Title" wire:model="title" placeholder="Enter game title" />

        <div class="flex gap-2">
            <flux:button type="submit" variant="primary">Create Game</flux:button>
            <flux:button href="{{ route('games.index') }}">Cancel</flux:button>
        </div>
    </form>
</div>
