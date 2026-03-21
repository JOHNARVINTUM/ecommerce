@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen w-full flex-col overflow-x-hidden bg-[#f2f1eb] text-[#111]">
    <header class="sticky top-0 z-40 border-b border-white/5 bg-[#0d0e13]/90 backdrop-blur-md">
        <div class="flex w-full items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('user.home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                LIMAX
            </a>

            <nav class="flex items-center gap-3 text-[11px] text-white/85 sm:gap-8 sm:text-sm">
                <a href="{{ route('services.index') }}" class="transition hover:text-white">Services</a>
                <a href="{{ route('about') }}" class="transition hover:text-white">About Us</a>
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
                            <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">USER</a>
                @endauth
            </nav>
        </div>
    </header>

    <section class="flex-1 px-5 py-10 sm:px-8 lg:px-10">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
                <p class="mt-2 text-gray-600">Review your booking information.</p>
            </div>
            <a href="{{ route('orders.index') }}" class="rounded-lg border border-[#d8d7d0] bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-[#f8f8f4]">
                Back to My Orders
            </a>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <div class="rounded-2xl border border-[#d8d7d0] bg-white p-6 shadow-[0_8px_18px_rgba(0,0,0,0.06)]">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Booking Info</h2>
                <div class="space-y-3 text-sm text-gray-700">
                    <p><span class="font-semibold">Order Number:</span> {{ $order->order_number }}</p>
                    <p><span class="font-semibold">Service:</span> {{ $order->serviceListing->title ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Provider:</span> {{ $order->provider->name ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Amount:</span> PHP {{ number_format($order->amount, 2) }}</p>
                    <p><span class="font-semibold">Status:</span> {{ $order->status_label }}</p>
                    <p><span class="font-semibold">Payment Status:</span> {{ ucfirst($order->payment_status) }}</p>
                    <p><span class="font-semibold">Preferred Date:</span> {{ $order->scheduled_date ? $order->scheduled_date->format('M d, Y') : 'Not set' }}</p>
                    <p><span class="font-semibold">Preferred Time:</span> {{ $order->scheduled_time ?? 'Not set' }}</p>
                </div>
            </div>

            <div class="rounded-2xl border border-[#d8d7d0] bg-white p-6 shadow-[0_8px_18px_rgba(0,0,0,0.06)]">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Customer Info</h2>
                <div class="space-y-3 text-sm text-gray-700">
                    <p><span class="font-semibold">Name:</span> {{ $order->customer_name }}</p>
                    <p><span class="font-semibold">Email:</span> {{ $order->customer_email }}</p>
                    <p><span class="font-semibold">Phone:</span> {{ $order->customer_phone ?: 'N/A' }}</p>
                    <p><span class="font-semibold">Address:</span> {{ $order->customer_address ?: 'N/A' }}</p>
                    <p><span class="font-semibold">Notes:</span> {{ $order->notes ?: 'N/A' }}</p>
                </div>
            </div>
        </div>

    </section>

    <x-auth-footer />
</div>
@endsection
