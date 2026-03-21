@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Customer Overview</h1>
                    <p class="mt-1 text-slate-600">Detailed account summary and order activity.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Back to Users
                </a>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs uppercase text-slate-500">Customer Name</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->profile->full_name ?? $user->name }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs uppercase text-slate-500">Email</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->email }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs uppercase text-slate-500">Role</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <div class="mt-4 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs uppercase text-slate-500">User ID</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->id }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs uppercase text-slate-500">Email Verified</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y h:i A') : 'Not verified' }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs uppercase text-slate-500">Member Since</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->created_at?->format('M d, Y h:i A') }}</p>
                </div>
            </div>

            @if ($user->role === 'customer')
                <div class="mt-8 border-t border-slate-200 pt-6">
                    <h2 class="text-lg font-semibold text-slate-900">Customer Profile Information</h2>
                    <div class="mt-4 grid gap-4 md:grid-cols-3">
                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs uppercase text-slate-500">Phone</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->profile->phone ?? ($latestCustomerOrder->customer_phone ?? 'N/A') }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs uppercase text-slate-500">Location</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->profile->location ?? 'N/A' }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 md:col-span-3">
                            <p class="text-xs uppercase text-slate-500">Address</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $latestCustomerOrder->customer_address ?? 'N/A' }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 md:col-span-3">
                            <p class="text-xs uppercase text-slate-500">Bio</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->profile->bio ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if ($user->role === 'customer')

            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Orders</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">{{ $orderStats['total'] }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Completed</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $orderStats['completed'] }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">On Going</p>
                    <p class="mt-2 text-2xl font-bold text-amber-700">{{ $orderStats['ongoing'] }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Cancelled</p>
                    <p class="mt-2 text-2xl font-bold text-rose-700">{{ $orderStats['cancelled'] }}</p>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Recent Orders</h2>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Order #</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Service</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Provider</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($customerOrders as $order)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $order->order_number }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-700">{{ $order->serviceListing->title ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-700">{{ $order->provider->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-700">PHP {{ number_format($order->amount, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-700">{{ $order->status_label }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $customerOrders->links() }}
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-600">This account is not a customer, so customer order overview is not available.</p>
            </div>
        @endif
    </div>
@endsection
