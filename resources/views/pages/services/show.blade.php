@extends('layouts.guest')

@php
    $gallery = $service->gallery_urls;
    $initialImage = $gallery[0];
    $providerName = $service->provider->name ?? 'Provider';
    $providerInitials = collect(explode(' ', $providerName))->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
@endphp

@section('content')
    <style>
        #service-detail-layout {
            display: grid;
            gap: 2rem;
        }

        @media (min-width: 1280px) {
            #service-detail-layout {
                grid-template-columns: 1.05fr 0.95fr;
                align-items: start;
            }
        }

        #gallery-thumbs {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 8px;
        }

        #gallery-thumbs .gallery-thumb {
            display: block;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.04);
            cursor: pointer;
        }

        #gallery-thumbs .gallery-thumb img {
            display: block;
            width: 100%;
            height: 70px;
            object-fit: cover;
        }

        @media (min-width: 640px) {
            #gallery-thumbs .gallery-thumb img {
                height: 80px;
            }
        }
    </style>

    <div class="flex min-h-screen w-full flex-col overflow-x-hidden bg-[#0d0e13] text-white">
        <header class="sticky top-0 z-40 border-b border-white/5 bg-[#0d0e13]/90 backdrop-blur-md">
            <div class="flex w-full items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ auth()->check() ? route('user.home') : route('home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
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

        <section class="mx-auto w-full max-w-[1440px] flex-1 px-5 py-8 sm:px-8 lg:px-10">
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-400/30 bg-emerald-500/15 px-4 py-3 text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-lg border border-rose-400/30 bg-rose-500/15 px-4 py-3 text-rose-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-7 text-xs text-white/45 sm:text-sm">
                <a href="{{ auth()->check() ? route('user.home') : route('home') }}" class="hover:text-white">Homepage</a>
                <span class="mx-2">></span>
                <a href="{{ route('services.index') }}" class="hover:text-white">Service</a>
                <span class="mx-2">></span>
                <a href="{{ route('services.category', $service->category) }}" class="hover:text-white">{{ $service->category->name ?? 'Category' }}</a>
                <span class="mx-2">></span>
                <span class="font-semibold text-white">{{ $service->title }}</span>
            </div>

            <div class="grid gap-8 xl:grid-cols-[1.05fr_0.95fr]" id="service-detail-layout">
                <div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-violet-500/70 text-sm font-bold text-white">
                            {{ $providerInitials ?: 'PR' }}
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-white">{{ $providerName }}</p>
                            <p class="text-sm text-white/60">Expert in {{ $service->category->name ?? 'General Services' }}</p>
                            <div class="mt-1 flex items-center gap-2 text-xs text-white/50">
                                <span class="text-amber-500">*****</span>
                                <span>({{ (int) $service->rating_count }})</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div id="service-gallery" class="relative overflow-hidden rounded-xl border border-white/15 bg-black/40" data-images='@json($gallery)'>
                            <img id="gallery-main-image" src="{{ $initialImage }}" alt="Service preview" class="w-full object-cover" style="height: clamp(220px, 42vw, 420px);">
                            <button type="button" id="gallery-prev" class="absolute left-2 top-1/2 inline-flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded bg-white/90 text-sm font-bold text-[#222]">
                                &lt;
                            </button>
                            <button type="button" id="gallery-next" class="absolute right-2 top-1/2 inline-flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded bg-white/90 text-sm font-bold text-[#222]">
                                &gt;
                            </button>
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-5 gap-2" id="gallery-thumbs">
                        @foreach ($gallery as $index => $image)
                            <button type="button" data-index="{{ $index }}" class="gallery-thumb overflow-hidden rounded-lg border border-white/15 {{ $index === 0 ? 'ring-2 ring-violet-300 is-active' : '' }}" aria-label="Show image {{ $index + 1 }}">
                                <img src="{{ $image }}" alt="Service gallery {{ $index + 1 }}" class="h-14 w-full object-cover sm:h-20">
                            </button>
                        @endforeach
                    </div>

                    <div class="mt-8 rounded-xl border border-white/10 bg-white/[0.04] p-5">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-white/65">Get to know {{ $providerName }}</h2>
                        <div class="mt-4 grid gap-3 text-sm text-white/75 sm:grid-cols-2">
                            <p><span class="font-semibold">From:</span> Philippines</p>
                            <p><span class="font-semibold">Delivery:</span> {{ $service->delivery_time_days }} day(s)</p>
                            <p><span class="font-semibold">Revisions:</span> {{ $service->revisions }} revision(s)</p>
                            <p><span class="font-semibold">Languages:</span> English</p>
                        </div>
                        <p class="mt-4 border-t border-white/10 pt-4 text-sm leading-6 text-white/60">
                            {{ $service->description }}
                        </p>
                    </div>
                </div>

                <aside>
                    <p class="text-xs text-white/50">{{ $providerName }}</p>
                    <h1 class="mt-1 text-4xl font-medium leading-tight text-white">{{ $service->title }}</h1>

                    <div class="mt-4 flex items-end justify-between border-b border-white/10 pb-4">
                        <p class="text-4xl font-semibold text-white">{{ $service->currency ?: 'PHP' }} {{ number_format($service->price, 2) }}</p>
                        <p class="text-sm text-white/50">{{ (int) $service->sold_count }} Sold</p>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-white">Description:</h2>
                        <p class="mt-2 text-sm leading-7 text-white/60">{{ $service->short_description ?: $service->description }}</p>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="mailto:{{ $service->provider->email ?? '' }}" class="inline-flex items-center justify-center rounded-lg border border-white/25 px-8 py-3 text-sm font-semibold text-white transition hover:border-white/45 hover:bg-white/10">
                            Contact me
                        </a>

                        @auth
                            @if (auth()->user()->role === 'customer')
                                <form action="{{ route('cart.store', $service->slug) }}" method="POST" class="w-full sm:w-auto">
                                    @csrf
                                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-white px-8 py-3 text-sm font-semibold text-black transition hover:bg-white/90">
                                        Add To Cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('checkout.create', $service->slug) }}" class="inline-flex items-center justify-center rounded-lg bg-white px-8 py-3 text-sm font-semibold text-black transition hover:bg-white/90">
                                    Continue
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-8 py-3 text-sm font-semibold text-black transition hover:bg-white/90">
                                Add To Cart
                            </a>
                        @endauth
                    </div>
                </aside>
            </div>
        </section>

        <x-auth-footer />
    </div>

    <script>
        (() => {
            const gallery = document.getElementById('service-gallery');
            const mainImage = document.getElementById('gallery-main-image');
            const thumbWrap = document.getElementById('gallery-thumbs');
            const prevButton = document.getElementById('gallery-prev');
            const nextButton = document.getElementById('gallery-next');

            if (!gallery || !mainImage || !thumbWrap || !prevButton || !nextButton) {
                return;
            }

            const images = JSON.parse(gallery.dataset.images || '[]');
            const thumbs = Array.from(thumbWrap.querySelectorAll('button[data-index]'));
            let activeIndex = 0;

            if (!images.length) {
                return;
            }

            const setActive = (index) => {
                activeIndex = (index + images.length) % images.length;
                mainImage.src = images[activeIndex];

                thumbs.forEach((thumb, thumbIndex) => {
                    const active = thumbIndex === activeIndex;
                    thumb.classList.toggle('is-active', active);
                    thumb.classList.toggle('ring-2', active);
                    thumb.classList.toggle('ring-violet-300', active);
                });
            };

            thumbs.forEach((thumb) => {
                thumb.addEventListener('click', () => {
                    const index = Number(thumb.dataset.index || 0);
                    setActive(index);
                });
            });

            prevButton.addEventListener('click', () => setActive(activeIndex - 1));
            nextButton.addEventListener('click', () => setActive(activeIndex + 1));
        })();
    </script>
@endsection
