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
                <a href="{{ route('dashboard') }}"
                   class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                        Logout
                    </button>
                </form>
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