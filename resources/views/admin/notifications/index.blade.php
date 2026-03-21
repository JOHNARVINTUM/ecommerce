@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-white bg-white/60 p-6 shadow-lg backdrop-blur-md">
        <h1 class="text-2xl font-bold text-white">Notifications</h1>
        <p class="mt-2 text-white/80">Latest order activity across the platform.</p>

        <div class="mt-6 space-y-3">
            @forelse ($notifications as $notification)
                <div class="rounded-xl border border-white bg-white/30 px-4 py-3 shadow">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-medium text-white">{{ $notification['message'] }}</p>
                        <span class="shrink-0 rounded-full bg-white/60 px-2.5 py-1 text-xs font-semibold text-slate-800">
                            {{ $notification['status_label'] }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-white/80">{{ $notification['time'] ?? 'Just now' }}</p>
                </div>
            @empty
                <p class="text-sm text-white/80">No notifications yet.</p>
            @endforelse
        </div>
    </div>
@endsection
