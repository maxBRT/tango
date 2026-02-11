<x-layouts.base class="min-h-screen bg-white dark:bg-neutral-800">
    <flux:sidebar sticky collapsible="mobile"
        class="bg-muted border-r border-muted">
        <flux:sidebar.header>
            <flux:sidebar.brand href="#" name="ManaStack" />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>
        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" href="/dashboard">Home</flux:sidebar.item>
            <flux:sidebar.item icon="puzzle-piece" href="{{ route('games.index') }}">Games</flux:sidebar.item>
        </flux:sidebar.nav>
        <flux:sidebar.spacer />
        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" href="#">Settings</flux:sidebar.item>
        </flux:sidebar.nav>
        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:profile avatar="https://avatars.laravel.cloud/taylor@laravel.com{{auth()->user()->id}}"
                name="{{auth()->user()->name}}" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>{{auth()->user()->name}}</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item type="submit" icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>
    <!-- Mobile -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" alignt="start">
            <flux:profile avatar="https://avatars.laravel.cloud/taylor@laravel.com{{auth()->user()->id}}" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>{{auth()->user()->name}}</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item type="submit" icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.base>
