<x-guest-layout>
    <div class="relative min-h-screen overflow-hidden bg-[#0d0e13] text-white">
        <div class="pointer-events-none absolute -left-20 top-8 h-80 w-80 rounded-full bg-violet-600/25 blur-[110px]"></div>
        <div class="pointer-events-none absolute right-0 top-24 h-72 w-72 rounded-full bg-indigo-500/20 blur-[100px]"></div>

        <div class="mx-auto flex min-h-screen w-full max-w-[1120px] items-center justify-center px-5 py-8 sm:px-8">
            <div class="grid w-full overflow-hidden rounded-[2rem] border border-white/10 bg-[#12141c]/90 shadow-[0_40px_90px_rgba(0,0,0,0.45)] md:grid-cols-[1.05fr_0.95fr]">
                <div class="relative hidden md:block">
                    <img
                        src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1400&q=80"
                        alt="Circuit board close-up"
                        class="h-full w-full object-cover"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/55 to-black/20"></div>
                    <div class="absolute inset-x-8 bottom-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-white/70">Welcome back</p>
                        <p class="mt-3 text-3xl font-black leading-tight text-white">You bring the idea,<br>we'll take it from here</p>
                    </div>
                </div>

                <div class="flex flex-col justify-center p-6 sm:p-10 md:px-12 md:py-14">
                    <a href="{{ route('home') }}" class="mb-8 text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                        LIMAX
                    </a>

                    <h1 class="text-4xl font-black leading-tight text-white sm:text-5xl">Log in to your account</h1>
                    <p class="mt-2 text-base text-white/60 sm:text-lg">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="underline underline-offset-4 hover:text-white">Join here</a>
                    </p>

                    <x-auth-session-status class="mt-4 text-sm text-emerald-300" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-4">
                        @csrf

                        <div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Username"
                                class="w-full rounded-xl border border-white/15 bg-white/[0.06] px-4 py-4 text-base text-white placeholder:text-white/45 focus:border-white/35 focus:outline-none"
                            >
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
                        </div>

                        <div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                placeholder="Password"
                                class="w-full rounded-xl border border-white/15 bg-white/[0.06] px-4 py-4 text-base text-white placeholder:text-white/45 focus:border-white/35 focus:outline-none"
                            >
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
                        </div>

                        <div class="pt-3">
                            <button type="submit" class="rounded-full bg-white px-10 py-3 text-base font-semibold text-black transition hover:bg-white/90">
                                Login
                            </button>
                        </div>
                    </form>

                    <p class="mt-12 text-sm leading-8 text-white/45">
                        By joining Limax, you agree to our Terms of Service and acknowledge our Privacy Policy.
                        We may occasionally send you emails about updates and services. Learn how we use your personal data in our Privacy Policy.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
