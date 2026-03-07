<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'customer', 403);

        $orders = Order::with(['serviceListing', 'provider'])
            ->where('customer_user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('pages.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'customer', 403);
        abort_unless($order->customer_user_id === $user->id, 403);

        $order->load(['serviceListing', 'provider']);

        return view('pages.orders.show', compact('order'));
    }
}