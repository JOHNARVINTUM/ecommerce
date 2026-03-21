@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen w-full flex-col overflow-x-hidden bg-[#f3f3f3] text-[#111]">
    <header class="bg-[#1f2024]">
        <div class="flex w-full items-center justify-between px-4 py-4 sm:px-8 lg:px-10">
            <a href="{{ route('user.home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                LIMAX
            </a>

            <nav class="flex items-center gap-3 text-[11px] text-white sm:gap-8 sm:text-sm">
                <a href="{{ route('services.index') }}" class="hover:text-slate-300">Services</a>
                <a href="{{ route('about') }}" class="hover:text-slate-300">About Us</a>
                <a href="{{ route('cart.index') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-slate-300">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                        <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                        <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </a>
                <a href="{{ route('profile.edit') }}" class="rounded-lg bg-white px-3 py-1.5 font-semibold text-black">USER</a>
            </nav>
        </div>
    </header>

    <section class="mx-auto w-full max-w-[1280px] flex-1 px-5 py-10 sm:px-8 lg:px-10">
        <a href="{{ route('services.index') }}" class="mb-6 inline-flex items-center gap-2 text-sm text-[#555] hover:text-black">
            <span>&larr;</span>
            Continue Shopping
        </a>

        @if (session('success'))
            <div class="mb-5 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_340px]">
            <div class="space-y-5">
                <div class="rounded-2xl border border-[#d9d9d9] bg-[#fbfbfb] p-5">
                    <h2 class="text-base font-semibold text-[#1f1f1f]">Shopping Cart ({{ $cartItemCount }} item{{ $cartItemCount === 1 ? '' : 's' }})</h2>

                    <div class="mt-4 divide-y divide-[#ececec]">
                        @forelse ($cartItems as $item)
                            <div class="grid gap-4 py-5 sm:grid-cols-[86px_1fr_auto] sm:items-start">
                                <img src="https://picsum.photos/seed/{{ $item['slug'] }}/172/120" alt="{{ $item['title'] }}" class="h-20 w-[86px] rounded-lg object-cover">

                                <div>
                                    <p class="text-base font-medium text-[#1f1f1f]">{{ $item['title'] }}</p>
                                    <p class="text-sm text-[#7c7c7c]">by {{ $item['provider_name'] }}</p>

                                    <div class="mt-3 inline-flex items-center gap-2">
                                        <form method="POST" action="{{ route('cart.update-quantity', $item['slug']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" class="h-8 w-8 rounded-md border border-[#ddd] text-[#555]">-</button>
                                        </form>
                                        <span class="inline-flex h-8 min-w-10 items-center justify-center rounded-md bg-[#f3f3f5] px-3 text-sm font-semibold">{{ $item['quantity'] }}</span>
                                        <form method="POST" action="{{ route('cart.update-quantity', $item['slug']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" class="h-8 w-8 rounded-md border border-[#ddd] text-[#555]">+</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-sm font-semibold text-[#1f1f1f]">{{ $item['currency'] }} {{ number_format($item['item_total'], 2) }}</p>
                                    <form method="POST" action="{{ route('cart.destroy', $item['slug']) }}" class="mt-10">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-rose-500 hover:text-rose-600">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="py-10 text-center text-sm text-[#666]">
                                Your cart is empty.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-[#d9d9d9] bg-[#fbfbfb] p-5">
                    <h3 class="text-base font-semibold text-[#1f1f1f]">Special Instructions</h3>
                    <p class="mt-3 text-sm text-[#666]">Add a note to your order (optional)</p>
                    <textarea rows="4" placeholder="Add a note..." class="mt-3 w-full rounded-lg border border-[#e2e2e2] bg-[#f5f5f7] px-3 py-3 text-sm text-[#333] focus:border-[#9ca3af] focus:outline-none"></textarea>
                </div>
            </div>

            <aside class="space-y-4">
                <div class="rounded-2xl border border-[#d9d9d9] bg-[#fbfbfb] p-5">
                    <h3 class="text-base font-semibold text-[#1f1f1f]">Order Summary</h3>

                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex items-center justify-between text-[#303030]">
                            <span>Subtotal ({{ $cartItemCount }} item{{ $cartItemCount === 1 ? '' : 's' }})</span>
                            <span>?{{ number_format($cartSubtotal, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[#303030]">
                            <span>Tax</span>
                            <span>?{{ number_format($cartTax, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[#303030]">
                            <span>Delivery Time</span>
                            <span>{{ $cartDeliveryDays }} day{{ $cartDeliveryDays === 1 ? '' : 's' }}</span>
                        </div>
                    </div>

                    <div class="mt-4 border-t border-[#ebebeb] pt-4">
                        <div class="flex items-center justify-between font-semibold text-[#111]">
                            <span>Total</span>
                            <span>?{{ number_format($cartTotal, 2) }}</span>
                        </div>
                    </div>

                    @if ($cartItems->isNotEmpty())
                        <a href="{{ route('checkout.create', $cartItems->first()['slug']) }}" class="mt-5 inline-flex w-full items-center justify-center rounded-lg bg-[#05051b] px-4 py-3 text-sm font-semibold text-white hover:bg-black">
                            Proceed to Checkout
                        </a>
                    @endif
                </div>

                <div class="rounded-2xl border border-[#d9d9d9] bg-[#fbfbfb] p-5 text-sm text-[#333]">
                    <p>Fast Delivery Time</p>
                    <p class="mt-3">Secured Transaction</p>
                </div>

                <div class="rounded-2xl border border-[#d9d9d9] bg-[#fbfbfb] p-5 text-center text-sm text-[#555]">
                    <p>"You bring the idea,</p>
                    <p>we'll take it from here"</p>
                    <p class="mt-2 font-semibold text-[#222]">- LIMAX</p>
                </div>
            </aside>
        </div>
    </section>

    <x-auth-footer />
</div>
@endsection
