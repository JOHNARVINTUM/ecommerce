@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
        <p class="mt-2 text-gray-600">Complete your booking details below.</p>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <form action="{{ route('checkout.store', $service->slug) }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="customer_name" class="mb-2 block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', auth()->user()->name) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('customer_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', auth()->user()->email) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('customer_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_phone" class="mb-2 block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('customer_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_address" class="mb-2 block text-sm font-medium text-gray-700">Address</label>
                        <textarea name="customer_address" id="customer_address" rows="3"
                                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('customer_address') }}</textarea>
                        @error('customer_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="scheduled_date" class="mb-2 block text-sm font-medium text-gray-700">Preferred Date</label>
                            <input type="date" name="scheduled_date" id="scheduled_date" value="{{ old('scheduled_date') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('scheduled_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="scheduled_time" class="mb-2 block text-sm font-medium text-gray-700">Preferred Time</label>
                            <input type="time" name="scheduled_time" id="scheduled_time" value="{{ old('scheduled_time') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('scheduled_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="mb-2 block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Tell the provider anything important about your request...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                        Place Order
                        </button>

                        <a href="{{ route('services.show', $service->slug) }}"
                           class="inline-flex items-center rounded-lg border px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900">Order Summary</h2>

                <div class="mt-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Service</p>
                        <p class="font-semibold text-gray-900">{{ $service->title }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Provider</p>
                        <p class="font-semibold text-gray-900">{{ $service->provider->name ?? 'Provider' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="font-semibold text-gray-900">{{ $service->category->name ?? 'General' }}</p>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total</span>
                            <span class="text-2xl font-bold text-gray-900">PHP {{ number_format($service->price, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection