<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'admin', 403);

        $orders = Order::with(['serviceListing', 'customer', 'provider'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'admin', 403);

        $order->load(['serviceListing', 'customer', 'provider']);

        return view('admin.orders.show', compact('order'));
    }
}