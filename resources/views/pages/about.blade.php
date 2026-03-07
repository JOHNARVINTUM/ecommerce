@extends('layouts.guest')

@php
    $teamPhoto = 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80';
    $members = [
        [
            'name' => 'Arvin Tumbagahon',
            'role' => 'Team Leader',
            'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
        ],
        [
            'name' => 'Domeld Manangan',
            'role' => 'Developer',
            'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&q=80',
        ],
        [
            'name' => 'Sean Mojica',
            'role' => 'Designer',
            'image' => 'https://images.unsplash.com/photo-1502685104226-ee32379fefbe?auto=format&fit=crop&w=600&q=80',
        ],
        [
            'name' => 'Godwin Ablao',
            'role' => 'Programmer',
            'image' => 'https://images.unsplash.com/photo-1504593811423-6dd665756598?auto=format&fit=crop&w=600&q=80',
        ],
        [
            'name' => 'Dale Hurst',
            'role' => 'Support',
            'image' => 'https://images.unsplash.com/photo-1504257432389-52343af06ae3?auto=format&fit=crop&w=600&q=80',
        ],
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
                        <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="h-40 w-full object-cover">
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
                        <a href="#" class="text-sm text-[#7a7a7a] hover:text-black">Github</a>
                    </div>
                @endforeach
            </div>
        </section>

        <x-auth-footer />
    </div>
@endsection
