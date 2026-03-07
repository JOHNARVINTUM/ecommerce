@extends('layouts.guest')

@section('content')
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Browse Services</h1>
                <p class="mt-2 text-slate-600">Find services from trusted LIMAX providers.</p>
            </div>

            <form method="GET" action="{{ route('services.index') }}" class="mb-10 grid gap-4 md:grid-cols-3">
                <div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search services..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none"
                    >
                </div>

                <div>
                    <select
                        name="category"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none"
                    >
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                        Filter Services
                    </button>
                </div>
            </form>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($services as $service)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <p class="text-sm text-slate-500">
                            {{ $service->category->name ?? 'Uncategorized' }}
                        </p>

                        <h3 class="mt-2 text-lg font-semibold text-slate-900">
                            {{ $service->title }}
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            {{ $service->short_description ?: \Illuminate\Support\Str::limit($service->description, 100) }}
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
                    <p class="text-slate-600">No services found.</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $services->links() }}
            </div>
        </div>
    </section>
@endsection