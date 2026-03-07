@extends('layouts.guest')

@php
    $heroImage = 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=1600&q=80';
    $stripImages = [
        'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=700&q=80',
        'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=700&q=80',
        'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=700&q=80',
        'https://images.unsplash.com/photo-1517336714739-489689fd1ca8?auto=format&fit=crop&w=700&q=80',
    ];
    $helpImageA = 'https://images.unsplash.com/photo-1518773553398-650c184e0bb3?auto=format&fit=crop&w=1000&q=80';
    $helpImageB = 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1000&q=80';
@endphp

@section('content')
    <div class="w-full overflow-x-hidden bg-[#ecece9] text-[#111111]">
        <header class="bg-[#141414]">
            <div class="flex w-full items-center justify-between px-4 py-4 sm:px-8 sm:py-5 lg:px-10">
                <a href="{{ route('home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-5xl">
                    LIMAX
                </a>
                <a href="{{ route('login') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-medium text-black sm:px-5 sm:py-3 sm:text-base">
                    Sign in
                </a>
            </div>
        </header>

        <section class="w-full">
            <div class="relative overflow-hidden bg-black">
                <img src="{{ $heroImage }}" alt="Hero background" class="h-[460px] w-full object-cover sm:h-[620px] lg:h-[700px]">
                <div class="absolute inset-0 bg-black/35"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center sm:px-6">
                    <h1 class="max-w-[95vw] text-[clamp(2rem,7vw,5.5rem)] font-bold leading-[1.05] text-white">
                        You bring the idea, we'll<br>take it from here
                    </h1>
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-3 sm:mt-10 sm:gap-4">
                        <a href="{{ route('login') }}" class="rounded-2xl bg-white px-5 py-2.5 text-lg font-medium text-black sm:px-7 sm:py-3 sm:text-2xl">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="rounded-2xl bg-black px-5 py-2.5 text-lg font-medium text-white sm:px-7 sm:py-3 sm:text-2xl">
                            Sign up
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-5 w-full px-3 sm:px-6 lg:px-8">
            <div class="w-full rounded-sm bg-[#f8f8f6] p-4 sm:p-6">
                <h2 class="mb-4 text-2xl font-bold text-[#101010] sm:text-3xl">Popular services</h2>
                <div class="grid w-full grid-cols-2 gap-2 md:grid-cols-4">
                    @foreach ($stripImages as $index => $image)
                        @php
                            $service = $featuredServices->get($index);
                        @endphp
                        <a href="{{ $service ? route('services.show', $service) : route('services.index') }}" class="group block min-w-0 overflow-hidden rounded bg-black">
                            <img src="{{ $image }}" alt="Service visual" class="h-36 w-full object-cover transition duration-300 group-hover:scale-105 sm:h-48 md:h-56">
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mt-5 w-full bg-[#212327] px-6 py-12 text-white sm:px-10 sm:py-14 lg:px-12">
            <p class="text-[20px] text-slate-200">This is the future of IT freelancing.</p>
            <h2 class="mt-3 max-w-4xl text-4xl font-bold leading-tight sm:text-6xl">The next generation technology freelancing platform.</h2>
            <p class="mt-6 max-w-5xl text-base leading-7 text-slate-300 sm:text-lg">
                LIMAX is a fast, reliable, and secure freelancing platform built exclusively for IT and digital services. We connect businesses with skilled
                professionals in programming, web design, graphic design, video editing, and other technology-driven fields. Every project is handled by
                verified freelancers who focus on quality, efficiency, and results. Whether you're building software, designing a website, or creating
                digital content, LIMAX helps you turn ideas into real solutions without the complexity.
            </p>
        </section>

        <section class="w-full space-y-8 bg-[#ecece9] px-6 py-10 sm:px-10 lg:px-12">
            <div class="grid items-center gap-8 md:grid-cols-2">
                <div>
                    <h3 class="text-5xl font-bold leading-tight text-[#111] sm:text-6xl">Need help with Vibe coding?</h3>
                    <p class="mt-6 max-w-xl text-lg text-[#555] sm:text-xl">
                        Get matched with the right expert to keep building and marketing your project
                    </p>
                    <a href="{{ route('services.index') }}" class="mt-8 inline-block rounded-xl bg-black px-7 py-4 text-lg font-semibold text-white">
                        Find an Expert
                    </a>
                </div>
                <div class="overflow-hidden rounded-2xl">
                    <img src="{{ $helpImageA }}" alt="Coding support" class="h-[260px] w-full object-cover sm:h-[360px] md:h-[420px]">
                </div>
            </div>

            <div class="grid items-center gap-8 md:grid-cols-2">
                <div class="order-2 md:order-1 overflow-hidden rounded-2xl">
                    <img src="{{ $helpImageB }}" alt="Design support" class="h-[260px] w-full object-cover sm:h-[360px] md:h-[420px]">
                </div>
                <div class="order-1 md:order-2">
                    <h3 class="text-5xl font-bold leading-tight text-[#111] sm:text-6xl">Looking for help designing your website?</h3>
                    <p class="mt-6 max-w-xl text-lg text-[#555] sm:text-xl">
                        Work with experienced designers who create modern, responsive websites tailored to your goals.
                    </p>
                    <a href="{{ route('services.index') }}" class="mt-8 inline-block rounded-xl bg-black px-7 py-4 text-lg font-semibold text-white">
                        Find an Expert
                    </a>
                </div>
            </div>
        </section>

        <section class="w-full bg-[#212327] px-6 py-10 text-white sm:px-10 sm:py-12 lg:px-12">
            <h2 class="text-5xl font-bold leading-tight sm:text-6xl">This is why Customers Love us</h2>
            <p class="mt-3 text-lg text-slate-300">Here's what people are saying</p>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <article class="rounded-2xl bg-white p-6 text-[#121212]">
                    <p class="text-lg leading-7">The logo making was fast and innovative and deserves a 5 star</p>
                    <div class="mt-10">
                        <p class="text-sm font-semibold">Dale Warren Hurst</p>
                        <p class="text-sm text-[#666]">Logo Making Service</p>
                    </div>
                </article>
                <article class="rounded-2xl bg-white p-6 text-[#121212]">
                    <p class="text-lg leading-7">Very friendly, fast, and a good!</p>
                    <div class="mt-10">
                        <p class="text-sm font-semibold">Godwin Ablao</p>
                        <p class="text-sm text-[#666]">Programming Service</p>
                    </div>
                </article>
                <article class="rounded-2xl bg-white p-6 text-[#121212]">
                    <p class="text-lg leading-7">really kind, fast service. Recommend</p>
                    <div class="mt-10">
                        <p class="text-sm font-semibold">Jake Chavenia</p>
                        <p class="text-sm text-[#666]">Video Editing Service</p>
                    </div>
                </article>
            </div>
        </section>

        <footer class="w-full bg-[#ecece9] px-6 py-10 sm:px-10 lg:px-12">
            <div class="grid gap-8 text-sm text-[#2f2f2f] md:grid-cols-5">
                <div class="md:col-span-2">
                    <p class="text-lg font-black tracking-tight text-[#141414]">LIMAX</p>
                    <p class="mt-3 max-w-2xl text-base leading-7 text-[#555]">
                        LIMAX is a technology-focused freelancing platform built for businesses and creators who need reliable IT expertise.
                        We connect clients with skilled professionals in programming, web design, graphic design, video editing, and other
                        digital services. Every project is handled with quality, transparency, and care so you can focus on your goals while
                        we connect you with the right talent.
                    </p>
                </div>
                <div>
                    <p class="text-base font-bold text-[#141414]">Features</p>
                    <ul class="mt-3 space-y-2 text-base">
                        <li><a href="{{ route('services.index') }}" class="hover:text-black">Core features</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-black">Pro experience</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-black">Integrations</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-base font-bold text-[#141414]">Learn more</p>
                    <ul class="mt-3 space-y-2 text-base">
                        <li><a href="{{ route('about') }}" class="hover:text-black">Blog</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-black">Case studies</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-black">Customer stories</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-black">Best practices</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-base font-bold text-[#141414]">Support</p>
                    <ul class="mt-3 space-y-2 text-base">
                        <li><a href="{{ route('about') }}" class="hover:text-black">Contact</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-black">Support</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-black">Legal</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
@endsection
