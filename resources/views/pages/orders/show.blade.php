@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen w-full flex-col overflow-x-hidden bg-[#f2f1eb] text-[#111]">
    <header class="bg-[#1f2024]">
        <div class="flex w-full items-center justify-between px-4 py-4 sm:px-8 lg:px-10">
            <a href="{{ route('user.home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                LIMAX
            </a>

            <nav class="flex items-center gap-3 text-[11px] text-white sm:gap-8 sm:text-sm">
                <a href="{{ route('services.index') }}" class="hover:text-slate-300">Services</a>
                <a href="{{ route('about') }}" class="hover:text-slate-300">About Us</a>
                <a href="{{ route('orders.index') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-slate-300">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                        <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                        <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-xl bg-white px-4 py-2 font-semibold text-black">Log out</button>
                </form>
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
