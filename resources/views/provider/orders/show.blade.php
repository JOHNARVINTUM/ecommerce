@extends('layouts.app')
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-xl font-semibold text-gray-900">Order Information</h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 text-sm text-gray-700">
                <p><span class="font-semibold">Order Number:</span> {{ $order->order_number }}</p>
                <p><span class="font-semibold">Service:</span> {{ $order->serviceListing->title ?? 'N/A' }}</p>
                <p><span class="font-semibold">Customer Name:</span> {{ $order->customer_name }}</p>
                <p><span class="font-semibold">Customer Email:</span> {{ $order->customer_email }}</p>
                <p><span class="font-semibold">Phone:</span> {{ $order->customer_phone ?: 'N/A' }}</p>
                <p><span class="font-semibold">Address:</span> {{ $order->customer_address ?: 'N/A' }}</p>
                <p><span class="font-semibold">Preferred Date:</span> {{ $order->scheduled_date ? $order->scheduled_date->format('M d, Y') : 'Not set' }}</p>
                <p><span class="font-semibold">Preferred Time:</span> {{ $order->scheduled_time ?: 'Not set' }}</p>
                <p class="md:col-span-2"><span class="font-semibold">Notes:</span> {{ $order->notes ?: 'N/A' }}</p>
            </div>
        </div>

        <div class="rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-xl font-semibold text-gray-900">Update Status</h2>

            <form action="{{ route('provider.orders.update-status', $order) }}" method="POST" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Order Status</label>
                    <select name="status" id="status" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="pending" @selected($order->status === 'pending')>Pending</option>
                        <option value="confirmed" @selected($order->status === 'confirmed')>Confirmed</option>
                        <option value="in_progress" @selected($order->status === 'in_progress')>In Progress</option>
                        <option value="completed" @selected($order->status === 'completed')>Completed</option>
                        <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="payment_status" class="mb-2 block text-sm font-medium text-gray-700">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="unpaid" @selected($order->payment_status === 'unpaid')>Unpaid</option>
                        <option value="paid" @selected($order->payment_status === 'paid')>Paid</option>
                        <option value="refunded" @selected($order->payment_status === 'refunded')>Refunded</option>
                    </select>
                    @error('payment_status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
</div>
@endsection