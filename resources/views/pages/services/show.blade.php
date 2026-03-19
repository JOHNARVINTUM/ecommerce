@extends('layouts.guest')

@php
    $categoryImages = [
        'programming' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=1400&q=80',
        'web-design' => 'https://images.unsplash.com/photo-1517336714739-489689fd1ca8?auto=format&fit=crop&w=1400&q=80',
        'graphic-design' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1400&q=80',
        'video-editing' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=1400&q=80',
        'photo-editing' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&q=80',
        'logo-making' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1400&q=80',
    ];

    $mainImage = $categoryImages[$service->category->slug ?? ''] ?? 'https://images.unsplash.com/photo-1518773553398-650c184e0bb3?auto=format&fit=crop&w=1400&q=80';
    $gallery = [$mainImage, $mainImage, $mainImage, $mainImage, $mainImage];
    $providerInitials = collect(explode(' ', $service->provider->name ?? 'P'))
        ->filter()
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->take(2)
        ->implode('');
    $providerSince = $service->provider?->created_at?->format('M Y') ?? 'N/A';
    $deliveryText = $service->delivery_time_days ? $service->delivery_time_days . ' day(s)' : 'Flexible';
    $revisionText = $service->revisions ? $service->revisions . ' revision(s)' : 'Flexible';
@endphp

@section('content')
    <div class="flex min-h-screen w-full flex-col overflow-x-hidden bg-[#f2f1eb] text-[#111]">
        <header class="bg-[#1f2024]">
            <div class="flex w-full items-center justify-between px-4 py-4 sm:px-8 lg:px-10">
                <a href="{{ auth()->check() ? route('user.home') : route('home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                    LIMAX
                </a>

                <nav class="flex items-center gap-3 text-[11px] text-white sm:gap-8 sm:text-sm">
                    <a href="{{ route('services.index') }}" class="hover:text-slate-300">Services</a>
                    <a href="{{ route('about') }}" class="hover:text-slate-300">About Us</a>
                    @auth
                        <a href="{{ route('orders.index') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-slate-300">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="rounded-lg bg-white px-3 py-1.5 font-semibold text-black">USER</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg bg-white px-3 py-1.5 font-semibold text-black">USER</a>
                    @endauth
                </nav>
            </div>
        </header>

        <section class="flex-1 px-5 py-8 sm:px-8 lg:px-10">
            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-7 text-xs text-[#8a8a8a] sm:text-sm">
                <a href="{{ route('home') }}" class="hover:text-black">Homepage</a>
                <span class="mx-2">></span>
                <a href="{{ route('services.index') }}" class="hover:text-black">Service</a>
                <span class="mx-2">></span>
                <span class="font-semibold text-[#3a3a3a]">{{ $service->category->name ?? 'General' }}</span>
            </div>

            <div class="grid gap-8 xl:grid-cols-[1.05fr_0.95fr]">
                <div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#7d4f34] text-sm font-bold text-white">
                            {{ $providerInitials }}
                        </div>
                        <div>
                            <p class="text-lg font-semibold">{{ $service->provider->name ?? 'Provider' }}</p>
                            <p class="text-sm text-[#7b7b7b]">Expert in {{ $service->category->name ?? 'General' }}</p>
                            <div class="mt-1 flex items-center gap-2 text-xs text-[#7b7b7b]">
                                <span class="text-amber-500">{{ str_repeat('★', max(1, min(5, (int) round($service->rating_avg ?: 0)))) }}</span>
                                <span>({{ $service->rating_count }})</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 overflow-hidden rounded-sm border border-[#d2d2cd] bg-black">
                        <img src="{{ $mainImage }}" alt="Service preview" class="h-[300px] w-full object-cover sm:h-[420px]">
                    </div>

                    <div class="mt-3 grid grid-cols-5 gap-2">
                        @foreach ($gallery as $image)
                            <div class="overflow-hidden rounded-sm border border-[#d2d2cd]">
                                <img src="{{ $image }}" alt="Service gallery" class="h-14 w-full object-cover sm:h-20">
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 rounded-sm border border-[#9f9f9a] bg-[#f4f4ef] p-5">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-[#6f6f6f]">Get to know {{ $service->provider->name ?? 'the provider' }}</h2>
                        <div class="mt-4 grid gap-3 text-sm text-[#444] sm:grid-cols-2">
                            <p><span class="font-semibold">From:</span> Philippines</p>
                            <p><span class="font-semibold">Member since:</span> {{ $providerSince }}</p>
                            <p><span class="font-semibold">Delivery:</span> {{ $deliveryText }}</p>
                            <p><span class="font-semibold">Revisions:</span> {{ $revisionText }}</p>
                            <p><span class="font-semibold">Languages:</span> English</p>
                        </div>
                        <p class="mt-4 border-t border-[#b6b6b1] pt-4 text-sm leading-6 text-[#666]">
                            {{ \Illuminate\Support\Str::limit($service->short_description ?: $service->description, 230) }}
                        </p>
                    </div>
                </div>

                <aside>
                    <p class="text-xs text-[#8a8a8a]">{{ $service->provider->name ?? 'Provider' }}</p>
                    <h1 class="mt-1 text-4xl font-medium leading-tight text-[#262626]">{{ $service->title }}</h1>

                    <div class="mt-4 flex items-end justify-between border-b border-[#d0d0cb] pb-4">
                        <p class="text-4xl font-semibold text-[#1f1f1f]">{{ $service->currency }}{{ number_format($service->price, 2) }}</p>
                        <p class="text-sm text-[#707070]">{{ $service->sold_count }} Sold</p>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-lg font-semibold">Description:</h2>
                        <p class="mt-2 text-sm leading-7 text-[#666]">{{ $service->description }}</p>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="mailto:{{ $service->provider->email ?? '' }}" class="inline-flex items-center justify-center rounded-sm border border-[#3a3a3a] px-8 py-3 text-sm font-semibold hover:bg-[#ecece7]">
                            Contact me
                        </a>
                        <a href="{{ route('checkout.create', $service->slug) }}" class="inline-flex items-center justify-center rounded-sm bg-[#111] px-8 py-3 text-sm font-semibold text-white hover:bg-black">
                            Add To Cart
                        </a>
                    </div>
                </aside>
            </div>
        </section>

        <x-auth-footer />
    </div>
@endsection