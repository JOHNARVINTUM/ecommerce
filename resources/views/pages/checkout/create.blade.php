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
                <a href="{{ route('orders.index') }}" class="transition hover:text-white">My Orders</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">Log out</button>
                </form>
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

            <div class="grid gap-8 xl:grid-cols-[1.05fr_0.95fr]">
                <div class="rounded-2xl border border-[#d6d5ce] bg-white p-6 shadow-[0_18px_40px_rgba(0,0,0,0.06)] sm:p-8">
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
                                    <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">
                                    @error('customer_phone')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="customer_address" class="mb-2 block text-sm font-medium text-[#333]">Address</label>
                                    <textarea name="customer_address" id="customer_address" rows="3" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">{{ old('customer_address') }}</textarea>
                                    @error('customer_address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="scheduled_date" class="mb-2 block text-sm font-medium text-[#333]">Preferred Date</label>
                                    <input type="date" name="scheduled_date" id="scheduled_date" value="{{ old('scheduled_date') }}" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">
                                    @error('scheduled_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="scheduled_time" class="mb-2 block text-sm font-medium text-[#333]">Preferred Time</label>
                                    <input type="time" name="scheduled_time" id="scheduled_time" value="{{ old('scheduled_time') }}" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]">
                                    @error('scheduled_time')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="notes" class="mb-2 block text-sm font-medium text-[#333]">Notes</label>
                                    <textarea name="notes" id="notes" rows="4" class="w-full rounded-xl border border-[#d2d2cd] bg-[#fafaf7] px-4 py-3 text-sm text-[#111] focus:border-[#111] focus:ring-[#111]" placeholder="Tell the provider anything important about your request...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-[#d6d5ce] bg-[#f6f5ef] p-5">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.24em] text-[#8b8b84]">Payment Method</p>
                                    <h2 class="mt-2 text-lg font-semibold text-[#1d1d1d]">PayMongo Hosted Checkout Demo</h2>
                                    <p class="mt-2 max-w-xl text-sm leading-6 text-[#666]">
                                        Open the PayMongo checkout in a new tab, review the card or e-wallet options, then return here to complete the simulated payment and booking.
                                    </p>
                                </div>

                                <a href="{{ $paymongoCheckoutUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-sm bg-[#111] px-5 py-3 text-sm font-semibold text-white hover:bg-black">
                                    Open PayMongo Checkout
                                </a>
                            </div>

                            <input type="hidden" name="payment_method" value="paymongo_checkout_demo">

                            <div class="mt-5 rounded-xl border border-[#e2d8b5] bg-[#fff8dd] p-4 text-sm text-[#6a5830]">
                                Demo note: the hosted PayMongo page is an external simulation link and may show a fixed product name or amount. Your Limax order total below still uses the selected service price.
                            </div>

                            <label class="mt-5 flex items-start gap-3 rounded-xl border border-[#d2d2cd] bg-white p-4 text-sm text-[#333]">
                                <input type="checkbox" name="simulate_payment_confirmation" value="1" @checked(old('simulate_payment_confirmation')) class="mt-1 rounded border-[#bcbcb5] text-[#111] focus:ring-[#111]">
                                <span>
                                    I opened or reviewed the PayMongo checkout demo and I want this order recorded as paid for simulation purposes.
                                </span>
                            </label>
                            @error('simulate_payment_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

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

                <aside class="space-y-6">
                    <div class="rounded-2xl border border-[#d6d5ce] bg-white p-6 shadow-[0_18px_40px_rgba(0,0,0,0.06)]">
                        <p class="text-xs uppercase tracking-[0.24em] text-[#8b8b84]">Order Summary</p>
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

                    <div class="rounded-2xl border border-[#d6d5ce] bg-[#111] p-6 text-white shadow-[0_18px_40px_rgba(0,0,0,0.18)]">
                        <p class="text-xs uppercase tracking-[0.24em] text-white/60">Simulation Flow</p>
                        <ol class="mt-4 space-y-3 text-sm leading-6 text-white/85">
                            <li>1. Open the PayMongo hosted checkout demo.</li>
                            <li>2. Return to this page after reviewing the payment screen.</li>
                            <li>3. Submit the form to store the order as paid in this Laravel app.</li>
                        </ol>
                    </div>
                </aside>
            </div>
        </div>
    </section>

</div>
@endsection