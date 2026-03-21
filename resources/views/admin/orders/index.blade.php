@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">All Orders</h1>
        <p class="mt-2 text-white/65">Admin overview of all bookings in the platform.</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Provider</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-white/60">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10 bg-transparent">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-white">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 text-sm text-white/80">{{ $order->customer->name ?? $order->customer_name }}</td>
                            <td class="px-6 py-4 text-sm text-white/80">{{ $order->provider->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-white/80">{{ $order->serviceListing->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-white/80">PHP {{ number_format($order->amount, 2) }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $order->status_color }}">{{ $order->status_label }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-indigo-300 hover:text-indigo-200">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-white/60">
                                No orders found yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
