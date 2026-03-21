@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Notifications</h1>
        <p class="mt-2 text-slate-600">Latest order activity across the platform.</p>

        <div class="mt-6 space-y-3">
            @forelse ($notifications as $notification)
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-medium text-slate-800">{{ $notification['message'] }}</p>
                        <span class="shrink-0 rounded-full bg-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-700">
                            {{ $notification['status_label'] }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-slate-500">{{ $notification['time'] ?? 'Just now' }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">No notifications yet.</p>
            @endforelse
        </div>
    </div>
@endsection
