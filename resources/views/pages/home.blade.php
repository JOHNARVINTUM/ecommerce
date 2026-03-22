@extends('layouts.guest')

@php
    $heroImage = 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=1600&q=80';
    $stripImages = [
        'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=700&q=80',
        'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=700&q=80',
        'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=700&q=80',
        'https://picsum.photos/seed/web-design-strip/700/500',
    ];
    $helpImageA = 'https://images.unsplash.com/photo-1518773553398-650c184e0bb3?auto=format&fit=crop&w=1000&q=80';
    $helpImageB = 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1000&q=80';
@endphp

@section('content')
    <style>
        .home-reveal {
            opacity: 0;
            transform: translateY(36px);
            transition: opacity .8s cubic-bezier(.16,1,.3,1), transform .8s cubic-bezier(.16,1,.3,1);
        }
        .home-reveal.visible {
            opacity: 1;
            transform: none;
        }
        .home-card {
            transition: transform .35s cubic-bezier(.16,1,.3,1), box-shadow .35s ease, border-color .35s ease;
        }
        .home-card:hover {
            transform: translateY(-8px);
            border-color: rgba(167, 139, 250, .42);
            box-shadow: 0 24px 46px rgba(2, 6, 23, .35);
        }
        .home-card:hover img {
            transform: scale(1.05);
        }
        .home-card img {
            transition: transform .5s cubic-bezier(.16,1,.3,1);
        }
        @keyframes ticker {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }
        .ticker-track {
            animation: ticker 26s linear infinite;
        }
        .ticker-track:hover {
            animation-play-state: paused;
        }
    </style>

    <div class="w-full overflow-x-clip bg-[#0d0e13] text-white">
        <header class="sticky top-0 z-40 border-b border-white/5 bg-[#0d0e13]/90 backdrop-blur-md">
            <div class="flex w-full items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                    LIMAX
                </a>
                <a href="{{ route('login') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90 sm:px-5 sm:py-2 sm:text-sm">
                    Sign up
                </a>
            </div>
        </header>

        <section class="relative isolate overflow-hidden border-b border-white/5 bg-black">
            <div class="absolute -left-24 top-10 h-80 w-80 rounded-full bg-violet-600/30 blur-[110px]"></div>
            <div class="absolute right-0 top-16 h-72 w-72 rounded-full bg-indigo-500/25 blur-[100px]"></div>
            <img src="{{ $heroImage }}" alt="Hero background" class="h-[560px] w-full object-cover opacity-35 sm:h-[680px] lg:h-[760px]">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0d0e13]/20 via-[#0d0e13]/60 to-[#0d0e13]"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center sm:px-6">
                <p class="home-reveal mb-5 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.28em] text-white/55">
                    Technology-driven freelancing
                </p>
                <h1 class="home-reveal max-w-[95vw] text-[clamp(2.6rem,7vw,6.2rem)] font-black leading-[1.02] tracking-tight text-white">
                    You bring the idea, we'll<br>take it from here
                </h1>
                <div class="home-reveal mt-8 flex flex-wrap items-center justify-center gap-3 sm:mt-10 sm:gap-4">
                    <a href="{{ route('login') }}" class="rounded-full bg-white px-6 py-3 text-base font-bold text-black transition hover:bg-white/90 sm:px-7 sm:text-lg">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="rounded-full border border-white/20 bg-white/5 px-6 py-3 text-base font-bold text-white transition hover:bg-white/10 sm:px-7 sm:text-lg">
                        Sign up
                    </a>
                </div>
            </div>
        </section>

        <div class="overflow-hidden border-b border-white/5 bg-white/[0.03] py-4 text-xs font-medium uppercase tracking-[0.24em] text-white/25">
            <div class="ticker-track flex w-max gap-16">
                @foreach (range(0,1) as $_)
                    <span>Programming</span><span>·</span>
                    <span>Web Design</span><span>·</span>
                    <span>Graphic Design</span><span>·</span>
                    <span>Video Editing</span><span>·</span>
                    <span>Digital Services</span><span>·</span>
                    <span>IT Experts</span><span>·</span>
                @endforeach
            </div>
        </div>

        <section class="mx-auto mt-0 w-full max-w-[1440px] px-5 py-14 sm:px-6 lg:px-8 lg:py-18">
            <div class="home-reveal mb-7 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/40">Featured</p>
                    <h2 class="text-3xl font-black tracking-tight text-white sm:text-4xl">Popular services</h2>
                </div>
                <a href="{{ route('login') }}" class="rounded-full border border-white/15 bg-white/[0.03] px-5 py-2.5 text-sm font-semibold text-white/80 transition hover:border-white/30 hover:text-white">
                    View Services
                </a>
            </div>

            <div class="grid w-full grid-cols-2 gap-3 md:grid-cols-4">
                @foreach ($stripImages as $index => $image)
                    @php
                        $service = $featuredServices->get($index);
                    @endphp
                    <a href="{{ route('login') }}" class="home-card home-reveal group block min-w-0 overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04]">
                        <img src="{{ $image }}" alt="Service visual" class="h-40 w-full object-cover sm:h-52 md:h-64">
                    </a>
                @endforeach
            </div>
        </section>

        <section class="border-y border-white/5 bg-[#151820] px-6 py-14 text-white sm:px-10 sm:py-16 lg:px-12">
            <div class="mx-auto max-w-[1440px]">
                <p class="home-reveal text-[20px] text-slate-200">This is the future of IT freelancing.</p>
                <h2 class="home-reveal mt-3 max-w-4xl text-4xl font-black leading-tight sm:text-6xl">The next generation technology freelancing platform.</h2>
                <p class="home-reveal mt-6 max-w-5xl text-base leading-7 text-slate-300 sm:text-lg">
                    LIMAX is a fast, reliable, and secure freelancing platform built exclusively for IT and digital services. We connect businesses with skilled
                    professionals in programming, web design, graphic design, video editing, and other technology-driven fields. Every project is handled by
                    verified freelancers who focus on quality, efficiency, and results. Whether you're building software, designing a website, or creating
                    digital content, LIMAX helps you turn ideas into real solutions without the complexity.
                </p>
            </div>
        </section>

        <section class="mx-auto w-full max-w-[1440px] space-y-8 px-6 py-12 sm:px-10 lg:px-12 lg:py-16">
            <div class="grid items-center gap-8 md:grid-cols-2">
                <div class="home-reveal">
                    <h3 class="text-5xl font-black leading-tight text-white sm:text-6xl">Need help with Vibe coding?</h3>
                    <p class="mt-6 max-w-xl text-lg text-white/60 sm:text-xl">
                        Get matched with the right expert to keep building and marketing your project
                    </p>
                    <a href="{{ route('login') }}" class="mt-8 inline-block rounded-full bg-white px-7 py-4 text-lg font-semibold text-black transition hover:bg-white/90">
                        Find an Expert
                    </a>
                </div>
                <div class="home-card home-reveal overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.04] p-3">
                    <img src="{{ $helpImageA }}" alt="Coding support" class="h-[260px] w-full rounded-[1.4rem] object-cover sm:h-[360px] md:h-[420px]">
                </div>
            </div>

            <div class="grid items-center gap-8 md:grid-cols-2">
                <div class="home-card home-reveal order-2 md:order-1 overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.04] p-3">
                    <img src="{{ $helpImageB }}" alt="Design support" class="h-[260px] w-full rounded-[1.4rem] object-cover sm:h-[360px] md:h-[420px]">
                </div>
                <div class="home-reveal order-1 md:order-2">
                    <h3 class="text-5xl font-black leading-tight text-white sm:text-6xl">Looking for help designing your website?</h3>
                    <p class="mt-6 max-w-xl text-lg text-white/60 sm:text-xl">
                        Work with experienced designers who create modern, responsive websites tailored to your goals.
                    </p>
                    <a href="{{ route('login') }}" class="mt-8 inline-block rounded-full bg-white px-7 py-4 text-lg font-semibold text-black transition hover:bg-white/90">
                        Find an Expert
                    </a>
                </div>
            </div>
        </section>

        <section class="bg-[#151820] px-6 py-12 text-white sm:px-10 sm:py-14 lg:px-12">
            <div class="mx-auto max-w-[1440px]">
                <h2 class="home-reveal text-5xl font-black leading-tight sm:text-6xl">This is why Customers Love us</h2>
                <p class="home-reveal mt-3 text-lg text-slate-300">Here's what people are saying</p>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <article class="home-card home-reveal rounded-2xl border border-white/10 bg-white p-6 text-[#121212]">
                        <p class="text-lg leading-7">The logo making was fast and innovative and deserves a 5 star</p>
                        <div class="mt-10">
                            <p class="text-sm font-semibold">Dale Warren Hurst</p>
                            <p class="text-sm text-[#666]">Logo Making Service</p>
                        </div>
                    </article>
                    <article class="home-card home-reveal rounded-2xl border border-white/10 bg-white p-6 text-[#121212]">
                        <p class="text-lg leading-7">Very friendly, fast, and a good!</p>
                        <div class="mt-10">
                            <p class="text-sm font-semibold">Godwin Ablao</p>
                            <p class="text-sm text-[#666]">Programming Service</p>
                        </div>
                    </article>
                    <article class="home-card home-reveal rounded-2xl border border-white/10 bg-white p-6 text-[#121212]">
                        <p class="text-lg leading-7">really kind, fast service. Recommend</p>
                        <div class="mt-10">
                            <p class="text-sm font-semibold">Jake Chavenia</p>
                            <p class="text-sm text-[#666]">Video Editing Service</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <x-auth-footer />
    </div>

    <script>
        (() => {
            const nodes = document.querySelectorAll('.home-reveal');
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
