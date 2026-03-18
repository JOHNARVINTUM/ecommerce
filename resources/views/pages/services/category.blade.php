@extends('layouts.guest')

@php
    $heroImage = 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1800&q=80';
    $categoryImages = [
        'programming' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=1200&q=80',
        'web-design' => 'https://images.unsplash.com/photo-1517336714739-489689fd1ca8?auto=format&fit=crop&w=1200&q=80',
        'graphic-design' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80',
        'video-editing' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=1200&q=80',
        'photo-editing' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
        'logo-making' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1200&q=80',
    ];
@endphp

@section('content')
    <div class="min-h-screen w-full overflow-x-hidden bg-[#f2f1eb] text-[#111]">
        <header class="bg-[#1f2024]">
            <div class="flex w-full items-center justify-between px-4 py-4 sm:px-8 lg:px-10">
                <a href="{{ route('home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                    LIMAX
                </a>

                <nav class="flex items-center gap-3 text-[11px] text-white sm:gap-8 sm:text-sm">
                    <a href="{{ route('services.index') }}" class="hover:text-slate-300">Services</a>
                    <a href="{{ route('about') }}" class="hover:text-slate-300">About Us</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-white px-3 py-1.5 font-semibold text-black">USER</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg bg-white px-3 py-1.5 font-semibold text-black">USER</a>
                    @endauth
                </nav>
            </div>
        </header>

        <section class="relative overflow-hidden bg-black">
            <img src="{{ $categoryImages[$category->slug] ?? $heroImage }}" alt="{{ $category->name }}" class="h-[180px] w-full object-cover sm:h-[220px]">
            <div class="absolute inset-0 bg-black/55"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center px-6 text-center text-white">
                <h1 class="text-4xl font-bold sm:text-6xl">{{ $category->name }}</h1>
                <p class="mt-3 text-sm sm:text-lg">{{ $category->headline ?: 'Technology-driven services delivered by skilled IT professionals.' }}</p>
            </div>
        </section>

        <section class="px-5 py-10 sm:px-8 lg:px-10">
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-2xl font-bold sm:text-3xl">{{ $category->name }} Posts</h2>
                <a href="{{ route('services.index') }}" class="rounded-lg border border-[#d8d7d0] bg-white px-4 py-2 text-sm font-semibold hover:bg-[#f8f8f4]">
                    Back to Categories
                </a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse($services as $service)
                    @php
                        $serviceImage = $categoryImages[$service->category->slug ?? ''] ?? $heroImage;
                    @endphp
                    <article class="overflow-hidden rounded-xl border border-[#d8d7d0] bg-white shadow-[0_8px_18px_rgba(0,0,0,0.06)]">
                        <img src="{{ $serviceImage }}" alt="{{ $service->title }}" class="h-44 w-full object-cover">
                        <div class="p-4">
                            <h3 class="text-2xl font-semibold">{{ $service->title }}</h3>
                            <p class="mt-2 min-h-[72px] text-sm leading-6 text-[#696969]">
                                {{ $service->short_description ?: \Illuminate\Support\Str::limit($service->description, 90) }}
                            </p>
                            <div class="mt-3 text-sm font-medium text-[#111]">
                                {{ $service->currency }} {{ number_format($service->price, 2) }}
                            </div>
                            <a href="{{ route('services.show', $service) }}" class="mt-4 inline-flex items-center text-sm font-semibold text-[#111]">
                                See More
                                <span class="ml-1">></span>
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="text-base text-[#5a5a5a]">No service posts found for this category.</p>
                @endforelse
            </div>

            @if ($services->hasPages())
                <div class="mt-8">
                    {{ $services->links() }}
                </div>
            @endif
        </section>

        <x-auth-footer />
    </div>
@endsection
