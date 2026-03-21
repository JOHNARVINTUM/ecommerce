@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Admin Order Details</h1>
            <p class="mt-2 text-white/65">Complete platform-level booking information.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <div class="md:col-span-2 rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
            <h2 class="mb-4 text-xl font-semibold text-white">Order Overview</h2>

            <div class="grid grid-cols-1 gap-4 text-sm text-white/80 md:grid-cols-2">
                <p><span class="font-semibold">Order Number:</span> {{ $order->order_number }}</p>
                <p><span class="font-semibold">Service:</span> {{ $order->serviceListing->title ?? 'N/A' }}</p>
                <p><span class="font-semibold">Customer:</span> {{ $order->customer->name ?? $order->customer_name }}</p>
                <p><span class="font-semibold">Provider:</span> {{ $order->provider->name ?? 'N/A' }}</p>
                <p><span class="font-semibold">Amount:</span> PHP {{ number_format($order->amount, 2) }}</p>
                <p>
                    <span class="font-semibold">Status:</span>
                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $order->status_color }}">{{ $order->status_label }}</span>
                </p>
                <p><span class="font-semibold">Payment:</span> {{ ucfirst($order->payment_status) }}</p>
                <p><span class="font-semibold">Preferred Date:</span> {{ $order->scheduled_date ? $order->scheduled_date->format('M d, Y') : 'Not set' }}</p>
                <p><span class="font-semibold">Preferred Time:</span> {{ $order->scheduled_time ?: 'Not set' }}</p>
                <p class="md:col-span-2"><span class="font-semibold">Notes:</span> {{ $order->notes ?: 'N/A' }}</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                <h2 class="mb-4 text-xl font-semibold text-white">Customer Contact</h2>

                <div class="space-y-3 text-sm text-white/80">
                    <p><span class="font-semibold">Name:</span> {{ $order->customer_name }}</p>
                    <p><span class="font-semibold">Email:</span> {{ $order->customer_email }}</p>
                    <p><span class="font-semibold">Phone:</span> {{ $order->customer_phone ?: 'N/A' }}</p>
                    <p><span class="font-semibold">Address:</span> {{ $order->customer_address ?: 'N/A' }}</p>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                <h2 class="mb-4 text-xl font-semibold text-white">Update Status</h2>
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="mb-2 block text-sm font-medium text-white/85">Order Status</label>
                        <select name="status" id="status" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white focus:border-white/35 focus:ring-white/20">
                            @foreach (['pending' => 'Pending', 'confirmed' => 'Confirmed', 'in_progress' => 'On Going', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $order->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="payment_status" class="mb-2 block text-sm font-medium text-white/85">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white focus:border-white/35 focus:ring-white/20">
                            @foreach (['unpaid' => 'Unpaid', 'paid' => 'Paid', 'refunded' => 'Refunded'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('payment_status', $order->payment_status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
