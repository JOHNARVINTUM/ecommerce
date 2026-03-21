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
                            <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">USER</a>
                @endauth
            </nav>
        </div>
    </header>

    <section class="flex-1 px-5 py-8 sm:px-8 lg:px-10">
        <div class="mx-auto max-w-7xl">
            <div class="mb-8 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.28em] text-[#8b8b84]">Checkout</p>
                    <h1 class="mt-2 text-3xl font-semibold text-[#1d1d1d] sm:text-4xl">Pay for {{ $service->title }}</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-[#666]">
                        This checkout uses your provided PayMongo hosted checkout URL as a demo payment step. The PayMongo page opens in a new tab, then this form records the order as paid for simulation purposes.
                    </p>
                </div>

                <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center justify-center rounded-sm border border-[#9f9f9a] bg-white px-5 py-3 text-sm font-semibold text-[#222] hover:bg-[#ecece7]">
                    Back to Service
                </a>
            </div>

            <div class="max-w-4xl">
                <div class="space-y-8">
                    <div class="rounded-2xl border border-[#d6d5ce] bg-white p-6 shadow-[0_18px_40px_rgba(0,0,0,0.06)]">
                        <p class="text-xs uppercase tracking-[0.28em] text-[#8b8b84]">Order Summary</p>
                        <h2 class="mt-2 text-2xl font-semibold text-[#1d1d1d]">{{ $service->title }}</h2>

                        <div class="mt-6 space-y-4 text-sm text-[#555]">
                            <div>
                                <p class="text-xs uppercase tracking-[0.18em] text-[#8b8b84]">Provider</p>
                                <p class="mt-1 font-medium text-[#111]">{{ $service->provider->name ?? 'Provider' }}</p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-[0.18em] text-[#8b8b84]">Category</p>
                                <p class="mt-1 font-medium text-[#111]">{{ $service->category->name ?? 'General' }}</p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-[0.18em] text-[#8b8b84]">Delivery</p>
                                <p class="mt-1 font-medium text-[#111]">{{ $service->delivery_time_days }} day(s)</p>
                            </div>
                        </div>

                        <div class="mt-6 border-t border-[#e1e0d8] pt-5">
                            <div class="flex items-end justify-between gap-4">
                                <span class="text-sm text-[#666]">Total Due</span>
                                <span class="text-3xl font-semibold text-[#1d1d1d]">PHP {{ number_format($service->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('checkout.store', $service->slug) }}" method="POST" class="space-y-8">
                        @csrf

                        <div>
                            <h2 class="text-lg font-semibold text-[#1d1d1d]">Customer details</h2>
                            <div class="mt-5 grid gap-5 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label for="customer_name" class="mb-2 block text-sm font-medium text-[#333]">Full Name</label>
                                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">
                                    @error('customer_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_email" class="mb-2 block text-sm font-medium text-[#333]">Email</label>
                                    <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">
                                    @error('customer_email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_phone" class="mb-2 block text-sm font-medium text-[#333]">Phone Number</label>
                                    <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', auth()->user()->profile->phone ?? '') }}" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">
                                    @error('customer_phone')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="customer_address" class="mb-2 block text-sm font-medium text-[#333]">Address</label>
                                    <textarea name="customer_address" id="customer_address" rows="3" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">{{ old('customer_address', auth()->user()->profile->location ?? '') }}</textarea>
                                    @error('customer_address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-[#d6d5ce] bg-[#f6f5ef] p-5">
                            <div class="space-y-4">
                                <p class="text-xs uppercase tracking-[0.24em] text-[#8b8b84]">Payment Method</p>

<div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <label class="flex items-center gap-2 rounded-xl border p-3 bg-white">
                                            <input type="radio" name="payment_method" value="gcash_demo" @checked(old('payment_method') === 'gcash_demo')>
                                            <span class="text-sm font-medium">Gcash</span>
                                        </label>
                                        <label class="flex items-center gap-2 rounded-xl border p-3 bg-white">
                                            <input type="radio" name="payment_method" value="maya_demo" @checked(old('payment_method', 'gcash_demo') === 'maya_demo' ? 'maya_demo' : 'gcash_demo')>
                                            <span class="text-sm font-medium">Maya</span>
                                    </label>
                                </div>

                                <div id="billing-details" class="rounded-xl border border-[#d2d2cd] bg-white p-4 hidden">
                                    <h3 class="text-sm font-semibold text-[#1d1d1d]">Billing Details</h3>
                                    <p class="mt-2 text-sm text-[#666]">Please enter any billing notes or payment reference here.</p>

                                    <div class="mt-3 grid gap-3 md:grid-cols-2">
                                        <div>
                                            <label for="billing_name" class="mb-2 block text-sm font-medium text-[#333]">Billing Name</label>
                                            <input type="text" name="billing_name" id="billing_name" value="{{ old('billing_name', auth()->user()->name) }}" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">
                                        </div>
                                        <div>
                                            <label for="billing_phone" class="mb-2 block text-sm font-medium text-[#333]">Billing Phone</label>
                                            <input type="text" name="billing_phone" id="billing_phone" value="{{ old('billing_phone', auth()->user()->phone ?? '') }}" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label for="billing_address" class="mb-2 block text-sm font-medium text-[#333]">Billing Address</label>
                                            <input type="text" name="billing_address" id="billing_address" value="{{ old('billing_address', auth()->user()->profile->location ?? '') }}" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">
                                        </div>
                                    </div>
                                </div>

                                <div id="simulation-instruction" class="rounded-xl border border-[#e2d8b5] bg-[#fff8dd] p-4 text-sm text-[#6a5830]">
                                    Select a payment method to see instructions and complete the simulator flow.
                                </div>
                            </div>

                            <label class="mt-5 flex items-start gap-3 rounded-xl border border-[#d2d2cd] bg-white p-4 text-sm text-[#333]">
                                <input type="checkbox" name="simulate_payment_confirmation" value="1" @checked(old('simulate_payment_confirmation')) class="mt-1 rounded border-[#bcbcb5] text-[#111] focus:ring-[#111]">
                                <span>
                                    I completed the selected payment simulator and I want this order recorded as paid for simulation purposes.
                                </span>
                            </label>
                            @error('simulate_payment_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <script>
                            function updateSimulatorInfo() {
                                const method = document.querySelector('input[name="payment_method"]:checked')?.value;
                                const billingDetails = document.getElementById('billing-details');
                                const simInstr = document.getElementById('simulation-instruction');

                                if (!method) {
                                    billingDetails.classList.add('hidden');
                                    simInstr.textContent = 'Please choose a payment method to continue.';
                                    return;
                                }

                                billingDetails.classList.remove('hidden');

                                if (method === 'gcash_demo') {
                                    simInstr.innerHTML = 'Use <strong>Gcash</strong> simulator by sending to number <strong>09171112222</strong>. After completing, come back and check the box below.';
                                } else {
                                    simInstr.innerHTML = 'Use <strong>Maya</strong> simulator by sending to number <strong>09181113333</strong>. After completing, come back and check the box below.';
                                }
                            }

                            document.querySelectorAll('input[name="payment_method"]').forEach(el => {
                                el.addEventListener('change', updateSimulatorInfo);
                            });

                            updateSimulatorInfo();
                        </script>

                        <div class="flex flex-col gap-3 sm:flex-row">
                            <button type="submit" class="inline-flex items-center justify-center rounded-sm bg-[#111] px-8 py-3 text-sm font-semibold text-white hover:bg-black">
                                Simulate Payment And Place Order
                            </button>

                            <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center justify-center rounded-sm border border-[#3a3a3a] px-8 py-3 text-sm font-semibold text-[#222] hover:bg-[#ecece7]">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection