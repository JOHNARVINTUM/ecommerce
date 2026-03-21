@extends('layouts.provider')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-white/45">Provider Workspace</p>
            <h1 class="mt-2 text-3xl font-bold text-white">Orders</h1>
            <p class="mt-2 text-white/65">Manage bookings made for your services.</p>
        </div>
        <div class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90">
            New Orders: {{ $newOrdersCount }}
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-white/[0.03]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-white">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 text-sm text-white/85">{{ $order->customer->name ?? $order->customer_name }}</td>
                            <td class="px-6 py-4 text-sm text-white/85">{{ $order->serviceListing->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-white/85">PHP {{ number_format($order->amount, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-white/85">{{ $order->status_label }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('provider.orders.show', $order) }}" class="font-medium text-indigo-300 hover:text-indigo-200">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-white/60">
                                No provider orders found yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $orders->links() }}
    </div>
</div>
@endsection
