<header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight text-slate-900">
            LIMAX
        </a>

        <nav class="hidden items-center gap-6 md:flex">
            <a href="{{ route('home') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900">Home</a>
            <a href="{{ route('about') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900">About</a>
            <a href="{{ route('services.index') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900">Services</a>
            <a href="#" class="text-sm font-medium text-slate-700 hover:text-slate-900">Support</a>
        </nav>

        <div class="flex items-center gap-3">
            @auth
                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('profile.edit') }}">
                            My Profile
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('orders.index') }}">
                            My Orders
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('cart.index') }}">
                            My Cart
                        </x-dropdown-link>
                        <hr class="my-1 border-slate-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link as="button" type="submit">
                                Log out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @else
                <a href="{{ route('login') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                    Register
                </a>
            @endauth
        </div>
    </div>
</header>