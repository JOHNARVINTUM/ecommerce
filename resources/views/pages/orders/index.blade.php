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
                <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                <p class="mt-2 text-gray-600">Track all your bookings in one place.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-[#d8d7d0] bg-white shadow-[0_8px_18px_rgba(0,0,0,0.06)]">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Provider</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $order->serviceListing->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $order->provider->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">PHP {{ number_format($order->amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ !in_array($order->status, ['completed', 'pending']) ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-800">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('orders.show', $order) }}" class="font-medium text-indigo-600 hover:text-indigo-800">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No orders found yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </section>

    <x-auth-footer />
</div>
@endsection
