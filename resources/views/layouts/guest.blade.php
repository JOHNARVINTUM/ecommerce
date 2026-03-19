<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LIMAX' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    @if (request()->routeIs('home', 'user.home', 'login', 'register', 'services.index', 'services.category', 'services.show', 'about', 'profile.edit', 'orders.index', 'orders.show'))
        <main>
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    @else
        <div class="min-h-screen flex flex-col">
            <x-site-header />

            <main class="flex-1">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

            <x-site-footer />
        </div>
    @endif
</body>
</html>
