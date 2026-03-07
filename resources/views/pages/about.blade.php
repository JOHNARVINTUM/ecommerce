@extends('layouts.guest')

@section('content')
    <section class="bg-slate-900 py-20 text-white">
        <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">About LIMAX</h1>
            <p class="mx-auto mt-6 max-w-3xl text-lg leading-8 text-slate-300">
                LIMAX is a digital marketplace built to connect customers with reliable creative and technical service providers.
            </p>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Our mission</h2>
                <p class="mt-4 text-slate-600 leading-7">
                    We make it easier for businesses and individuals to discover quality service providers in one place.
                    From web development to design and editing, LIMAX gives customers a simple path from discovery to delivery.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                <h3 class="text-xl font-semibold text-slate-900">What we offer</h3>
                <ul class="mt-4 space-y-3 text-slate-600">
                    <li>• Curated service categories</li>
                    <li>• Clear service listings</li>
                    <li>• Provider communication tools</li>
                    <li>• Cart and checkout flow</li>
                    <li>• Admin management tools</li>
                </ul>
            </div>
        </div>
    </section>
@endsection