<x-layouts.app>
    <div class="flex-1 flex items-center justify-center">
        <div class="text-center max-w-lg">
            <flux:heading size="xl" level="1" class="mb-4">Build your game collection</flux:heading>
            <flux:text class="mb-8">Track, organize, and manage your tabletop game library with ManaStack.</flux:text>
            @guest
            <div class="flex items-center justify-center gap-3">
                <flux:button href="{{ route('register') }}" variant="primary">Get started</flux:button>
                <flux:button href="{{ route('login') }}" variant="filled">Log in</flux:button>
            </div>
            @endguest
        </div>
    </div>
</x-layouts.app>
