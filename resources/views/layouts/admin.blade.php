<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LIMAX Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="min-h-screen lg:flex">
        <aside class="w-full border-b border-slate-200 bg-slate-900 text-white lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-r lg:border-slate-800">
            <div class="flex items-center justify-between px-6 py-5">
                <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">LIMAX Admin</a>
            </div>

            <nav class="space-y-1 px-4 pb-6">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-medium hover:bg-slate-800">
                    Dashboard
                </a>
                <a href="{{ route('admin.notifications.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium hover:bg-slate-800">
                    Notifications
                </a>
                <a href="{{ route('admin.users.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium hover:bg-slate-800">
                    Users
                </a>
                <a href="{{ route('admin.services.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium hover:bg-slate-800">
                    Services
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium hover:bg-slate-800">
                    Orders
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium hover:bg-slate-800">
                    Categories
                </a>
                <a href="{{ route('admin.team-members.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium hover:bg-slate-800">
                    Team Members
                </a>
                <a href="{{ route('admin.pages.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium hover:bg-slate-800">
                    Pages
                </a>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="border-b border-slate-200 bg-white">
                <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <h1 class="text-xl font-semibold text-slate-900">{{ $heading ?? 'Admin Panel' }}</h1>
                        <p class="text-sm text-slate-500">{{ $subheading ?? 'Manage the LIMAX marketplace' }}</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            View Site
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-lg border border-rose-300 px-4 py-2 text-sm font-medium text-rose-700 hover:bg-rose-50">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
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
