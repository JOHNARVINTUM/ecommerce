@extends('layouts.guest')

@section('content')
<div class="w-full overflow-x-hidden bg-[#0e0e12] text-white">
    <header class="sticky top-0 z-40 border-b border-white/5 bg-[#0d0e13]/90 backdrop-blur-md">
        <div class="flex w-full items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('user.home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                LIMAX
            </a>

            <nav class="flex items-center gap-3 text-[11px] text-white/85 sm:gap-8 sm:text-sm">
                <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'font-semibold text-white' : 'text-white/85' }} transition hover:text-white">Services</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'font-semibold text-white' : 'text-white/85' }} transition hover:text-white">About Us</a>
                @auth
                    <a href="{{ route('cart.index') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-white/75">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                            <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </a>
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                        <button @click="open = ! open" class="flex items-center gap-2 rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg"
                                style="display: none;"
                                @click="open = false">
                            <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white py-1">
                                <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100">
                                    My Profile
                                </a>
                                <a href="{{ route('orders.index') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100">
                                    My Orders
                                </a>
                                <a href="{{ route('cart.index') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100">
                                    My Cart
                                </a>
                                <hr class="my-1 border-gray-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100">
                                        Log out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-white/75">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                            <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">USER</a>
                @endauth
            </nav>
        </div>
    </header>

    <section class="mx-auto w-full max-w-[1440px] px-5 py-10 sm:px-8 lg:px-10">
        <div class="mx-auto max-w-5xl">
            <div class="mb-8 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.28em] text-white/45">Checkout</p>
                    <h1 class="mt-2 text-3xl font-semibold text-white sm:text-4xl">Pay for {{ $service->title }}</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-white/65">
                        This checkout creates your order first, then redirects you to PayMongo Hosted Checkout to complete payment securely.
                    </p>
                </div>

                <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center justify-center rounded-lg border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white/90 transition hover:border-white/30 hover:bg-white/10">
                    Back to Service
                </a>
            </div>

            <div class="space-y-8">
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                    <p class="text-xs uppercase tracking-[0.28em] text-white/45">Order Summary</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">{{ $service->title }}</h2>

                    <div class="mt-6 grid gap-4 text-sm text-white/70 sm:grid-cols-3">
                        <div>
                            <p class="text-xs uppercase tracking-[0.18em] text-white/45">Provider</p>
                            <p class="mt-1 font-medium text-white">{{ $service->provider->name ?? 'Provider' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.18em] text-white/45">Category</p>
                            <p class="mt-1 font-medium text-white">{{ $service->category->name ?? 'General' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.18em] text-white/45">Delivery</p>
                            <p class="mt-1 font-medium text-white">{{ $service->delivery_time_days }} day(s)</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-white/10 pt-5">
                        <div class="flex items-end justify-between gap-4">
                            <span class="text-sm text-white/65">Total Due</span>
                            <span class="text-3xl font-semibold text-white">PHP {{ number_format($service->price, 2) }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('checkout.store', $service->slug) }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                        <h2 class="text-lg font-semibold text-white">Customer details</h2>
                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="customer_name" class="mb-2 block text-sm font-medium text-white/85">Full Name</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/45 focus:border-white/35 focus:ring-white/20">
                                @error('customer_name')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_email" class="mb-2 block text-sm font-medium text-white/85">Email</label>
                                <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/45 focus:border-white/35 focus:ring-white/20">
                                @error('customer_email')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_phone" class="mb-2 block text-sm font-medium text-white/85">Phone Number</label>
                                <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', auth()->user()->profile->phone ?? '') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/45 focus:border-white/35 focus:ring-white/20">
                                @error('customer_phone')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="customer_address" class="mb-2 block text-sm font-medium text-white/85">Address</label>
                                <textarea name="customer_address" id="customer_address" rows="3" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/45 focus:border-white/35 focus:ring-white/20">{{ old('customer_address', auth()->user()->profile->location ?? '') }}</textarea>
                                @error('customer_address')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                        <div class="space-y-4">
                            <p class="text-xs uppercase tracking-[0.24em] text-white/45">Payment Method</p>

                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                @foreach ($paymongoPaymentMethods as $method)
                                    <div class="rounded-xl border border-white/20 bg-white/5 p-4 text-white/90">
                                        <p class="text-sm font-semibold">{{ strtoupper($method) }}</p>
                                        <p class="mt-1 text-sm text-white/65">
                                            You will be redirected to PayMongo Hosted Checkout to finish your payment.
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="rounded-xl border border-amber-300/35 bg-amber-300/10 p-4 text-sm text-amber-100">
                                Clicking continue creates your order with an unpaid status first. Your order is only marked paid after PayMongo confirms the payment by redirect and webhook.
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-8 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                Continue To PayMongo
                            </button>

                            <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center justify-center rounded-lg border border-white/20 bg-white/5 px-8 py-3 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
                                Cancel
                            </a>
                    </div>
                </form>
                </div>
            </div>
    </section>

    <x-auth-footer />
</div>
@endsection
