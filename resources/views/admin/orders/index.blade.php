@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">All Orders</h1>
        <p class="mt-2 text-gray-600">Admin overview of all bookings in the platform.</p>
    </div>

    <div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Provider</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $order->customer->name ?? $order->customer_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $order->provider->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $order->serviceListing->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">PHP {{ number_format($order->amount, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $order->status_label }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
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
