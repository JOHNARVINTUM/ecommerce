@extends('layouts.guest')

@php
    $currencyCode = strtoupper($cartItems->first()['currency'] ?? 'PHP');
    $currencySymbol = match ($currencyCode) {
        'PHP' => '₱',
        'USD' => '$',
        'EUR' => '€',
        default => $currencyCode . ' ',
    };

    $formatMoney = fn ($amount) => $currencySymbol . number_format((float) $amount, 2);
@endphp

@section('content')
<div class="flex min-h-screen w-full flex-col overflow-x-hidden bg-[#f5f5f6] text-[#141414]" style="font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;">
    <header class="sticky top-0 z-40 border-b border-white/5 bg-[#0d0e13]/90 backdrop-blur-md">
        <div class="flex w-full items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('user.home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                LIMAX
            </a>

            <nav class="flex items-center gap-3 text-[11px] text-white/85 sm:gap-8 sm:text-sm">
                <a href="{{ route('services.index') }}" class="transition hover:text-white">Services</a>
                <a href="{{ route('about') }}" class="transition hover:text-white">About Us</a>
                <a href="{{ route('cart.index') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-white/75">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                        <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                        <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </a>
                <a href="{{ route('profile.edit') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">USER</a>
            </nav>
        </div>
    </header>

    <section class="mx-auto w-full max-w-[1440px] flex-1 px-4 py-8 sm:px-6 lg:px-10">
        <a href="{{ route('services.index') }}" class="mb-5 inline-flex items-center gap-2 text-xs font-medium text-[#4f4f57] hover:text-black">
            <span class="text-base">&larr;</span>
            <span>Continue Shopping</span>
        </a>

        @if (session('success'))
            <div class="mb-5 rounded-xl border border-[#b6e7c8] bg-[#d8f6e1] px-4 py-3 text-sm text-[#1f6f3d]">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="space-y-4">
                <div class="rounded-xl border border-[#dfdfe2] bg-white px-5 py-5 sm:px-8 sm:py-6">
                    <div class="flex items-center gap-2 text-[13px] font-medium text-[#2a2a2f]">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#1e1e24]">
                            <path d="M7 6H18L16.8 12.7C16.65 13.5 15.95 14.08 15.14 14.08H9.2C8.39 14.08 7.69 13.5 7.54 12.7L6.5 7.25" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="9.6" cy="17.8" r="1.2" stroke="currentColor" stroke-width="1.4"/>
                            <circle cx="15" cy="17.8" r="1.2" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M4.5 4.8H6.3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                        <span>Shopping Cart ({{ $cartItemCount }} item{{ $cartItemCount === 1 ? '' : 's' }})</span>
                    </div>

                    <div class="mt-4 divide-y divide-[#ececf0]">
                        @forelse ($cartItems as $item)
                            <div class="grid gap-5 py-6 sm:grid-cols-[96px_1fr_auto] sm:items-start">
                                <img src="{{ $item['thumbnail_url'] ?? ('https://picsum.photos/seed/' . $item['slug'] . '/380/240') }}" alt="{{ $item['title'] }}" class="h-[92px] w-[96px] rounded-lg object-cover">

                                <div class="min-w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="truncate text-[15px] font-semibold leading-5 text-[#18181b]">{{ $item['title'] }}</p>
                                            <p class="mt-1 text-xs text-[#75757f]">by {{ $item['provider_name'] }}</p>
                                        </div>
                                        <p class="text-[14px] font-semibold text-[#232328]">{{ $formatMoney($item['item_total']) }}</p>
                                    </div>

                                    <div class="mt-4 flex items-center justify-between gap-2">
                                        <div class="inline-flex items-center gap-2">
                                            <form method="POST" action="{{ route('cart.update-quantity', $item['slug']) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-[#e2e2e6] bg-[#f8f8fb] text-sm text-[#5a5a64]">-</button>
                                            </form>

                                            <span class="inline-flex h-7 min-w-10 items-center justify-center rounded-md bg-[#efeff3] px-3 text-xs font-semibold text-[#33343d]">{{ $item['quantity'] }}</span>

                                            <form method="POST" action="{{ route('cart.update-quantity', $item['slug']) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-[#e2e2e6] bg-[#f8f8fb] text-sm text-[#5a5a64]">+</button>
                                            </form>
                                        </div>

                                        <form method="POST" action="{{ route('cart.destroy', $item['slug']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-medium text-[#ff3d57] hover:text-[#e2334c]">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5">
                                                    <path d="M9.75 4.75H14.25M5.75 7.25H18.25M10.75 10.25V16.25M13.25 10.25V16.25M7.75 7.25L8.2 17.14C8.25 18.12 9.06 18.89 10.04 18.89H13.96C14.94 18.89 15.75 18.12 15.8 17.14L16.25 7.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-10 text-center text-sm text-[#666]">
                                Your cart is empty.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-xl border border-[#dfdfe2] bg-white px-8 py-6">
                    <div class="flex items-center gap-2 text-[13px] font-medium text-[#2a2a2f]">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#1e1e24]">
                            <path d="M4 6.75H20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            <path d="M6.5 4.75V8.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            <path d="M17.5 4.75V8.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            <rect x="4" y="6.75" width="16" height="12.5" rx="2" stroke="currentColor" stroke-width="1.4"/>
                        </svg>
                        <span>Special Instructions</span>
                    </div>
                    <p class="mt-4 text-xs text-[#666674]">Add a note to your order (optional)</p>
                    <textarea rows="4" placeholder="Add a note..." class="mt-3 w-full rounded-lg border border-[#e2e2e6] bg-[#f5f5f8] px-3 py-3 text-sm text-[#333] placeholder:text-[#a0a0aa] focus:border-[#9ea0a8] focus:outline-none"></textarea>
                </div>
            </div>

            <aside class="space-y-4">
                <div class="rounded-xl border border-[#dfdfe2] bg-white px-6 py-6">
                    <h3 class="text-[15px] font-semibold text-[#202026]">Order Summary</h3>

                    <div class="mt-4 space-y-3 text-[14px]">
                        <div class="flex items-center justify-between text-[#35353c]">
                            <span>Subtotal ({{ $cartItemCount }} item{{ $cartItemCount === 1 ? '' : 's' }})</span>
                            <span>{{ $formatMoney($cartSubtotal) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[#35353c]">
                            <span>Tax</span>
                            <span>{{ $formatMoney($cartTax) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[#35353c]">
                            <span>Delivery Time</span>
                            <span>{{ $cartDeliveryDays }} day{{ $cartDeliveryDays === 1 ? '' : 's' }}</span>
                        </div>
                    </div>

                    <div class="mt-4 border-t border-[#ececf0] pt-4">
                        <div class="flex items-center justify-between font-semibold text-[#111217]">
                            <span>Total</span>
                            <span>{{ $formatMoney($cartTotal) }}</span>
                        </div>
                    </div>

                    @if ($cartItems->isNotEmpty())
                        <a href="{{ route('checkout.create', $cartItems->first()['slug']) }}" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#05051b] px-4 py-3 text-xs font-semibold text-white hover:bg-black">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4">
                                <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                            Proceed to Checkout
                        </a>
                    @endif
                </div>

                <div class="rounded-xl border border-[#dfdfe2] bg-white p-5 text-sm text-[#32323a]">
                    <div class="flex items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4a4a53]">
                            <path d="M4.5 12.5L8 9L11.5 12.5L15 9L19.5 13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.5 13.5H19.5V10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p class="text-xs">Fast Delivery Time</p>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4a4a53]">
                            <path d="M12 3L6 5.5V10.5C6 14.65 8.56 18.52 12 20C15.44 18.52 18 14.65 18 10.5V5.5L12 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        </svg>
                        <p class="text-xs">Secured Transaction</p>
                    </div>
                </div>

                <div class="rounded-xl border border-[#dfdfe2] bg-white p-5 text-center text-sm text-[#6f6f78]">
                    <p class="text-xs">"You bring the idea,</p>
                    <p class="text-xs">we'll take it from here"</p>
                    <p class="mt-2 text-[11px] font-semibold tracking-[0.22em] text-[#3a3a43]">LIMAX</p>
                </div>
            </aside>
        </div>
    </section>

</div>
@endsection
