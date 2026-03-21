@extends('layouts.guest')

@php
    $exampleImage = 'https://picsum.photos/seed/services-example/1400/900';
    $heroImage = $exampleImage;
@endphp

@section('content')
    <style>
        .svc-reveal {
            opacity: 0;
            transform: translateY(36px);
            transition: opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1);
        }
        .svc-reveal.svc-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .svc-card {
            transition: transform .35s cubic-bezier(.16,1,.3,1), box-shadow .35s ease, border-color .35s ease;
        }
        .svc-card:hover {
            transform: translateY(-8px);
            border-color: rgba(167, 139, 250, 0.45);
            box-shadow: 0 24px 44px rgba(2, 6, 23, 0.35);
        }
        .svc-card:hover .svc-image {
            transform: scale(1.06);
        }
        .svc-image {
            transition: transform .5s cubic-bezier(.16,1,.3,1);
        }
    </style>

    <div class="min-h-screen w-full overflow-x-hidden bg-[#0d0e13] text-white">
        <header class="sticky top-0 z-40 border-b border-white/5 bg-[#0d0e13]/90 backdrop-blur-md">
            <div class="flex w-full items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ auth()->check() ? route('user.home') : route('home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                    LIMAX
                </a>

                <nav class="flex items-center gap-3 text-[11px] text-white/85 sm:gap-8 sm:text-sm">
                    <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'font-semibold text-white' : 'text-white/85' }} transition hover:text-white">Services</a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'font-semibold text-white' : 'text-white/85' }} transition hover:text-white">About Us</a>
                    @auth
                        <a href="{{ route('cart.index') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-white/75">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">USER</a>
                    @else
                        <a href="{{ route('login') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-white/75">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">USER</a>
                    @endauth
                </nav>
            </div>
        </header>

        <section class="relative isolate overflow-hidden border-b border-white/5 bg-black">
            <div class="absolute -left-24 top-8 h-72 w-72 rounded-full bg-violet-600/35 blur-[90px]"></div>
            <div class="absolute -right-12 bottom-0 h-72 w-72 rounded-full bg-indigo-500/25 blur-[100px]"></div>
            <img src="{{ $heroImage }}" alt="{{ $category->name }}" class="h-[280px] w-full object-cover opacity-35 sm:h-[360px]">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0d0e13]/30 via-[#0d0e13]/65 to-[#0d0e13]"></div>
            <div class="absolute inset-0 mx-auto flex w-full max-w-[1440px] flex-col items-start justify-center px-5 text-left sm:px-8 lg:px-10">
                <p class="svc-reveal mb-3 text-xs font-semibold uppercase tracking-[0.24em] text-white/60">Category Focus</p>
                <h1 class="svc-reveal text-4xl font-black leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">{{ $category->name }}</h1>
                <p class="svc-reveal mt-4 max-w-2xl text-sm text-white/65 sm:text-base">{{ $category->headline ?: ($category->description ?: 'Browse available services in this category.') }}</p>
            </div>
        </section>

        <section class="mx-auto w-full max-w-[1440px] px-5 py-14 sm:px-8 lg:px-10 lg:py-20">
            <div class="svc-reveal mb-8 flex flex-wrap items-center justify-between gap-3 lg:mb-10">
                <h2 class="text-3xl font-black tracking-tight sm:text-4xl">{{ $category->name }} Services</h2>
                <a href="{{ route('services.index') }}" class="rounded-full border border-white/15 bg-white/[0.03] px-5 py-2.5 text-sm font-semibold text-white transition hover:border-white/30 hover:bg-white/[0.06]">
                    Back to Categories
                </a>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @forelse($services as $service)
                    <article class="svc-card svc-reveal overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04]">
                        <div class="overflow-hidden">
                            <img src="{{ $service->thumbnail_url }}" alt="{{ $service->title }}" class="svc-image h-48 w-full object-cover sm:h-52">
                        </div>
                        <div class="p-5 sm:p-6">
                            <h3 class="text-2xl font-semibold text-white">{{ $service->title }}</h3>
                            <p class="mt-3 min-h-[72px] text-sm leading-6 text-white/60">
                                {{ $service->short_description ?: \Illuminate\Support\Str::limit($service->description, 120) }}
                            </p>
                            <div class="mt-4 text-sm font-semibold text-white">
                                {{ $service->currency ?: 'PHP' }} {{ number_format($service->price, 2) }}
                            </div>
                            <a href="{{ route('services.show', $service) }}" class="mt-5 inline-flex items-center text-sm font-semibold text-white transition hover:text-violet-300">
                                Explore More
                                <span class="ml-1">></span>
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="text-base text-white/60">No services found in this category.</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $services->links() }}
            </div>
        </section>

        <x-auth-footer />
    </div>

    <script>
        (() => {
            const revealNodes = document.querySelectorAll('.svc-reveal');
            if (!revealNodes.length) {
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('svc-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

            revealNodes.forEach((node) => observer.observe(node));
        })();
    </script>
@endsection
