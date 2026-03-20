@extends('layouts.guest')

@php
    $exampleImage = 'https://picsum.photos/seed/services-example/1400/900';
    $heroImage = $exampleImage;
    $exampleServiceLink = isset($services) && $services->first()
        ? route('services.show', $services->first())
        : '#';
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

        <section class="relative overflow-hidden bg-black">
            <img src="{{ $heroImage }}" alt="Example category" class="h-[180px] w-full object-cover sm:h-[220px]">
            <div class="absolute inset-0 bg-black/55"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center px-6 text-center text-white">
                {{-- TODO BACKEND: Replace with category name/headline from DB. --}}
                <h1 class="text-4xl font-bold sm:text-6xl">Example Category</h1>
                <p class="mt-3 text-sm sm:text-lg">Example category headline for future backend data.</p>
            </div>
        </section>

        <section class="px-5 py-10 sm:px-8 lg:px-10">
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                {{-- TODO BACKEND: Replace with {{ $category->name }} Posts. --}}
                <h2 class="text-2xl font-bold sm:text-3xl">Example Category Posts</h2>
                <a href="{{ route('services.index') }}" class="rounded-lg border border-[#d8d7d0] bg-white px-4 py-2 text-sm font-semibold hover:bg-[#f8f8f4]">
                    Back to Categories
                </a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                {{-- TODO BACKEND: Replace this static card with @foreach($services as $service) dynamic posts. --}}
                <article class="overflow-hidden rounded-xl border border-[#d8d7d0] bg-white shadow-[0_8px_18px_rgba(0,0,0,0.06)]">
                    <img src="{{ $exampleImage }}" alt="Example service" class="h-44 w-full object-cover">
                    <div class="p-4">
                        <h3 class="text-2xl font-semibold">Example Service Title</h3>
                        <p class="mt-2 min-h-[72px] text-sm leading-6 text-[#696969]">
                            Example short description for this service content block.
                        </p>
                        <div class="mt-3 text-sm font-medium text-[#111]">
                            PHP 10,000.00
                        </div>
                        <a href="{{ $exampleServiceLink }}" class="mt-4 inline-flex items-center text-sm font-semibold text-[#111]">
                            See More
                            <span class="ml-1">></span>
                        </a>
                    </div>
                </article>
            </div>

            {{-- TODO BACKEND: Restore pagination once dynamic $services is re-enabled. --}}
        </section>

        <x-auth-footer />
    </div>
@endsection
