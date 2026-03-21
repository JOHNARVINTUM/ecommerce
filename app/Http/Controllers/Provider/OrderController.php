<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'provider', 403);

        $orders = Order::with(['serviceListing', 'customer'])
            ->where('provider_user_id', $user->id)
            ->latest()
            ->paginate(10);

        $newOrdersCount = Order::where('provider_user_id', $user->id)
            ->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_CONFIRMED])
            ->count();

        return view('provider.orders.index', compact('orders', 'newOrdersCount'));
    }

    public function show(Order $order)
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'provider', 403);
        abort_unless($order->provider_user_id === $user->id, 403);

        $order->load(['serviceListing', 'customer']);

        return view('provider.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'provider', 403);
        abort_unless($order->provider_user_id === $user->id, 403);

        $validated = $request->validate([
            'status' => ['required', 'in:in_progress,completed'],
            'payment_status' => ['required', 'in:unpaid,paid,refunded'],
        ]);

        $order->update($validated);

        return redirect()
            ->route('provider.orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
}
