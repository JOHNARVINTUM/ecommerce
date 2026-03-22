@extends('layouts.guest')

@php
    $exampleImage = 'https://picsum.photos/seed/services-example/1400/900';
    $heroImage = $exampleImage;
    $categoryImages = [
        'programming' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=1200&q=80',
        'web-design' => 'https://images.unsplash.com/photo-1518773553398-650c184e0bb3?auto=format&fit=crop&w=1200&q=80',
        'graphic-design' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1200&q=80',
        'video-editing' => 'https://images.unsplash.com/photo-1492619375914-88005aa9e8fb?auto=format&fit=crop&w=1200&q=80',
        'photo-editing' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=1200&q=80',
        'logo-making' => 'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&w=1200&q=80',
    ];
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

    <div class="min-h-screen w-full overflow-x-clip bg-[#0d0e13] text-white">
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
            <img src="{{ $heroImage }}" alt="Services hero" class="h-[280px] w-full object-cover opacity-35 sm:h-[360px]">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0d0e13]/30 via-[#0d0e13]/65 to-[#0d0e13]"></div>
            <div class="absolute inset-0 mx-auto flex w-full max-w-[1440px] flex-col items-start justify-center px-5 text-left sm:px-8 lg:px-10">
                <p class="svc-reveal mb-3 text-xs font-semibold uppercase tracking-[0.24em] text-white/60">Find Your Next Expert</p>
                <h1 class="svc-reveal text-4xl font-black leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                    Services
                </h1>
                <p class="svc-reveal mt-4 max-w-2xl text-sm text-white/65 sm:text-base">
                    Technology-driven services delivered by skilled IT professionals.
                </p>
            </div>
        </section>

        <section class="mx-auto w-full max-w-[1440px] px-5 py-14 sm:px-8 lg:px-10 lg:py-20">
            <div class="svc-reveal mb-8 flex flex-wrap items-end justify-between gap-4 lg:mb-10">
                <div>
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/40">Explore</p>
                    <h2 class="text-3xl font-black tracking-tight text-white sm:text-4xl">Service Categories</h2>
                </div>
                <div class="rounded-full border border-white/10 bg-white/[0.03] px-4 py-2 text-xs font-medium text-white/50">
                    {{ $categories->count() }} categories available
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @forelse($categories as $category)
                    @php
                        $cardImage = $categoryImages[$category->slug] ?? $exampleImage;
                    @endphp
                    <article class="svc-card svc-reveal overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04]">
                        <div class="overflow-hidden">
                            <img src="{{ $cardImage }}" alt="{{ $category->name }}" class="svc-image h-48 w-full object-cover sm:h-52">
                        </div>
                        <div class="p-5 sm:p-6">
                            <h2 class="text-2xl font-semibold text-white">{{ $category->name }}</h2>
                            <p class="mt-3 min-h-[84px] text-sm leading-6 text-white/60">
                                {{ $category->headline ?: ($category->description ?: 'add description here') }}
                            </p>
                            <a href="{{ route('services.category', $category) }}" class="mt-5 inline-flex items-center text-sm font-semibold text-white transition hover:text-violet-300">
                                Explore More
                                <span class="ml-1">></span>
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="text-base text-white/60">No categories found.</p>
                @endforelse
            </div>
        </section>

        <section class="border-y border-white/5 bg-[#161820] px-5 py-12 text-white sm:px-8 lg:px-10 lg:py-16">
            <div class="mx-auto max-w-[1440px]">
                <p class="svc-reveal text-sm text-slate-300">This is the future of IT freelancing.</p>
                <h2 class="svc-reveal mt-3 max-w-4xl text-4xl font-bold leading-tight sm:text-5xl">
                    The next generation technology freelancing platform.
                </h2>
                <p class="svc-reveal mt-6 max-w-6xl text-xs leading-6 text-slate-300 sm:text-sm sm:leading-7">
                    LIMAX is a fast, reliable, and secure freelancing platform built exclusively for IT and digital services. We connect businesses with skilled
                    professionals in programming, web design, graphic design, video editing, and other technology-driven fields. Every project is handled
                    by verified freelancers who focus on quality, efficiency, and results. Whether you're building software, designing a website, or creating
                    digital content, LIMAX helps you turn ideas into real solutions without the complexity.
                </p>
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
