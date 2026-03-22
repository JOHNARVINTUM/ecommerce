@extends('layouts.guest')

@section('content')
<style>
    /* ── Scroll-reveal base ── */
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.75s cubic-bezier(.16,1,.3,1), transform 0.75s cubic-bezier(.16,1,.3,1);
    }
    .reveal.reveal--left  { transform: translateX(-50px); }
    .reveal.reveal--right { transform: translateX(50px);  }
    .reveal.reveal--scale { transform: scale(0.92);       }
    .reveal.visible {
        opacity: 1;
        transform: none;
    }
    .reveal-delay-1 { transition-delay: 0.1s; }
    .reveal-delay-2 { transition-delay: 0.22s; }
    .reveal-delay-3 { transition-delay: 0.34s; }
    .reveal-delay-4 { transition-delay: 0.46s; }

    /* ── Parallax hero ── */
    #hero-bg {
        will-change: transform;
        transition: transform 0.05s linear;
    }

    /* ── Ticker tape ── */
    @keyframes ticker {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }
    .ticker-track { animation: ticker 28s linear infinite; }
    .ticker-track:hover { animation-play-state: paused; }

    /* ── Service card hover ── */
    .service-card {
        transition: transform 0.3s cubic-bezier(.16,1,.3,1), box-shadow 0.3s ease;
    }
    .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 48px rgba(0,0,0,0.14);
    }
    .service-card:hover .card-img { transform: scale(1.05); }
    .card-img { transition: transform 0.5s cubic-bezier(.16,1,.3,1); }

    /* ── Stat counter ── */
    .stat-num { font-variant-numeric: tabular-nums; }

    /* ── CTA gradient ── */
    .cta-gradient {
        background: linear-gradient(135deg, #0f0f14 0%, #1e1e28 60%, #2b1f3a 100%);
    }

    /* ── Noise overlay ── */
    .noise::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
        opacity: .35;
    }
</style>

<div class="w-full overflow-x-clip bg-[#0e0e12] text-white" id="page-top">

    {{-- ════════════════════ NAV ════════════════════ --}}
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
                    <!-- User Dropdown -->
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

    {{-- ════════════════════ HERO ════════════════════ --}}
    <section class="noise relative flex min-h-[92vh] items-center justify-center overflow-hidden bg-[#0e0e12]">
        {{-- Parallax bg --}}
        <div id="hero-bg" class="absolute inset-0 scale-110">
            <img src="https://images.unsplash.com/photo-1518773553398-650c184e0bb3?auto=format&fit=crop&w=2000&q=80"
                 alt="" class="h-full w-full object-cover opacity-25">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0e0e12]/20 via-[#0e0e12]/60 to-[#0e0e12]"></div>
        </div>

        {{-- Floating accent orbs --}}
        <div class="pointer-events-none absolute left-[-10%] top-[15%] h-[500px] w-[500px] rounded-full bg-purple-700/20 blur-[120px]"></div>
        <div class="pointer-events-none absolute bottom-[10%] right-[-8%] h-[400px] w-[400px] rounded-full bg-indigo-600/20 blur-[100px]"></div>

        <div class="relative z-10 mx-auto max-w-[960px] px-5 text-center">
            <p class="reveal mb-6 inline-block rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-medium uppercase tracking-[0.3em] text-white/60">
                Welcome back, {{ auth()->user()->name }}
            </p>
            <h1 class="reveal reveal-delay-1 text-5xl font-black leading-[1.05] tracking-tight sm:text-7xl lg:text-[96px]">
                You bring the&nbsp;idea,<br>
                <span class="bg-gradient-to-r from-violet-400 via-fuchsia-300 to-indigo-400 bg-clip-text text-transparent">
                    we'll take it<br>from here
                </span>
            </h1>
            <p class="reveal reveal-delay-2 mx-auto mt-8 max-w-xl text-base leading-7 text-white/50 sm:text-lg">
                The next-generation IT freelancing platform. Hire top professionals in development, design, and digital services faster than ever.
            </p>
            <div class="reveal reveal-delay-3 mt-10 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('services.index') }}"
                   class="group inline-flex items-center gap-2 rounded-full bg-white px-7 py-3.5 text-sm font-bold text-black transition hover:bg-white/90">
                    Explore Services
                    <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 transition-transform group-hover:translate-x-1"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a href="{{ route('orders.index') }}"
                   class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-3.5 text-sm font-medium text-white/80 transition hover:border-white/40 hover:text-white">
                    My Orders
                </a>
            </div>
        </div>

        {{-- Scroll cue --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce text-white/30">
            <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6"><path d="M12 5v14M5 12l7 7 7-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </section>

    {{-- ════════════════════ TICKER ════════════════════ --}}
    <div class="overflow-hidden border-y border-white/5 bg-white/[0.03] py-4 text-xs font-medium uppercase tracking-[0.25em] text-white/25">
        <div class="ticker-track flex w-max gap-16">
            @foreach (range(0,1) as $_)
                <span>Web Development</span><span>·</span>
                <span>UI/UX Design</span><span>·</span>
                <span>Logo & Branding</span><span>·</span>
                <span>Mobile Apps</span><span>·</span>
                <span>Video Editing</span><span>·</span>
                <span>SEO & Marketing</span><span>·</span>
                <span>Data Science</span><span>·</span>
                <span>Cloud Services</span><span>·</span>
                <span>Cybersecurity</span><span>·</span>
            @endforeach
        </div>
    </div>

    {{-- ════════════════════ STATS ════════════════════ --}}
    <section class="mx-auto max-w-[1440px] px-5 py-24 sm:px-10">
        <div class="grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-white/8 bg-white/8 md:grid-cols-4">
            @foreach ([['500+','Verified Freelancers'],['1,200+','Projects Delivered'],['98%','Client Satisfaction'],['24/7','Support Available']] as [$num,$label])
            <div class="reveal reveal--scale flex flex-col items-center gap-2 bg-[#0e0e12] px-8 py-10 text-center">
                <span class="stat-num text-4xl font-black tracking-tight text-white sm:text-5xl">{{ $num }}</span>
                <span class="text-xs font-medium uppercase tracking-[0.2em] text-white/40">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ════════════════════ FEATURED SERVICES ════════════════════ --}}
    <section class="mx-auto max-w-[1440px] px-5 pb-28 sm:px-10">
        <div class="reveal mb-14 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-white/35">Handpicked for you</p>
                <h2 class="text-4xl font-black tracking-tight sm:text-5xl">Featured <span class="text-white/30">Services</span></h2>
            </div>
            <a href="{{ route('services.index') }}"
               class="group inline-flex items-center gap-2 rounded-full border border-white/15 px-5 py-2.5 text-sm font-medium text-white/60 transition hover:border-white/30 hover:text-white">
                View all
                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 transition-transform group-hover:translate-x-1"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($featuredServices as $i => $service)
            <a href="{{ route('services.show', $service->slug) }}"
               class="service-card reveal reveal--scale reveal-delay-{{ $i + 1 }} group block overflow-hidden rounded-2xl border border-white/8 bg-white/[0.04]">
                <div class="overflow-hidden">
                    <img src="{{ $service->thumbnail_url }}" alt="{{ $service->title }}"
                         class="card-img h-52 w-full object-cover sm:h-60">
                </div>
                <div class="p-5">
                    <p class="mb-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-white/35">
                        {{ $service->category->name ?? 'General' }}
                    </p>
                    <h3 class="text-base font-bold leading-snug text-white group-hover:text-white/80 transition">{{ $service->title }}</h3>
                    <p class="mt-1 text-xs text-white/40">by {{ $service->provider->name ?? 'Provider' }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-lg font-black text-white">₱{{ number_format($service->price, 2) }}</span>
                        <span class="rounded-full bg-white/10 px-3 py-1 text-[11px] font-medium text-white/60">
                            {{ $service->delivery_time_days }}d delivery
                        </span>
                    </div>
                </div>
            </a>
            @empty
            <p class="col-span-3 text-center text-white/30">No services available yet.</p>
            @endforelse
        </div>
    </section>

    {{-- ════════════════════ BENTO FEATURES ════════════════════ --}}
    <section class="mx-auto max-w-[1440px] px-5 pb-28 sm:px-10">
        <div class="reveal mb-12">
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-white/35">Why LIMAX</p>
            <h2 class="text-4xl font-black tracking-tight sm:text-5xl">Built for <span class="text-white/30">results</span></h2>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Large card --}}
            <div class="reveal reveal--left lg:col-span-2 lg:row-span-2 relative overflow-hidden rounded-2xl border border-white/8 bg-gradient-to-br from-violet-900/40 to-indigo-900/20 p-8">
                <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-violet-500/20 blur-[80px]"></div>
                <p class="mb-3 inline-block rounded-full border border-violet-400/20 bg-violet-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-violet-300">Top Talent</p>
                <h3 class="mt-2 text-3xl font-black leading-tight text-white sm:text-4xl">Work with verified<br>IT experts only</h3>
                <p class="mt-4 max-w-md text-sm leading-7 text-white/50">Every freelancer on LIMAX is vetted for technical skills, professionalism, and delivery. No guesswork just results.</p>
                <a href="{{ route('services.index') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-xs font-bold text-black hover:bg-white/90">
                    Browse Talent
                    <svg viewBox="0 0 24 24" fill="none" class="h-3.5 w-3.5"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=60"
                     alt="" class="mt-8 w-full rounded-xl object-cover opacity-60 sm:h-48">
            </div>
            {{-- Small cards --}}
            <div class="reveal reveal--right reveal-delay-1 rounded-2xl border border-white/8 bg-white/[0.04] p-6">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15">
                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-emerald-400"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="1.6"/><path d="M7.5 12L10.5 15L16.5 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white">Secure Payments</h3>
                <p class="mt-2 text-sm leading-6 text-white/40">Funds are held in escrow until you approve the delivery. 100% protected.</p>
            </div>
            <div class="reveal reveal--right reveal-delay-2 rounded-2xl border border-white/8 bg-white/[0.04] p-6">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sky-500/15">
                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-sky-400"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white">Lightning Fast</h3>
                <p class="mt-2 text-sm leading-6 text-white/40">Post a project and get proposals within hours, not days.</p>
            </div>
            <div class="reveal reveal--right reveal-delay-3 rounded-2xl border border-white/8 bg-white/[0.04] p-6">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15">
                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-amber-400"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white">Top Rated Only</h3>
                <p class="mt-2 text-sm leading-6 text-white/40">Real reviews from real clients. Filter by rating, category, and price.</p>
            </div>
        </div>
    </section>

    {{-- ════════════════════ CTA STRIP ════════════════════ --}}
    <section class="cta-gradient noise relative overflow-hidden px-5 py-28 sm:px-10">
        <div class="pointer-events-none absolute -left-24 -top-24 h-96 w-96 rounded-full bg-violet-700/30 blur-[120px]"></div>
        <div class="pointer-events-none absolute -bottom-24 right-0 h-96 w-96 rounded-full bg-indigo-600/25 blur-[120px]"></div>
        <div class="reveal relative z-10 mx-auto max-w-3xl text-center">
            <p class="mb-4 text-xs font-semibold uppercase tracking-[0.3em] text-white/40">Ready to start?</p>
            <h2 class="text-4xl font-black leading-tight tracking-tight text-white sm:text-6xl">The future of IT<br>freelancing is here.</h2>
            <p class="mx-auto mt-6 max-w-xl text-base leading-7 text-white/50">
                Browse hundreds of IT services, place your order, and track everything in one place — built for professionals who ship.
            </p>
            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('services.index') }}"
                   class="group inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-sm font-bold text-black transition hover:bg-white/90">
                    Get Started
                    <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 transition-transform group-hover:translate-x-1"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>
        </div>
    </section>

    <x-auth-footer />
</div>

<script>
(() => {
    // ── Scroll reveal ──
    const revealEls = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    revealEls.forEach(el => revealObserver.observe(el));

    // ── Parallax hero ──
    const heroBg = document.getElementById('hero-bg');
    if (heroBg) {
        window.addEventListener('scroll', () => {
            const y = window.scrollY;
            heroBg.style.transform = `scale(1.1) translateY(${y * 0.25}px)`;
        }, { passive: true });
    }
})();
</script>
@endsection
