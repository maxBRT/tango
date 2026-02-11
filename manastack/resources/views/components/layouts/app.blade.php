<x-layouts.base class="min-h-screen flex flex-col bg-muted">
    <header class="w-full max-w-5xl mx-auto flex items-center justify-between px-6 py-4">
        <flux:heading size="lg">{{ config('app.name', 'ManaStack') }}</flux:heading>

        <nav class="flex items-center gap-3">
            @auth
                <flux:button href="{{ url('/dashboard') }}" variant="ghost" size="sm">Dashboard</flux:button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:button type="submit" variant="subtle" size="sm">Log out</flux:button>
                </form>
            @else
                <flux:button href="{{ route('login') }}" variant="ghost" size="sm">Log in</flux:button>
                <flux:button href="{{ route('register') }}" variant="primary" size="sm">Register</flux:button>
            @endauth
        </nav>
    </header>

    <main class="flex-1 px-6">
        {{ $slot }}
    </main>
</x-layouts.base>
