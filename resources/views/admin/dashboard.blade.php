@extends('layouts.admin')

@section('content')
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Successful Projects</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $successfulProjects }}</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">In Progress</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $inProgressProjects }}</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Cancelled</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $cancelledProjects }}</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Users</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $totalUsers }}</h2>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
            <h3 class="text-lg font-semibold text-slate-900">Orders Overview</h3>
            <div class="mt-6 flex h-64 items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 text-sm text-slate-500">
                Chart section placeholder
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900">Recent Status</h3>
            <div class="mt-4 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Pending Orders</span>
                    <x-status-badge status="pending" />
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Successful Orders</span>
                    <x-status-badge status="successful" />
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Cancelled Orders</span>
                    <x-status-badge status="cancelled" />
                </div>
            </div>
        </div>
    </div>
@endsection