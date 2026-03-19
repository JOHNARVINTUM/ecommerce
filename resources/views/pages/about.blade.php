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
            'github' => 'https://github.com/domeld',
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
            'github' => 'https://github.com/godwin',
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
    <div class="min-h-screen w-full overflow-x-hidden bg-[#f2f1eb] text-[#111]">
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
                        <a href="{{ route('login') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-slate-300">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="rounded-lg bg-white px-3 py-1.5 font-semibold text-black">USER</a>
                    @endauth
                </nav>
            </div>
        </header>

        <section class="px-6 py-10 sm:px-10 lg:px-12">
            <h1 class="text-5xl font-bold sm:text-6xl">About us</h1>

            <div class="mt-10 grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div class="overflow-hidden rounded-xl">
                    <img src="{{ $teamPhoto }}" alt="LIMAX team" class="h-[280px] w-full object-cover sm:h-[360px] lg:h-[420px]">
                </div>

                <div>
                    <h2 class="text-4xl font-bold sm:text-5xl">We are the makers</h2>
                    <p class="mt-4 max-w-xl text-base leading-8 text-[#555] sm:text-lg">
                        LIMAX is a technology-focused freelancing platform built by BSITIA students from FEU Institute of Technology.
                        We connect clients with IT professionals specializing in development, design, and digital services making
                        collaboration simple, efficient, and reliable.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-[#ecebe7] px-6 py-12 sm:px-10 lg:px-12">
            <h2 class="text-4xl font-bold sm:text-5xl">The Legendary Team</h2>
            <p class="mt-4 max-w-6xl text-base leading-8 text-[#555] sm:text-lg">
                LIMAX is powered by a dedicated team of BSITIA students from FEU Institute of Technology, united by a passion for technology,
                creativity, and digital innovation. With diverse skills across development, design, and analytics, the team collaborates to build
                practical, user-focused solutions that address real-world needs. Through teamwork, continuous learning, and a strong foundation in
                information technology and business analytics, the LIMAX team strives to turn ideas into meaningful digital experiences and reliable
                technology-driven platforms.
            </p>

            <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($members as $member)
                    <article class="overflow-hidden rounded-xl bg-[#8d5d3c] text-white">
                        <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" onerror="this.onerror=null;this.src='{{ asset('img/maker.png') }}';" class="aspect-square w-full object-cover object-top">
                        <div class="px-3 py-3">
                            <p class="text-sm font-semibold">{{ $member['name'] }}</p>
                            <p class="mt-1 text-xs text-white/80">{{ $member['role'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10 border-t border-[#d6d2cb]">
                @foreach ($members as $member)
                    <div class="flex items-center justify-between border-b border-[#d6d2cb] py-5">
                        <span class="text-2xl font-semibold">{{ $member['name'] }}</span>
                        <a href="{{ $member['github'] }}" rel="noopener noreferrer" class="inline-flex items-center rounded-md border border-[#b8b4ad] px-4 py-2 text-sm font-medium text-[#555] transition hover:border-black hover:text-black">GitHub</a>
                    </div>
                @endforeach
            </div>
        </section>

        <x-auth-footer />
    </div>
@endsection
