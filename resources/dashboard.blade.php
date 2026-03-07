@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Dashboard</h1>
        <p class="mt-2 text-slate-600">Welcome back to LIMAX.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Active Orders</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">0</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Messages</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">0</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Cart Items</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">0</h2>
        </div>
    </div>
@endsection