@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Admin Order Details</h1>
            <p class="mt-2 text-gray-600">Complete platform-level booking information.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="rounded-lg border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <div class="md:col-span-2 rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-xl font-semibold text-gray-900">Order Overview</h2>

            <div class="grid grid-cols-1 gap-4 text-sm text-gray-700 md:grid-cols-2">
                <p><span class="font-semibold">Order Number:</span> {{ $order->order_number }}</p>
                <p><span class="font-semibold">Service:</span> {{ $order->serviceListing->title ?? 'N/A' }}</p>
                <p><span class="font-semibold">Customer:</span> {{ $order->customer->name ?? $order->customer_name }}</p>
                <p><span class="font-semibold">Provider:</span> {{ $order->provider->name ?? 'N/A' }}</p>
                <p><span class="font-semibold">Amount:</span> PHP {{ number_format($order->amount, 2) }}</p>
                <p><span class="font-semibold">Status:</span> {{ str_replace('_', ' ', ucfirst($order->status)) }}</p>
                <p><span class="font-semibold">Payment:</span> {{ ucfirst($order->payment_status) }}</p>
                <p><span class="font-semibold">Preferred Date:</span> {{ $order->scheduled_date ? $order->scheduled_date->format('M d, Y') : 'Not set' }}</p>
                <p><span class="font-semibold">Preferred Time:</span> {{ $order->scheduled_time ?: 'Not set' }}</p>
                <p class="md:col-span-2"><span class="font-semibold">Notes:</span> {{ $order->notes ?: 'N/A' }}</p>
            </div>
        </div>

        <div class="rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-xl font-semibold text-gray-900">Customer Contact</h2>

            <div class="space-y-3 text-sm text-gray-700">
                <p><span class="font-semibold">Name:</span> {{ $order->customer_name }}</p>
                <p><span class="font-semibold">Email:</span> {{ $order->customer_email }}</p>
                <p><span class="font-semibold">Phone:</span> {{ $order->customer_phone ?: 'N/A' }}</p>
                <p><span class="font-semibold">Address:</span> {{ $order->customer_address ?: 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection