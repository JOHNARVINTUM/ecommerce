@extends('layouts.guest')

@section('content')
    <section class="bg-white py-16">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                <p class="text-sm text-slate-500">
                    {{ $service->category->name ?? 'Uncategorized' }}
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                    {{ $service->title }}
                </h1>

                <p class="mt-4 text-lg font-semibold text-slate-900">
                    ₱{{ number_format($service->price, 2) }}
                </p>

                @if($service->short_description)
                    <p class="mt-4 text-lg text-slate-600">
                        {{ $service->short_description }}
                    </p>
                @endif

                <p class="mt-6 text-slate-700">
                    {{ $service->description }}
                </p>

                <div class="mt-8 grid gap-4 border-t border-slate-200 pt-6 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-slate-500">Provider</p>
                        <p class="font-semibold text-slate-900">
                            {{ $service->provider->name ?? 'Unknown Provider' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Delivery Time</p>
                        <p class="font-semibold text-slate-900">
                            {{ $service->delivery_time_days ? $service->delivery_time_days . ' days' : 'Not specified' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Revisions</p>
                        <p class="font-semibold text-slate-900">
                            {{ $service->revisions ?? 'Not specified' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Rating</p>
                        <p class="font-semibold text-slate-900">
                            {{ number_format((float) $service->rating_avg, 2) }} ({{ $service->rating_count ?? 0 }} reviews)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
