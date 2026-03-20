@extends('layouts.guest')

@php
    $exampleImage = 'https://picsum.photos/seed/services-example/1400/900';
    $mainImage = $exampleImage;
    $gallery = [$exampleImage, $exampleImage, $exampleImage, $exampleImage, $exampleImage];
    $initialImage = $gallery[0] ?? $mainImage;
    $exampleProviderName = 'Example Provider';
    $exampleProviderInitials = 'EP';
    $exampleCategoryName = 'Example Category';
    $exampleServiceTitle = 'Example Service Title';
    $exampleServiceDescription = 'This is example service description content for frontend template mode while backend is still under development.';
    $examplePriceText = 'PHP 10,000.00';
    $exampleSoldText = '0 Sold';
    $exampleProviderSince = 'Dec 2024';
    $exampleDeliveryText = '3 day(s)';
    $exampleRevisionText = '2 revision(s)';
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

        #service-gallery {
            position: relative;
            overflow: hidden;
            border: 1px solid #d2d2cd;
            border-radius: 2px;
            background: #000;
        }

        #gallery-main-image {
            display: block;
            width: 100%;
            height: clamp(220px, 42vw, 420px);
            object-fit: cover;
        }

        .gallery-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border: 0;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.88);
            color: #222;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            z-index: 2;
        }

        #gallery-prev {
            left: 8px;
        }

        #gallery-next {
            right: 8px;
        }

        #gallery-thumbs {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 8px;
        }

        .gallery-thumb {
            overflow: hidden;
            border: 1px solid #d2d2cd;
            border-radius: 2px;
            background: #fff;
            padding: 0;
            cursor: pointer;
        }

        .gallery-thumb img {
            display: block;
            width: 100%;
            height: 70px;
            object-fit: cover;
        }

        .gallery-thumb.is-active {
            outline: 2px solid #111;
            outline-offset: 0;
        }
    </style>

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
                <a href="{{ auth()->check() ? route('user.home') : route('home') }}" class="hover:text-black">Homepage</a>
                <span class="mx-2">></span>
                <a href="{{ route('services.index') }}" class="hover:text-black">Service</a>
                <span class="mx-2">></span>
                {{-- TODO BACKEND: Replace example category/service breadcrumbs with model values. --}}
                <a href="#" class="hover:text-black">{{ $exampleCategoryName }}</a>
                <span class="mx-2">></span>
                <span class="font-semibold text-[#3a3a3a]">{{ $exampleServiceTitle }}</span>
            </div>

            <div class="grid gap-8 xl:grid-cols-[1.05fr_0.95fr]" id="service-detail-layout">
                <div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#7d4f34] text-sm font-bold text-white">
                            {{ $exampleProviderInitials }}
                        </div>
                        <div>
                            {{-- TODO BACKEND: Bind provider and category text from service relationship. --}}
                            <p class="text-lg font-semibold">{{ $exampleProviderName }}</p>
                            <p class="text-sm text-[#7b7b7b]">Expert in {{ $exampleCategoryName }}</p>
                            <div class="mt-1 flex items-center gap-2 text-xs text-[#7b7b7b]">
                                <span class="text-amber-500">★★★★★</span>
                                <span>(0)</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div id="service-gallery" class="relative overflow-hidden rounded-sm border border-[#d2d2cd] bg-black" data-images='@json($gallery)'>
                            <img id="gallery-main-image" src="{{ $initialImage }}" alt="Service preview" class="w-full object-cover" style="height: clamp(220px, 42vw, 420px);">

                            <button type="button" id="gallery-prev" aria-label="Previous image" class="gallery-arrow absolute left-2 top-1/2 inline-flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-sm bg-white/85 text-lg font-semibold text-[#222] shadow transition hover:bg-white">
                                &lt;
                            </button>
                            <button type="button" id="gallery-next" aria-label="Next image" class="gallery-arrow absolute right-2 top-1/2 inline-flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-sm bg-white/85 text-lg font-semibold text-[#222] shadow transition hover:bg-white">
                                &gt;
                            </button>
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-5 gap-2" id="gallery-thumbs">
                        @foreach ($gallery as $index => $image)
                            <button
                                type="button"
                                data-index="{{ $index }}"
                                class="gallery-thumb overflow-hidden rounded-sm border border-[#d2d2cd] {{ $index === 0 ? 'ring-2 ring-[#111] is-active' : '' }}"
                                aria-label="Show image {{ $index + 1 }}"
                            >
                                <img src="{{ $image }}" alt="Service gallery {{ $index + 1 }}" class="h-14 w-full object-cover sm:h-20">
                            </button>
                        @endforeach
                    </div>

                    <div class="mt-8 rounded-sm border border-[#9f9f9a] bg-[#f4f4ef] p-5">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-[#6f6f6f]">Get to know {{ $exampleProviderName }}</h2>
                        <div class="mt-4 grid gap-3 text-sm text-[#444] sm:grid-cols-2">
                            <p><span class="font-semibold">From:</span> Philippines</p>
                            <p><span class="font-semibold">Member since:</span> {{ $exampleProviderSince }}</p>
                            <p><span class="font-semibold">Delivery:</span> {{ $exampleDeliveryText }}</p>
                            <p><span class="font-semibold">Revisions:</span> {{ $exampleRevisionText }}</p>
                            <p><span class="font-semibold">Languages:</span> English</p>
                        </div>
                        <p class="mt-4 border-t border-[#b6b6b1] pt-4 text-sm leading-6 text-[#666]">
                            {{ $exampleServiceDescription }}
                        </p>
                    </div>
                </div>

                <aside>
                    <p class="text-xs text-[#8a8a8a]">{{ $exampleProviderName }}</p>
                    <h1 class="mt-1 text-4xl font-medium leading-tight text-[#262626]">{{ $exampleServiceTitle }}</h1>

                    <div class="mt-4 flex items-end justify-between border-b border-[#d0d0cb] pb-4">
                        <p class="text-4xl font-semibold text-[#1f1f1f]">{{ $examplePriceText }}</p>
                        <p class="text-sm text-[#707070]">{{ $exampleSoldText }}</p>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-lg font-semibold">Description:</h2>
                        <p class="mt-2 text-sm leading-7 text-[#666]">{{ $exampleServiceDescription }}</p>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        {{-- TODO BACKEND: Replace example CTA links with real provider email + checkout route. --}}
                        <a href="mailto:example@email.com" class="inline-flex items-center justify-center rounded-sm border border-[#3a3a3a] px-8 py-3 text-sm font-semibold hover:bg-[#ecece7]">
                            Contact me
                        </a>
                        <a href="#" class="inline-flex items-center justify-center rounded-sm bg-[#111] px-8 py-3 text-sm font-semibold text-white hover:bg-black">
                            Add To Cart
                        </a>
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
            const prevButton = document.getElementById('gallery-prev');
            const nextButton = document.getElementById('gallery-next');
            const thumbWrap = document.getElementById('gallery-thumbs');

            if (!gallery || !mainImage || !prevButton || !nextButton || !thumbWrap) {
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
                    if (thumbIndex === activeIndex) {
                        thumb.classList.add('is-active');
                        thumb.classList.add('ring-2', 'ring-[#111]');
                    } else {
                        thumb.classList.remove('is-active');
                        thumb.classList.remove('ring-2', 'ring-[#111]');
                    }
                });
            };

            prevButton.addEventListener('click', () => setActive(activeIndex - 1));
            nextButton.addEventListener('click', () => setActive(activeIndex + 1));

            thumbs.forEach((thumb) => {
                thumb.addEventListener('click', () => {
                    const index = Number(thumb.dataset.index || 0);
                    setActive(index);
                });
            });
        })();
    </script>
@endsection