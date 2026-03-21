<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LIMAX Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .admin-shell { min-height: 100vh; display: flex; }
        .admin-aside { width: 18rem; background: #111827; border-right: 1px solid rgba(255, 255, 255, 0.1); }
        .admin-main { flex: 1; background: #0b1020; }
        .admin-topbar { border-bottom: 1px solid rgba(255, 255, 255, 0.1); background: #0f172a; }
        .admin-content { padding: 1rem; color: #e2e8f0; }

        .admin-link {
            display: block;
            margin-bottom: 0.25rem;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: background-color .2s ease;
        }
        .admin-link:hover { background: rgba(255, 255, 255, 0.1); }
        .admin-link.active { background: #ffffff; color: #0f172a; font-weight: 600; }

        .admin-content .rounded-2xl { border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); }
        .admin-content table { width: 100%; border-collapse: collapse; }
        .admin-content th { color: rgba(255, 255, 255, 0.65); font-size: 12px; text-transform: uppercase; }
        .admin-content td { color: rgba(255, 255, 255, 0.85); }

        @media (max-width: 1023px) {
            .admin-shell { flex-direction: column; }
            .admin-aside { width: 100%; border-right: 0; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        }

        @media (min-width: 640px) {
            .admin-content { padding: 1.5rem; }
        }

        @media (min-width: 1024px) {
            .admin-content { padding: 2rem; }
        }
    </style>
</head>
<body class="bg-[#0b1020] text-slate-100 antialiased">
    <div class="admin-shell min-h-screen lg:flex">
        <aside class="admin-aside w-full border-b border-white/10 bg-[#111827] text-white lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-r lg:border-white/10">
            <div class="flex items-center justify-between px-6 py-5">
                <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">LIMAX Admin</a>
            </div>

            <nav class="space-y-1 px-4 pb-6">
                <a href="{{ route('admin.dashboard') }}" class="admin-link {{ request()->routeIs('admin.dashboard') ? 'active bg-white text-slate-900' : 'text-white/85 hover:bg-white/10' }} block rounded-xl px-4 py-3 text-sm font-medium transition">
                    Dashboard
                </a>
                <a href="{{ route('admin.notifications.index') }}" class="admin-link {{ request()->routeIs('admin.notifications.*') ? 'active bg-white text-slate-900' : 'text-white/85 hover:bg-white/10' }} block rounded-xl px-4 py-3 text-sm font-medium transition">
                    Notifications
                </a>
                <a href="{{ route('admin.users.index') }}" class="admin-link {{ request()->routeIs('admin.users.*') ? 'active bg-white text-slate-900' : 'text-white/85 hover:bg-white/10' }} block rounded-xl px-4 py-3 text-sm font-medium transition">
                    Users
                </a>
                <a href="{{ route('admin.services.index') }}" class="admin-link {{ request()->routeIs('admin.services.*') ? 'active bg-white text-slate-900' : 'text-white/85 hover:bg-white/10' }} block rounded-xl px-4 py-3 text-sm font-medium transition">
                    Services
                </a>
                <a href="{{ route('admin.orders.index') }}" class="admin-link {{ request()->routeIs('admin.orders.*') ? 'active bg-white text-slate-900' : 'text-white/85 hover:bg-white/10' }} block rounded-xl px-4 py-3 text-sm font-medium transition">
                    Orders
                </a>
                <a href="{{ route('admin.categories.index') }}" class="admin-link {{ request()->routeIs('admin.categories.*') ? 'active bg-white text-slate-900' : 'text-white/85 hover:bg-white/10' }} block rounded-xl px-4 py-3 text-sm font-medium transition">
                    Categories
                </a>
                <a href="{{ route('admin.team-members.index') }}" class="admin-link {{ request()->routeIs('admin.team-members.*') ? 'active bg-white text-slate-900' : 'text-white/85 hover:bg-white/10' }} block rounded-xl px-4 py-3 text-sm font-medium transition">
                    Team Members
                </a>
            </nav>
        </aside>

        <div class="admin-main flex-1">
            <header class="admin-topbar border-b border-white/10 bg-[#0f172a]">
                <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <h1 class="text-xl font-semibold text-white">{{ $heading ?? 'Admin Panel' }}</h1>
                        <p class="text-sm text-white/60">{{ $subheading ?? 'Manage the LIMAX marketplace' }}</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-medium text-white/90 transition hover:border-white/35 hover:bg-white/10">
                            View Site
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-lg border border-rose-400/40 bg-rose-500/10 px-4 py-2 text-sm font-medium text-rose-200 transition hover:bg-rose-500/20">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="admin-content bg-[#0b1020] p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-400/30 bg-emerald-500/15 px-4 py-3 text-sm text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-rose-400/30 bg-rose-500/15 px-4 py-3 text-sm text-rose-200">
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
