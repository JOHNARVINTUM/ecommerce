@extends('layouts.provider')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-white/45">Provider Workspace</p>
            <h1 class="mt-2 text-3xl font-bold text-white">Order Details</h1>
            <p class="mt-2 text-white/65">Review booking details and update progress.</p>
        </div>
        <a href="{{ route('provider.orders.index') }}" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 hover:border-white/35 hover:bg-white/10">
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)] lg:col-span-2">
            <h2 class="mb-4 text-xl font-semibold text-white">Order Information</h2>

            <div class="grid grid-cols-1 gap-4 text-sm text-white/85 md:grid-cols-2">
                <p><span class="font-semibold text-white">Order Number:</span> {{ $order->order_number }}</p>
                <p><span class="font-semibold text-white">Service:</span> {{ $order->serviceListing->title ?? 'N/A' }}</p>
                <p><span class="font-semibold text-white">Current Status:</span> {{ $order->status_label }}</p>
                <p><span class="font-semibold text-white">Payment Status:</span> {{ ucfirst($order->payment_status) }}</p>
                <p><span class="font-semibold text-white">Customer Name:</span> {{ $order->customer_name }}</p>
                <p><span class="font-semibold text-white">Customer Email:</span> {{ $order->customer_email }}</p>
                <p><span class="font-semibold text-white">Phone:</span> {{ $order->customer_phone ?: 'N/A' }}</p>
                <p><span class="font-semibold text-white">Address:</span> {{ $order->customer_address ?: 'N/A' }}</p>
                <p><span class="font-semibold text-white">Preferred Date:</span> {{ $order->scheduled_date ? $order->scheduled_date->format('M d, Y') : 'Not set' }}</p>
                <p><span class="font-semibold text-white">Preferred Time:</span> {{ $order->scheduled_time ?: 'Not set' }}</p>
                <p class="md:col-span-2"><span class="font-semibold text-white">Notes:</span> {{ $order->notes ?: 'N/A' }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
            <h2 class="mb-4 text-xl font-semibold text-white">Update Status</h2>

            <form action="{{ route('provider.orders.update-status', $order) }}" method="POST" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="status" class="mb-2 block text-sm font-medium text-white/90">Order Status</label>
                    <select name="status" id="status" class="w-full rounded-lg border border-white/15 bg-[#0d0e13] text-white focus:border-indigo-400 focus:ring-indigo-400">
                        <option value="in_progress" @selected($order->status === 'in_progress')>On Going</option>
                        <option value="completed" @selected($order->status === 'completed')>Completed</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-rose-200">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="payment_status" class="mb-2 block text-sm font-medium text-white/90">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="w-full rounded-lg border border-white/15 bg-[#0d0e13] text-white focus:border-indigo-400 focus:ring-indigo-400">
                        <option value="unpaid" @selected($order->payment_status === 'unpaid')>Unpaid</option>
                        <option value="paid" @selected($order->payment_status === 'paid')>Paid</option>
                        <option value="refunded" @selected($order->payment_status === 'refunded')>Refunded</option>
                    </select>
                    @error('payment_status')
                        <p class="mt-1 text-sm text-rose-200">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-white px-4 py-3 text-sm font-semibold text-[#111] hover:bg-white/90">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
