<x-guest-layout>
    <div class="min-h-screen w-full bg-[#232428]">
        <div class="w-full">
            <div class="w-full rounded-none border-x-0 border-t-0 border-b border-[#3a3b3f] bg-[#232428]">
                <div class="flex items-center justify-between px-7 py-6 sm:px-10 lg:px-12">
                    <a href="{{ route('home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                        LIMAX
                    </a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-[#f5f5f4] px-4 py-2 text-sm font-medium text-black">
                        Sign Up
                    </a>
                </div>

                <div class="grid min-h-[calc(100vh-6.25rem)] overflow-hidden border-t border-[#2f3034] bg-[#ecece9] md:grid-cols-[1.08fr_0.92fr]">
                    <div class="min-h-[340px] md:min-h-[calc(100vh-7rem)]">
                        <img
                            src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=1400&q=80"
                            alt="Login visual"
                            class="h-full w-full object-cover"
                        >
                    </div>

                    <div class="flex min-h-[340px] flex-col justify-center p-6 sm:p-10 md:min-h-[calc(100vh-7rem)] md:px-14 md:py-16 lg:px-16">
                        <h1 class="text-4xl font-bold leading-tight text-[#111] sm:text-5xl lg:text-[4rem]">Log in to your account</h1>
                        <p class="mt-2 text-base text-[#444] sm:text-lg">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="underline hover:text-black">Join here</a>
                        </p>

                        <x-auth-session-status class="mt-4 text-sm text-emerald-700" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="mt-8 max-w-[620px] space-y-4">
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
                                    class="w-full rounded-md border border-[#8b8b8b] bg-[#eceff5] px-4 py-4 text-base text-[#111] placeholder:text-[#636363] focus:border-black focus:outline-none"
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
                                    class="w-full rounded-md border border-[#8b8b8b] bg-[#eceff5] px-4 py-4 text-base text-[#111] placeholder:text-[#636363] focus:border-black focus:outline-none"
                                >
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
                            </div>

                            <div class="pt-3">
                                <button type="submit" class="rounded-xl bg-black px-10 py-3 text-base font-semibold text-white">
                                    Login
                                </button>
                            </div>
                        </form>

                        <p class="mt-16 max-w-[620px] text-sm leading-8 text-[#444]">
                            By joining Limax, you agree to our Terms of Service and acknowledge our Privacy Policy.
                            We may occasionally send you emails about updates and services. Learn how we use your personal data in our Privacy Policy.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <x-auth-footer />
    </div>
</x-guest-layout>
