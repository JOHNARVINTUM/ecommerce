@extends('layouts.guest')

@section('content')
    <section class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 text-white">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <span class="inline-flex rounded-full bg-white/10 px-4 py-1.5 text-sm font-medium text-slate-200">
                        Digital Services Marketplace
                    </span>

                    <h1 class="mt-6 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                        Find skilled providers for your next project
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-slate-300">
                        LIMAX connects customers with trusted professionals in development, design, editing, branding,
                        and more.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('services.index') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-100">
                            Explore Services
                        </a>
                        <a href="{{ route('about') }}" class="rounded-xl border border-white/20 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10">
                            Learn More
                        </a>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    @forelse($featuredCategories->take(4) as $category)
                        <div class="rounded-2xl bg-white/10 p-6 backdrop-blur">
                            <h3 class="text-lg font-semibold">{{ $category->name }}</h3>
                            <p class="mt-2 text-sm text-slate-300">
                                {{ $category->description ?: 'Browse trusted services in this category.' }}
                            </p>
                        </div>
                    @empty
                        <div class="rounded-2xl bg-white/10 p-6 backdrop-blur">
                            <h3 class="text-lg font-semibold">Web Development</h3>
                            <p class="mt-2 text-sm text-slate-300">Custom websites, Laravel systems, and full-stack builds.</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-6 backdrop-blur">
                            <h3 class="text-lg font-semibold">Graphic Design</h3>
                            <p class="mt-2 text-sm text-slate-300">Branding, social media creatives, and design assets.</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-6 backdrop-blur">
                            <h3 class="text-lg font-semibold">Video Editing</h3>
                            <p class="mt-2 text-sm text-slate-300">Promos, reels, tutorials, and polished content delivery.</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-6 backdrop-blur">
                            <h3 class="text-lg font-semibold">UI / UX Design</h3>
                            <p class="mt-2 text-sm text-slate-300">Landing pages, dashboards, and product interface design.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">Popular Categories</h2>
                    <p class="mt-2 text-slate-600">Start with the services most customers look for.</p>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($featuredCategories as $category)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <h3 class="text-lg font-semibold text-slate-900">{{ $category->name }}</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            {{ $category->description ?: 'Discover quality providers in this category.' }}
                        </p>
                        <a href="{{ route('services.index', ['category' => $category->id]) }}" class="mt-4 inline-block text-sm font-semibold text-slate-900">
                            Browse category →
                        </a>
                    </div>
                @empty
                    <p class="text-slate-600">No categories available yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">Featured Services</h2>
                    <p class="mt-2 text-slate-600">Explore some of the latest active services on LIMAX.</p>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($featuredServices as $service)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <p class="text-sm text-slate-500">
                            {{ $service->category->name ?? 'Uncategorized' }}
                        </p>

                        <h3 class="mt-2 text-lg font-semibold text-slate-900">
                            {{ $service->title }}
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            {{ \Illuminate\Support\Str::limit($service->description, 90) }}
                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-base font-bold text-slate-900">
                                ₱{{ number_format($service->price, 2) }}
                            </span>

                            <a href="{{ route('services.show', $service) }}" class="text-sm font-semibold text-slate-900">
                                View →
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-600">No services available yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Why choose LIMAX?</h2>
                <p class="mt-3 text-slate-600">Built for simple service discovery, fast communication, and secure order handling.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900">Trusted providers</h3>
                    <p class="mt-2 text-sm text-slate-600">Work with verified providers and review service details before ordering.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900">Easy checkout</h3>
                    <p class="mt-2 text-sm text-slate-600">Add services to cart, review your order, and complete checkout cleanly.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900">Direct messaging</h3>
                    <p class="mt-2 text-sm text-slate-600">Contact providers directly to clarify project requirements before ordering.</p>
                </div>
            </div>
        </div>
    </section>
@endsection