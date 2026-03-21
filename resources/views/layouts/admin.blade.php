<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LIMAX Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0e0e12] text-white antialiased">
    <div class="min-h-screen lg:flex">
        <aside class="w-full border-b border-white/10 bg-[#141826] lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-r lg:border-white/10">
            <div class="px-6 py-5">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-extrabold tracking-tight text-white">LIMAX Admin</a>
                <p class="mt-2 text-xs uppercase tracking-[0.28em] text-white/45">Workspace</p>
            </div>

            <nav class="space-y-1 px-4 pb-6">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.notifications.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.notifications.*') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    Notifications
                </a>
                <a href="{{ route('admin.users.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.users.*') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    Users
                </a>
                <a href="{{ route('admin.services.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.services.*') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    Services
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.orders.*') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    Orders
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.categories.*') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    Categories
                </a>
                <a href="{{ route('admin.team-members.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.team-members.*') ? 'bg-white text-[#111]' : 'text-white/85 hover:bg-white/5 hover:text-white' }}">
                    Team Members
                </a>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="border-b border-white/10 bg-[#0d0e13]/90 backdrop-blur-md">
                <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <h1 class="text-xl font-semibold text-white">{{ $heading ?? 'Admin Panel' }}</h1>
                        <p class="text-sm text-white/50">{{ $subheading ?? 'Manage the LIMAX marketplace' }}</p>
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
