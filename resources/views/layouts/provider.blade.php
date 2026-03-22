<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LIMAX Provider' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0e0e12] text-white antialiased">
    @php
        $providerNewOrdersCount = auth()->check() && auth()->user()->role === 'provider'
            ? \App\Models\Order::where('provider_user_id', auth()->id())
                ->whereIn('status', [\App\Models\Order::STATUS_PENDING, \App\Models\Order::STATUS_CONFIRMED])
                ->count()
            : 0;
    @endphp

    <div class="min-h-screen lg:flex">
        <aside class="w-full border-b border-white/10 bg-[#141826] lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-r lg:border-white/10">
            <div class="px-6 py-5">
                <a href="{{ route('provider.services.index') }}" class="text-2xl font-extrabold tracking-tight text-white">LIMAX Provider</a>
                <p class="mt-2 text-xs uppercase tracking-[0.28em] text-white/45">Workspace</p>
            </div>

            <nav class="space-y-1 px-4 pb-6">
                <a href="{{ route('provider.services.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('provider.services.*') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    Services
                </a>
                <a href="{{ route('provider.orders.index') }}" class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('provider.orders.*') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    <span>Orders</span>
                    <span class="rounded-full px-2 py-0.5 text-xs {{ request()->routeIs('provider.orders.*') ? 'bg-[#111] text-white' : 'bg-white/10 text-white' }}">{{ $providerNewOrdersCount }}</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('profile.*') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    Profile
                </a>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="sticky top-0 z-40 border-b border-white/10 bg-[#0d0e13]/90 backdrop-blur-md">
                <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <h1 class="text-xl font-semibold text-white">{{ $heading ?? 'Provider Panel' }}</h1>
                        <p class="text-sm text-white/50">{{ $subheading ?? 'Manage your services and bookings' }}</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
                            View Site
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-rose-400/20 bg-rose-400/10 px-4 py-3 text-sm text-rose-100">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
