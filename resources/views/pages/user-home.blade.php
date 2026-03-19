@extends('layouts.guest')

@php
    $heroImage = 'https://images.unsplash.com/photo-1518773553398-650c184e0bb3?auto=format&fit=crop&w=1800&q=80';
    $serviceImage = 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1400&q=80';
@endphp

@section('content')
    <div class="w-full overflow-x-hidden bg-[#ecece9] text-[#111111]">
        <header class="bg-[#1f2024]">
            <div class="flex w-full items-center justify-between px-4 py-4 sm:px-8 lg:px-10">
                <a href="{{ route('user.home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                    LIMAX
                </a>

                <nav class="flex items-center gap-3 text-[11px] text-white sm:gap-8 sm:text-sm">
                    <a href="{{ route('services.index') }}" class="hover:text-slate-300">Services</a>
                    <a href="{{ route('about') }}" class="hover:text-slate-300">About Us</a>
                    <a href="{{ route('orders.index') }}" aria-label="Cart" class="text-white transition hover:text-slate-300">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                            <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="rounded-lg bg-white px-3 py-1.5 font-semibold text-black">USER</a>
                </nav>
            </div>
        </header>

        <section class="relative overflow-hidden bg-black">
            <img src="{{ $heroImage }}" alt="User home hero" class="h-[260px] w-full object-cover sm:h-[360px]">
            <div class="absolute inset-0 bg-black/45"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center px-5 text-center text-white">
                <h1 class="text-4xl font-bold leading-tight sm:text-6xl">You bring the idea, we'll<br>take it from here</h1>
                <p class="mt-6 text-3xl font-bold">Welcome, {{ auth()->user()->name }}</p>
            </div>
        </section>

        <section class="px-6 py-12 sm:px-10 lg:px-12">
            <div class="grid items-center gap-10 md:grid-cols-2">
                <div>
                    <h2 class="text-5xl font-bold">Services</h2>
                    <p class="mt-3 max-w-md text-xl text-[#666]">From development to design, our IT experts deliver solutions that work.</p>
                    <a href="{{ route('services.index') }}" class="mt-8 inline-flex rounded-lg bg-black px-5 py-2.5 text-sm font-semibold text-white">
                        Explore Services
                    </a>
                </div>
                <div class="overflow-hidden rounded-xl">
                    <img src="{{ $serviceImage }}" alt="Services" class="h-[300px] w-full object-cover sm:h-[380px]">
                </div>
            </div>
        </section>

        <section class="bg-[#1f2024] px-6 py-12 text-white sm:px-10 lg:px-12">
            <p class="text-sm text-slate-300">This is the future of IT freelancing.</p>
            <h2 class="mt-3 max-w-4xl text-4xl font-bold leading-tight sm:text-5xl">
                The next generation technology freelancing platform.
            </h2>
            <p class="mt-6 max-w-6xl text-xs leading-6 text-slate-300 sm:text-sm sm:leading-7">
                LIMAX is a fast, reliable, and secure freelancing platform built exclusively for IT and digital services. We connect businesses with skilled
                professionals in programming, web design, graphic design, video editing, and other technology-driven fields. Every project is handled
                by verified freelancers who focus on quality, efficiency, and results. Whether you're building software, designing a website, or creating
                digital content, LIMAX helps you turn ideas into real solutions without the complexity.
            </p>
        </section>

        <x-auth-footer />
    </div>
@endsection
