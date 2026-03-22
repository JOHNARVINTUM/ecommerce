@extends('layouts.guest')

@php
    $teamPhoto = asset('img/maker.png');
    $members = [
        [
            'name' => 'Arvin Tumbagahon',
            'role' => 'BSITBA',
            'image' => asset('img/arvin.png'),
            'github' => 'https://github.com/JOHNARVINTUM',
        ],
        [
            'name' => 'Domeld Manangan',
            'role' => 'BSITBA',
            'image' => asset('img/domeld.png'),
            'github' => 'https://github.com/DomeldManangan',
        ],
        [
            'name' => 'Sean Mojica',
            'role' => 'BSITBA',
            'image' => asset('img/sean.png'),
            'github' => 'https://github.com/snmjc',
        ],
        [
            'name' => 'Godwin Ablao',
            'role' => 'BSITBA',
            'image' => asset('img/godwin.png'),
            'github' => 'https://github.com/GodwinAblao',
        ],
        [
            'name' => 'Dale Hurst',
            'role' => 'BSITBA',
            'image' => asset('img/dale.png'),
            'github' => 'https://github.com/DallleHurst',
        ],
    ];
@endphp

@section('content')
    <style>
        .about-reveal {
            opacity: 0;
            transform: translateY(38px);
            transition: opacity .8s cubic-bezier(.16,1,.3,1), transform .8s cubic-bezier(.16,1,.3,1);
        }
        .about-reveal.visible {
            opacity: 1;
            transform: none;
        }
        .about-card {
            transition: transform .35s cubic-bezier(.16,1,.3,1), box-shadow .35s ease, border-color .35s ease;
        }
        .about-card:hover {
            transform: translateY(-8px);
            border-color: rgba(167, 139, 250, 0.42);
            box-shadow: 0 22px 44px rgba(2, 6, 23, 0.35);
        }
        .about-card:hover img {
            transform: scale(1.04);
        }
        .about-card img {
            transition: transform .45s cubic-bezier(.16,1,.3,1);
        }
        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        .float-orb {
            animation: floatY 7s ease-in-out infinite;
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
            <div class="float-orb absolute -left-20 top-10 h-72 w-72 rounded-full bg-violet-600/30 blur-[100px]"></div>
            <div class="float-orb absolute right-0 top-20 h-64 w-64 rounded-full bg-sky-500/20 blur-[90px]" style="animation-delay: 1.2s;"></div>
            <div class="mx-auto grid min-h-[72vh] w-full max-w-[1440px] gap-10 px-6 py-14 sm:px-10 lg:grid-cols-[1.05fr_0.95fr] lg:px-12 lg:py-20">
                <div class="about-reveal flex flex-col justify-center">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-[0.32em] text-white/45">About LIMAX</p>
                    <h1 class="text-5xl font-black leading-[1.02] tracking-tight sm:text-6xl lg:text-7xl">About us</h1>
                    <h2 class="mt-6 text-3xl font-bold text-white/90 sm:text-5xl">We are the makers</h2>
                    <p class="mt-6 max-w-xl text-base leading-8 text-white/60 sm:text-lg">
                        LIMAX is a technology-focused freelancing platform built by BSITIA students from FEU Institute of Technology.
                        We connect clients with IT professionals specializing in development, design, and digital services making
                        collaboration simple, efficient, and reliable.
                    </p>
                    <div class="mt-10 grid max-w-xl grid-cols-2 gap-3 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-4 text-center">
                            <p class="text-2xl font-black">{{ count($members) }}</p>
                            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-white/40">Team Members</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-4 text-center">
                            <p class="text-2xl font-black">BSITIA</p>
                            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-white/40">Program</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-4 text-center col-span-2 sm:col-span-1">
                            <p class="text-2xl font-black">FEU</p>
                            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-white/40">Institute of Technology</p>
                        </div>
                    </div>
                </div>

                <div class="about-reveal relative flex items-center justify-center">
                    <div class="absolute inset-x-6 inset-y-10 rounded-[2rem] bg-gradient-to-br from-violet-500/15 via-transparent to-sky-500/15 blur-2xl"></div>
                    <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.04] p-3 shadow-[0_30px_70px_rgba(0,0,0,0.35)]">
                        <img src="{{ $teamPhoto }}" alt="LIMAX team" class="h-[320px] w-full rounded-[1.4rem] object-cover sm:h-[420px] lg:h-[520px]">
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto w-full max-w-[1440px] px-6 py-16 sm:px-10 lg:px-12 lg:py-20">
            <div class="about-reveal max-w-5xl">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.32em] text-white/45">The Legendary Team</p>
                <h2 class="text-4xl font-black tracking-tight sm:text-5xl">The Legendary Team</h2>
                <p class="mt-5 text-base leading-8 text-white/60 sm:text-lg">
                    LIMAX is powered by a dedicated team of BSITIA students from FEU Institute of Technology, united by a passion for technology,
                    creativity, and digital innovation. With diverse skills across development, design, and analytics, the team collaborates to build
                    practical, user-focused solutions that address real-world needs. Through teamwork, continuous learning, and a strong foundation in
                    information technology and business analytics, the LIMAX team strives to turn ideas into meaningful digital experiences and reliable
                    technology-driven platforms.
                </p>
            </div>

            <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($members as $member)
                    <article class="about-card about-reveal overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] text-white">
                        <div class="overflow-hidden">
                            <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="aspect-square w-full object-cover object-top">
                        </div>
                        <div class="px-4 py-4">
                            <p class="text-sm font-semibold">{{ $member['name'] }}</p>
                            <p class="mt-1 text-xs text-white/60">{{ $member['role'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12 rounded-[2rem] border border-white/10 bg-white/[0.03] p-6 sm:p-8">
                @foreach ($members as $member)
                    <div class="about-reveal flex flex-col gap-3 border-b border-white/10 py-5 last:border-b-0 md:flex-row md:items-center md:justify-between">
                        <span class="text-2xl font-semibold text-white">{{ $member['name'] }}</span>
                        <a href="{{ $member['github'] }}" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-full border border-white/20 px-5 py-2 text-sm font-medium text-white/75 transition hover:border-white/35 hover:bg-white/10 hover:text-white">GitHub</a>
                    </div>
                @endforeach
            </div>
        </section>

        <x-auth-footer />
    </div>

    <script>
        (() => {
            const nodes = document.querySelectorAll('.about-reveal');
            if (!nodes.length) {
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -50px 0px' });

            nodes.forEach((node) => observer.observe(node));
        })();
    </script>
@endsection
