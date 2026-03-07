@extends('layouts.app')
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <div class="md:col-span-2">
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <p class="mb-2 text-sm text-gray-500">Service Details</p>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $service->title }}</h1>
                    </div>

                    <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-700">
                        {{ $service->category->name ?? 'General' }}
                    </span>
                </div>

                <div class="mb-6">
                    <p class="text-gray-700 leading-7">
                        {{ $service->description }}
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-sm text-gray-500">Price</p>
                        <p class="text-2xl font-bold text-gray-900">PHP {{ number_format($service->price, 2) }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-sm text-gray-500">Provider</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $service->provider->name ?? 'Provider' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900">Book this service</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Secure your booking by filling out the checkout form.
                </p>

                <div class="mt-6">
                    <a href="{{ route('checkout.create', $service->slug) }}"
                       class="inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                        Book Now
                    </a>
                </div>

                <div class="mt-3">
                    <a href="{{ route('services.index') }}"
                       class="inline-flex w-full items-center justify-center rounded-lg border px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Back to Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection