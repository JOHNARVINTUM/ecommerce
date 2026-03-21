@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <h1 class="text-2xl font-bold text-white">Notifications</h1>
        <p class="mt-2 text-white/65">Latest order activity across the platform.</p>

        <div class="mt-6 space-y-3">
            @forelse ($notifications as $notification)
                <div class="rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-medium text-white">{{ $notification['message'] }}</p>
                        <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold {{ $notification['status_color'] }}">
                            {{ $notification['status_label'] }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-white/60">{{ $notification['time'] ?? 'Just now' }}</p>
                </div>
            @empty
                <p class="text-sm text-white/60">No notifications yet.</p>
            @endforelse
        </div>
    </div>
@endsection
