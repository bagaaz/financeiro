<aside class="w-1/5 h-screen bg-white relative">
    <header class="flex flex-col items-center justify-center py-8">
        <img src="{{ asset('/src/logos/logo_vertical.png') }}" alt="Logo Vertical DevConecta" width="50%">
    </header>

    <nav class="flex flex-col">
        <ul class="text-lg font-semibold text-gray-700">
            <a href="{{ route('dashboard') }}" class="flex items-center py-4 px-8 hover:bg-gray-200 {{ request()->routeIs('dashboard') ? 'bg-gray-200' : '' }}">
                @svg('solar-monitor-linear', ['class' => 'h-6 w-6 mr-2']) {{ __('messages.dashboard') }}
            </a>
            <a href="{{ route('transactions.index') }}" class="flex items-center py-4 px-8 hover:bg-gray-200 {{ request()->routeIs('transactions.*') ? 'bg-gray-200' : '' }}">
                @svg('solar-bill-list-linear', ['class' => 'h-6 w-6 mr-2']) {{ __('messages.transactions') }}
            </a>
            <a href="{{ route('vaults.index') }}" class="flex items-center py-4 px-8 hover:bg-gray-200 {{ request()->routeIs('vaults.*') ? 'bg-gray-200' : '' }}">
                @svg('solar-safe-square-linear', ['class' => 'h-6 w-6 mr-2']) {{ __('messages.vaults') }}
            </a>
        </ul>
    </nav>

    <footer class="w-full flex justify-center items-center absolute bottom-0 hover:bg-gray-200">
        <a href="{{ route('logout') }}" class="w-full flex items-center justify-star font-semibold text-gray-700 py-4 px-8">
            @svg('solar-exit-linear', ['class' => 'h-6 w-6 mr-2']) {{ __('messages.exit') }}
        </a>
    </footer>
</aside>
