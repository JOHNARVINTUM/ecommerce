@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">Customer Overview</h1>
                    <p class="mt-1 text-white/65">Detailed account summary and order activity.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 hover:border-white/35 hover:bg-white/10">
                    Back to Users
                </a>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs uppercase text-white/45">Customer Name</p>
                    <p class="mt-1 text-sm font-semibold text-white">{{ $user->profile->full_name ?? $user->name }}</p>
                </div>
                <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs uppercase text-white/45">Email</p>
                    <p class="mt-1 text-sm font-semibold text-white">{{ $user->email }}</p>
                </div>
                <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs uppercase text-white/45">Role</p>
                    <p class="mt-1 text-sm font-semibold text-white">{{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <div class="mt-4 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs uppercase text-white/45">User ID</p>
                    <p class="mt-1 text-sm font-semibold text-white">{{ $user->id }}</p>
                </div>
                <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs uppercase text-white/45">Email Verified</p>
                    <p class="mt-1 text-sm font-semibold text-white">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y h:i A') : 'Not verified' }}</p>
                </div>
                <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs uppercase text-white/45">Member Since</p>
                    <p class="mt-1 text-sm font-semibold text-white">{{ $user->created_at?->format('M d, Y h:i A') }}</p>
                </div>
            </div>

            @if ($user->role === 'customer')
                <div class="mt-8 border-t border-white/10 pt-6">
                    <h2 class="text-lg font-semibold text-white">Customer Profile Information</h2>
                    <div class="mt-4 grid gap-4 md:grid-cols-3">
                        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                            <p class="text-xs uppercase text-white/45">Phone</p>
                            <p class="mt-1 text-sm font-semibold text-white">{{ $user->profile->phone ?? ($latestCustomerOrder->customer_phone ?? 'N/A') }}</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                            <p class="text-xs uppercase text-white/45">Location</p>
                            <p class="mt-1 text-sm font-semibold text-white">{{ $user->profile->location ?? 'N/A' }}</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4 md:col-span-3">
                            <p class="text-xs uppercase text-white/45">Address</p>
                            <p class="mt-1 text-sm font-semibold text-white">{{ $latestCustomerOrder->customer_address ?? 'N/A' }}</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4 md:col-span-3">
                            <p class="text-xs uppercase text-white/45">Bio</p>
                            <p class="mt-1 text-sm font-semibold text-white">{{ $user->profile->bio ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if ($user->role === 'customer')

            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                    <p class="text-sm text-white/60">Total Orders</p>
                    <p class="mt-2 text-2xl font-bold text-white">{{ $orderStats['total'] }}</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                    <p class="text-sm text-white/60">Completed</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-300">{{ $orderStats['completed'] }}</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                    <p class="text-sm text-white/60">On Going</p>
                    <p class="mt-2 text-2xl font-bold text-amber-300">{{ $orderStats['ongoing'] }}</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                    <p class="text-sm text-white/60">Cancelled</p>
                    <p class="mt-2 text-2xl font-bold text-rose-300">{{ $orderStats['cancelled'] }}</p>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                <h2 class="text-lg font-semibold text-white">Recent Orders</h2>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/10">
                        <thead class="bg-white/[0.03]">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/45">Order #</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/45">Service</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/45">Provider</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/45">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/45">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse ($customerOrders as $order)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-white">{{ $order->order_number }}</td>
                                    <td class="px-4 py-3 text-sm text-white/80">{{ $order->serviceListing->title ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-white/80">{{ $order->provider->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-white/80">PHP {{ number_format($order->amount, 2) }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $order->status_color }}">{{ $order->status_label }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-sm text-white/60">No orders yet.</td>
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
            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                <p class="text-sm text-white/60">This account is not a customer, so customer order overview is not available.</p>
            </div>
        @endif
    </div>
@endsection
