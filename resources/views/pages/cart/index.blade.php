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

    $serviceCategories = \App\Models\ServiceCategory::active()->orderBy('sort_order')->take(6)->get();

    $categoryImages = [
        'programming' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=800&q=80',
        'web-design' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=800&q=80',
        'graphic-design' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=800&q=80',
        'video-editing' => 'https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?auto=format&fit=crop&w=800&q=80',
    ];
    $exampleImage = 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=800&q=80';
@endphp

@section('content')
<div class="w-full overflow-x-hidden bg-[#0e0e12] text-[#141414]" style="font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;">
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
                            <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">USER</a>
                @endauth
            </nav>
        </div>
    </header>

    <section class="mx-auto w-full max-w-[1440px] flex-1 px-4 py-8 sm:px-6 lg:px-10">
        <a href="{{ route('services.index') }}" class="mb-5 inline-flex items-center gap-2 text-xs font-medium text-white/70 hover:text-white">
            <span class="text-base">&larr;</span>
            <span>Continue Shopping</span>
        </a>

        @if (session('success'))
            <div class="mb-5 rounded-xl border border-green-400/30 bg-green-500/15 px-4 py-3 text-sm text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="space-y-4">
                <div class="rounded-xl border border-white/10 bg-white/[0.04] px-5 py-5 sm:px-8 sm:py-6">
                    <div class="flex items-center gap-2 text-[13px] font-medium text-white">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/90">
                            <path d="M7 6H18L16.8 12.7C16.65 13.5 15.95 14.08 15.14 14.08H9.2C8.39 14.08 7.69 13.5 7.54 12.7L6.5 7.25" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="9.6" cy="17.8" r="1.2" stroke="currentColor" stroke-width="1.4"/>
                            <circle cx="15" cy="17.8" r="1.2" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M4.5 4.8H6.3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                        <span>Shopping Cart ({{ $cartItemCount }} item{{ $cartItemCount === 1 ? '' : 's' }})</span>
                    </div>

                    <div class="mt-4 divide-y divide-white/10">
                        @forelse ($cartItems as $item)
                            <div class="grid gap-5 py-6 sm:grid-cols-[96px_1fr_auto] sm:items-start">
                                <img src="{{ $item['thumbnail_url'] ?? ('https://picsum.photos/seed/' . $item['slug'] . '/380/240') }}" alt="{{ $item['title'] }}" class="h-[92px] w-[96px] rounded-lg object-cover">

                                <div class="min-w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="truncate text-[15px] font-semibold leading-5 text-white">{{ $item['title'] }}</p>
                                            <p class="mt-1 text-xs text-white/70">by {{ $item['provider_name'] }}</p>
                                        </div>
                                        <p class="text-[14px] font-semibold text-white">{{ $formatMoney($item['item_total']) }}</p>
                                    </div>

                                    <div class="mt-4 flex items-center justify-between gap-2">
                                        <div class="inline-flex items-center gap-2">
                                            <form method="POST" action="{{ route('cart.update-quantity', $item['slug']) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-white/20 bg-white/5 text-sm text-white/70">-</button>
                                            </form>

                                            <span class="inline-flex h-7 min-w-10 items-center justify-center rounded-md bg-white/10 px-3 text-xs font-semibold text-white">{{ $item['quantity'] }}</span>

                                            <form method="POST" action="{{ route('cart.update-quantity', $item['slug']) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-white/20 bg-white/5 text-sm text-white/70">+</button>
                                            </form>
                                        </div>

                                        <form method="POST" action="{{ route('cart.destroy', $item['slug']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-medium text-red-400 hover:text-red-300">
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

                <div class="rounded-xl border border-white/10 bg-white/[0.04] px-8 py-6">
                    <div class="flex items-center gap-2 text-[13px] font-medium text-white">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/90">
                            <path d="M4 6.75H20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            <path d="M6.5 4.75V8.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            <path d="M17.5 4.75V8.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            <rect x="4" y="6.75" width="16" height="12.5" rx="2" stroke="currentColor" stroke-width="1.4"/>
                        </svg>
                        <span>Special Instructions</span>
                    </div>
                    <p class="mt-4 text-xs text-white/70">Add a note to your order (optional)</p>
                    <textarea rows="4" placeholder="Add a note..." class="mt-3 w-full rounded-lg border border-white/20 bg-white/5 px-3 py-3 text-sm text-white placeholder:text-white/50 focus:border-white/30 focus:outline-none"></textarea>
                </div>

                @if($serviceCategories->count() > 0)
                <div class="rounded-xl border border-white/10 bg-white/[0.04] px-6 py-6">
                    <h3 class="text-[15px] font-semibold text-white">Explore Categories</h3>
                    <p class="mt-1 text-xs text-white/70">Discover more services</p>

                    <div class="mt-5 grid gap-4 grid-cols-3 sm:grid-cols-4 lg:grid-cols-6">
                        @foreach($serviceCategories as $category)
                            @php
                                $cardImage = $categoryImages[$category->slug] ?? $exampleImage;
                            @endphp
                            <a href="{{ route('services.category', $category->slug) }}" class="group block overflow-hidden rounded-lg border border-white/5 transition hover:border-white/20">
                                <div class="overflow-hidden bg-white/5">
                                    <img src="{{ $cardImage }}" alt="{{ $category->name }}" class="h-24 w-full object-cover transition duration-300 group-hover:scale-105">
                                </div>
                                <div class="p-3">
                                    <h4 class="text-xs font-semibold text-white group-hover:text-indigo-400 transition line-clamp-2">{{ $category->name }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-white/10">
                        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-xs font-medium text-indigo-400 hover:text-indigo-300 transition">
                            <span>View all categories</span>
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <aside class="space-y-4">
                <div class="rounded-xl border border-white/10 bg-white/[0.04] px-6 py-6">
                    <h3 class="text-[15px] font-semibold text-white">Order Summary</h3>

                    <div class="mt-4 space-y-3 text-[14px]">
                        <div class="flex items-center justify-between text-white/90">
                            <span>Subtotal ({{ $cartItemCount }} item{{ $cartItemCount === 1 ? '' : 's' }})</span>
                            <span>{{ $formatMoney($cartSubtotal) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-white/90">
                            <span>Tax</span>
                            <span>{{ $formatMoney($cartTax) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-white/90">
                            <span>Delivery Time</span>
                            <span>{{ $cartDeliveryDays }} day{{ $cartDeliveryDays === 1 ? '' : 's' }}</span>
                        </div>
                    </div>

                    <div class="mt-4 border-t border-white/10 pt-4">
                        <div class="flex items-center justify-between font-semibold text-white">
                            <span>Total</span>
                            <span>{{ $formatMoney($cartTotal) }}</span>
                        </div>
                    </div>

                    @if ($cartItems->isNotEmpty())
                        <a href="{{ route('checkout.create', $cartItems->first()['slug']) }}" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-3 text-xs font-semibold text-white hover:bg-indigo-700">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4">
                                <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                            Proceed to Checkout
                        </a>
                    @endif
                </div>

                <div class="rounded-xl border border-white/10 bg-white/[0.04] p-5 text-sm text-white/90">
                    <div class="flex items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/70">
                            <path d="M4.5 12.5L8 9L11.5 12.5L15 9L19.5 13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.5 13.5H19.5V10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p class="text-xs">Fast Delivery Time</p>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/70">
                            <path d="M12 3L6 5.5V10.5C6 14.65 8.56 18.52 12 20C15.44 18.52 18 14.65 18 10.5V5.5L12 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        </svg>
                        <p class="text-xs">Secured Transaction</p>
                    </div>
                </div>

                <div class="rounded-xl border border-white/10 bg-white/[0.04] p-5 text-center text-sm text-white/70">
                    <p class="text-xs">"You bring the idea,</p>
                    <p class="text-xs">we'll take it from here"</p>
                    <p class="mt-2 text-[11px] font-semibold tracking-[0.22em] text-white">LIMAX</p>
                </div>
            </aside>
        </div>
    </section>

</div>
@endsection
