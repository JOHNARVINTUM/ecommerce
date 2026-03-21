<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'admin', 403);

        $orders = Order::with(['serviceListing', 'customer', 'provider'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'admin', 403);

        $order->load(['serviceListing', 'customer', 'provider']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'admin', 403);

        $validated = $request->validate([
            'status' => ['required', Rule::in([
                Order::STATUS_PENDING,
                Order::STATUS_CONFIRMED,
                Order::STATUS_IN_PROGRESS,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELLED,
            ])],
            'payment_status' => ['required', Rule::in([
                Order::PAYMENT_UNPAID,
                Order::PAYMENT_PAID,
                Order::PAYMENT_REFUNDED,
            ])],
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully.');
    }
}